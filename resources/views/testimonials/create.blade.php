@extends('layouts.app')

@section('title', 'Berikan Testimoni')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="space-y-6">
        <!-- Header -->
        <div class="text-center">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Berikan Testimoni</h1>
            <p class="text-gray-600">Bagikan pengalaman Anda dengan produk strawberry kami</p>
        </div>

        <!-- Form -->
        <div class="bg-white shadow-lg rounded-xl overflow-hidden">
            <form action="{{ route('testimonials.store') }}" method="POST" class="p-6 sm:p-8">
                @csrf
                
                <div class="space-y-6">
                    <!-- Name -->
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap</label>
                        <input type="text" name="name" id="name" value="{{ old('name', Auth::user()->name) }}" required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-sky-500 focus:border-sky-500 transition @error('name') border-red-300 @enderror">
                        @error('name')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                        <input type="email" name="email" id="email" value="{{ old('email', Auth::user()->email) }}" required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-sky-500 focus:border-sky-500 transition @error('email') border-red-300 @enderror">
                        @error('email')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Rating -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Rating</label>
                        <div class="flex items-center space-x-2">
                            @for($i = 1; $i <= 5; $i++)
                                <label class="cursor-pointer">
                                    <input type="radio" name="rating" value="{{ $i }}" {{ old('rating', 5) == $i ? 'checked' : '' }}
                                        class="sr-only rating-input">
                                    <svg class="w-8 h-8 rating-star {{ old('rating', 5) >= $i ? 'text-yellow-400' : 'text-gray-300' }}" 
                                         fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                    </svg>
                                </label>
                            @endfor
                            <span class="ml-2 text-sm text-gray-600">
                                <span id="rating-text">{{ old('rating', 5) }}</span>/5 bintang
                            </span>
                        </div>
                        @error('rating')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Message -->
                    <div>
                        <label for="message" class="block text-sm font-medium text-gray-700 mb-2">Testimoni</label>
                        <textarea name="message" id="message" rows="6" required
                            placeholder="Bagikan pengalaman Anda dengan produk strawberry kami..."
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-sky-500 focus:border-sky-500 transition resize-none @error('message') border-red-300 @enderror">{{ old('message') }}</textarea>
                        <p class="mt-2 text-sm text-gray-500">Minimal 10 karakter, maksimal 1000 karakter</p>
                        @error('message')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Submit Button -->
                    <div class="flex justify-end space-x-3">
                        <a href="{{ route('testimonials.index') }}" class="px-6 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition">
                            Batal
                        </a>
                        <button type="submit" class="px-6 py-3 bg-gradient-to-r from-sky-500 to-indigo-500 text-white font-semibold rounded-lg hover:from-sky-600 hover:to-indigo-600 transition shadow-lg hover:shadow-xl">
                            <svg class="w-4 h-4 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                            </svg>
                            Kirim Testimoni
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// Rating stars interaction
document.addEventListener('DOMContentLoaded', function() {
    const ratingInputs = document.querySelectorAll('.rating-input');
    const ratingStars = document.querySelectorAll('.rating-star');
    const ratingText = document.getElementById('rating-text');

    ratingInputs.forEach((input, index) => {
        input.addEventListener('change', function() {
            const rating = parseInt(this.value);
            
            // Update star colors
            ratingStars.forEach((star, starIndex) => {
                if (starIndex < rating) {
                    star.classList.remove('text-gray-300');
                    star.classList.add('text-yellow-400');
                } else {
                    star.classList.remove('text-yellow-400');
                    star.classList.add('text-gray-300');
                }
            });
            
            // Update rating text
            ratingText.textContent = rating;
        });
    });

    // Hover effect for stars
    ratingStars.forEach((star, index) => {
        star.addEventListener('mouseenter', function() {
            const hoverRating = index + 1;
            ratingStars.forEach((s, sIndex) => {
                if (sIndex < hoverRating) {
                    s.classList.add('text-yellow-300');
                }
            });
        });
        
        star.addEventListener('mouseleave', function() {
            ratingStars.forEach(s => {
                s.classList.remove('text-yellow-300');
            });
        });
    });
});
</script>
@endsection
