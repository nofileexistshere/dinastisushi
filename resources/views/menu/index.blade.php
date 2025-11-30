@extends('layouts.app')

@section('title', 'Menu Sushi - Dinasti Sushi')

@section('content')
<div class="min-h-screen">
    <!-- Header -->
    <header class="bg-white border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-4 text-sm sm:text-base">
                <div class="flex items-center">
                    <a href="{{ route('dashboard') }}" class="mr-4">
                        <svg class="w-6 h-6 text-gray-600 hover:text-pink-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd"/>
                        </svg>
                    </a>
                    <h1 class="text-2xl font-bold text-gray-900">Menu Sushi</h1>
                </div>
                
                <a href="{{ route('history.index') }}" class="flex items-center text-gray-700 hover:text-pink-600 transition-colors">
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                    </svg>
                    Histori
                </a>
            </div>
        </div>
    </header>
    
    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Search and Filter -->
        <div class="bg-white rounded-2xl sm:rounded-3xl shadow-lg p-4 sm:p-6 mb-6 sm:mb-8">
            <form method="GET" action="{{ route('menu.index') }}" class="space-y-4">
                <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3 sm:space-x-4">
                    <div class="flex-grow">
                        <input 
                            type="text" 
                            name="search" 
                            value="{{ $search }}"
                            placeholder="Cari menu sushi..."
                            class="w-full px-4 sm:px-6 py-2 sm:py-3 border border-gray-300 rounded-full focus:ring-2 focus:ring-pink-500 focus:border-pink-500 text-sm sm:text-base"
                        >
                    </div>
                    <button 
                        type="submit" 
                        class="bg-gradient-to-r from-pink-500 to-orange-500 text-white font-semibold px-6 sm:px-8 py-2 sm:py-3 rounded-full hover:from-pink-600 hover:to-orange-600 transition-all text-sm sm:text-base"
                    >
                        Semua
                    </button>
                </div>
                
                <div class="flex flex-wrap gap-3">
                    <a href="{{ route('menu.index', ['category' => 'Semua', 'search' => $search]) }}" 
                       class="px-6 py-2 rounded-full font-medium transition-colors {{ $category === 'Semua' ? 'bg-pink-500 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                        Semua
                    </a>
                    <a href="{{ route('menu.index', ['category' => 'Nigiri', 'search' => $search]) }}" 
                       class="px-6 py-2 rounded-full font-medium transition-colors {{ $category === 'Nigiri' ? 'bg-pink-500 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                        Nigiri
                    </a>
                    <a href="{{ route('menu.index', ['category' => 'Maki', 'search' => $search]) }}" 
                       class="px-6 py-2 rounded-full font-medium transition-colors {{ $category === 'Maki' ? 'bg-pink-500 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                        Maki
                    </a>
                    <a href="{{ route('menu.index', ['category' => 'Sashimi', 'search' => $search]) }}" 
                       class="px-6 py-2 rounded-full font-medium transition-colors {{ $category === 'Sashimi' ? 'bg-pink-500 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                        Sashimi
                    </a>
                    <a href="{{ route('menu.index', ['category' => 'Special', 'search' => $search]) }}" 
                       class="px-6 py-2 rounded-full font-medium transition-colors {{ $category === 'Special' ? 'bg-pink-500 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                        Special
                    </a>
                </div>
            </form>
        </div>
        
        <!-- Menu Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($menuItems as $item)
                <div class="bg-white rounded-3xl shadow-lg overflow-hidden hover:shadow-xl transition-shadow">
                    <div class="relative">
                        <img 
                            src="{{ $item->image }}" 
                            alt="{{ $item->name }}"
                            class="w-full h-56 object-cover"
                        >
                        @if(in_array($item->id, $orderedMenuIds))
                            <span class="absolute top-4 left-4 bg-blue-500 text-white px-4 py-1 rounded-full text-sm font-semibold flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                                Pernah Dipesan
                            </span>
                        @endif
                    </div>
                    
                    <div class="p-6">
                        <div class="flex justify-between items-start mb-3">
                            <h3 class="text-xl font-bold text-gray-900">{{ $item->name }}</h3>
                            <span class="bg-gray-100 text-gray-700 px-3 py-1 rounded-full text-xs">
                                {{ $item->category }}
                            </span>
                        </div>
                        
                        <p class="text-gray-600 text-sm mb-4">{{ Str::limit($item->description, 80) }}</p>
                        
                        <div class="flex items-center mb-4">
                            <div class="flex text-yellow-500">
                                @for($i = 1; $i <= 5; $i++)
                                    @if($i <= floor($item->average_rating))
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                        </svg>
                                    @else
                                        <svg class="w-5 h-5 text-gray-300" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                        </svg>
                                    @endif
                                @endfor
                            </div>
                            <span class="ml-2 text-sm text-gray-600">({{ number_format($item->average_rating, 1) }})</span>
                        </div>
                        
                        @if($item->tags)
                            <div class="flex flex-wrap gap-2 mb-4">
                                @foreach($item->tags as $tag)
                                    <span class="bg-pink-50 text-pink-600 px-3 py-1 rounded-full text-xs">
                                        {{ $tag }}
                                    </span>
                                @endforeach
                            </div>
                        @endif
                        
                        <div class="flex justify-between items-center">
                            <p class="text-2xl font-bold text-pink-600">Rp {{ number_format($item->price, 0, ',', '.') }}</p>
                            
                            <form method="POST" action="{{ route('order.store') }}">
                                @csrf
                                <input type="hidden" name="menu_item_id" value="{{ $item->id }}">
                                <input type="hidden" name="quantity" value="1">
                                <button 
                                    type="submit" 
                                    class="bg-gradient-to-r from-pink-500 to-orange-500 text-white font-semibold px-6 py-2 rounded-xl hover:from-pink-600 hover:to-orange-600 transition-all flex items-center"
                                >
                                    <svg class="w-5 h-5 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M3 1a1 1 0 000 2h1.22l.305 1.222a.997.997 0 00.01.042l1.358 5.43-.893.892C3.74 11.846 4.632 14 6.414 14H15a1 1 0 000-2H6.414l1-1H14a1 1 0 00.894-.553l3-6A1 1 0 0017 3H6.28l-.31-1.243A1 1 0 005 1H3zM16 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM6.5 18a1.5 1.5 0 100-3 1.5 1.5 0 000 3z"/>
                                    </svg>
                                    Pesan
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-3 text-center py-12">
                    <p class="text-gray-600">Tidak ada menu yang ditemukan.</p>
                </div>
            @endforelse
        </div>
    </main>
</div>
@endsection
