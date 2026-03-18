<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\StrawberryProduct;
use App\Models\Testimonial;
use Carbon\Carbon;

class AdminController extends Controller
{
    // Middleware is handled in routes/web.php

    /**
     * Show admin dashboard
     */
    public function dashboard(Request $request)
    {
        $selectedYear = (int) $request->query('year', now()->year);

        $yearOptions = User::selectRaw('YEAR(created_at) as year')
            ->union(Testimonial::selectRaw('YEAR(created_at) as year'))
            ->union(StrawberryProduct::selectRaw('YEAR(created_at) as year'))
            ->pluck('year')
            ->filter()
            ->unique()
            ->sort()
            ->values()
            ->all();

        if (empty($yearOptions)) {
            $yearOptions = [$selectedYear];
        }

        if (! in_array($selectedYear, $yearOptions, true)) {
            $selectedYear = max($yearOptions);
        }

        $totalUsers = User::count();
        $totalAdmins = User::where('role', 'admin')->count();
        $totalProducts = StrawberryProduct::count();
        $totalStock = StrawberryProduct::sum('stock_quantity');

        $recentUsers = User::latest()->take(5)->get();

        $months = collect(range(1, 12))->map(fn ($month) => Carbon::create($selectedYear, $month, 1));
        $userTrendLabels = $months->map(fn ($date) => $date->translatedFormat('M Y'))->values()->all();
        $userTrendData = $months->map(fn ($date) => User::whereBetween('created_at', [
            $date->copy()->startOfMonth(),
            $date->copy()->endOfMonth(),
        ])->count())->values()->all();

        // Group products by new status: Tersedia (active) and Tidak Tersedia (inactive + out_of_stock)
        $activeCount = StrawberryProduct::where('status', 'active')->count();
        $unavailableCount = StrawberryProduct::whereIn('status', ['inactive', 'out_of_stock'])->count();

        $productStatusLabels = ['Tersedia', 'Tidak Tersedia'];
        $productStatusData = [$activeCount, $unavailableCount];

        $userTrendMax = max($userTrendData) ?: 1;

        $testimonialRatings = Testimonial::select('rating', DB::raw('count(*) as total'))
            ->groupBy('rating')
            ->orderBy('rating')
            ->pluck('total', 'rating');

        $ratingLabels = collect(range(1, 5))->map(fn ($rating) => $rating . ' ⭐');
        $ratingData = collect(range(1, 5))->map(fn ($rating) => $testimonialRatings->get($rating, 0))->values()->all();
        $ratingMax = max($ratingData) ?: 1;

        $testimonialTrendRaw = $months->map(fn ($date) => [
            'label' => $date->translatedFormat('M Y'),
            'count' => Testimonial::whereBetween('created_at', [
                $date->copy()->startOfMonth(),
                $date->copy()->endOfMonth(),
            ])->count(),
        ]);

        $testimonialTrendLabels = $testimonialTrendRaw->pluck('label')->values()->all();
        $testimonialTrendData = $testimonialTrendRaw->pluck('count')->values()->all();
        $testimonialTrendMax = max($testimonialTrendData) ?: 1;

        return view('admin.dashboard', compact(
            'totalUsers',
            'totalAdmins',
            'totalProducts',
            'totalStock',
            'recentUsers',
            'userTrendLabels',
            'userTrendData',
            'productStatusLabels',
            'productStatusData',
            'userTrendMax',
            'ratingLabels',
            'ratingData',
            'ratingMax',
            'testimonialTrendLabels',
            'testimonialTrendData',
            'testimonialTrendMax',
            'yearOptions',
            'selectedYear'
        ));
    }

    /**
     * Show users management
     */
    public function users()
    {
        $users = User::latest()->paginate(10);
        return view('admin.users', compact('users'));
    }

    /**
     * Update user role
     */
    public function updateUserRole(Request $request, User $user)
    {
        $request->validate([
            'role' => 'required|in:user,admin'
        ]);

        $user->update(['role' => $request->role]);

        return back()->with('success', 'Role user berhasil diperbarui!');
    }

    /**
     * Delete user
     */
    public function deleteUser(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Tidak dapat menghapus akun sendiri!');
        }

        $user->delete();
        return back()->with('success', 'User berhasil dihapus!');
    }
}
