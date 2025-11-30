@extends('layouts.app')

@section('title', $menuItem->name . ' - Dinasti Sushi')

@section('content')
<div class="min-h-screen">
    <!-- Header -->
    <header class="bg-white border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-4">
                <div class="flex items-center">
                    <a href="{{ route('menu.index') }}" class="mr-4">
                        <svg class="w-6 h-6 text-gray-600 hover:text-pink-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd"/>
                        </svg>
                    </a>
                    <h1 class="text-2xl font-bold text-gray-900">Detail Menu</h1>
                </div>
            </div>
        </div>
    </header>
    
    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="bg-white rounded-3xl shadow-xl overflow-hidden">
            <div class="md:flex">
                <!-- Image -->
                <div class="md:w-1/2">
                    <img 
                        src="{{ $menuItem->image }}" 
                        alt="{{ $menuItem->name }}"
                        class="w-full h-full object-cover"
                    >
                </div>
                
                <!-- Details -->
                <div class="md:w-1/2 p-12">
                    <div class="mb-6">
                        <span class="bg-gray-100 text-gray-700 px-4 py-2 rounded-full text-sm font-medium">
                            {{ $menuItem->category }}
                        </span>
                    </div>
                    
                    <h2 class="text-4xl font-bold text-gray-900 mb-4">{{ $menuItem->name }}</h2>
                    
                    <p class="text-gray-600 text-lg mb-6">{{ $menuItem->description }}</p>
                    
                    <div class="flex items-center mb-6">
                        <div class="flex text-yellow-500">
                            @for($i = 1; $i <= 5; $i++)
                                @if($i <= floor($menuItem->average_rating))
                                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                    </svg>
                                @else
                                    <svg class="w-6 h-6 text-gray-300" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                    </svg>
                                @endif
                            @endfor
                        </div>
                        <span class="ml-3 text-lg text-gray-600">{{ number_format($menuItem->average_rating, 1) }} ({{ $menuItem->rating_count }} ulasan)</span>
                    </div>
                    
                    @if($menuItem->tags)
                        <div class="flex flex-wrap gap-2 mb-8">
                            @foreach($menuItem->tags as $tag)
                                <span class="bg-pink-50 text-pink-600 px-4 py-2 rounded-full text-sm font-medium">
                                    {{ $tag }}
                                </span>
                            @endforeach
                        </div>
                    @endif
                    
                    <div class="border-t border-gray-200 pt-6 mb-6">
                        <p class="text-4xl font-bold text-pink-600 mb-2">Rp {{ number_format($menuItem->price, 0, ',', '.') }}</p>
                    </div>
                    
                    <form method="POST" action="{{ route('order.store') }}" class="mb-6">
                        @csrf
                        <input type="hidden" name="menu_item_id" value="{{ $menuItem->id }}">
                        <div class="flex items-center space-x-4 mb-4">
                            <label for="quantity" class="text-gray-700 font-medium">Jumlah:</label>
                            <input 
                                type="number" 
                                name="quantity" 
                                id="quantity" 
                                value="1" 
                                min="1" 
                                max="10"
                                class="w-24 px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-pink-500 focus:border-pink-500"
                            >
                        </div>
                        <button 
                            type="submit" 
                            class="w-full bg-gradient-to-r from-pink-500 to-orange-500 text-white font-bold py-4 px-8 rounded-xl hover:from-pink-600 hover:to-orange-600 transition-all text-lg"
                        >
                            Tambah ke Pesanan
                        </button>
                    </form>
                    
                    <div class="grid grid-cols-3 gap-4">
                        <div class="bg-pink-50 rounded-xl p-4 text-center">
                            <div class="text-2xl font-bold text-pink-600">{{ $menuItem->rating_count }}</div>
                            <div class="text-sm text-gray-600">Ulasan</div>
                        </div>
                        
                        <div class="bg-orange-50 rounded-xl p-4 text-center">
                            <div class="text-2xl font-bold text-orange-600">{{ number_format($menuItem->average_rating, 1) }}</div>
                            <div class="text-sm text-gray-600">Rating</div>
                        </div>
                        
                        <div class="bg-green-50 rounded-xl p-4 text-center">
                            <div class="text-2xl font-bold text-green-600">{{ $similarUsersCount }}</div>
                            <div class="text-sm text-gray-600">User Serupa</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>
@endsection
