@extends('layouts.app')

@section('title', 'Histori Pembelian - Dinasti Sushi')

@section('content')
<div class="min-h-screen">
    <!-- Header -->
    <header class="bg-white border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-4">
                <div class="flex items-center">
                    <a href="{{ route('dashboard') }}" class="mr-4">
                        <svg class="w-6 h-6 text-gray-600 hover:text-pink-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd"/>
                        </svg>
                    </a>
                    <h1 class="text-2xl font-bold text-gray-900">Histori Pembelian</h1>
                </div>
                
                <a href="{{ route('menu.index') }}" class="bg-gradient-to-r from-pink-500 to-orange-500 text-white font-semibold px-6 py-2 rounded-xl hover:from-pink-600 hover:to-orange-600 transition-all flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"/>
                        <path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z" clip-rule="evenodd"/>
                    </svg>
                    Lihat Menu
                </a>
            </div>
        </div>
    </header>
    
    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Statistics -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 sm:gap-6 mb-6 sm:mb-8">
            <div class="bg-white rounded-2xl sm:rounded-3xl shadow-lg p-4 sm:p-6">
                <div class="flex items-center">
                    <div class="bg-pink-100 rounded-full p-3 sm:p-4 mr-3 sm:mr-4">
                        <svg class="w-6 h-6 sm:w-8 sm:h-8 text-pink-600" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M3 1a1 1 0 000 2h1.22l.305 1.222a.997.997 0 00.01.042l1.358 5.43-.893.892C3.74 11.846 4.632 14 6.414 14H15a1 1 0 000-2H6.414l1-1H14a1 1 0 00.894-.553l3-6A1 1 0 0017 3H6.28l-.31-1.243A1 1 0 005 1H3zM16 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM6.5 18a1.5 1.5 0 100-3 1.5 1.5 0 000 3z"/>
                        </svg>
                    </div>
                    <div>
                        <div class="text-2xl sm:text-3xl font-bold text-gray-900">{{ $totalOrders }}</div>
                        <div class="text-xs sm:text-sm text-gray-600">Total Pesanan</div>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-2xl sm:rounded-3xl shadow-lg p-4 sm:p-6">
                <div class="flex items-center">
                    <div class="bg-orange-100 rounded-full p-3 sm:p-4 mr-3 sm:mr-4">
                        <svg class="w-6 h-6 sm:w-8 sm:h-8 text-orange-600" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M8.433 7.418c.155-.103.346-.196.567-.267v1.698a2.305 2.305 0 01-.567-.267C8.07 8.34 8 8.114 8 8c0-.114.07-.34.433-.582zM11 12.849v-1.698c.22.071.412.164.567.267.364.243.433.468.433.582 0 .114-.07.34-.433.582a2.305 2.305 0 01-.567.267z"/>
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a1 1 0 10-2 0v.092a4.535 4.535 0 00-1.676.662C6.602 6.234 6 7.009 6 8c0 .99.602 1.765 1.324 2.246.48.32 1.054.545 1.676.662v1.941c-.391-.127-.68-.317-.843-.504a1 1 0 10-1.51 1.31c.562.649 1.413 1.076 2.353 1.253V15a1 1 0 102 0v-.092a4.535 4.535 0 001.676-.662C13.398 13.766 14 12.991 14 12c0-.99-.602-1.765-1.324-2.246A4.535 4.535 0 0011 9.092V7.151c.391.127.68.317.843.504a1 1 0 101.511-1.31c-.563-.649-1.413-1.076-2.354-1.253V5z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <div>
                        <div class="text-xl sm:text-3xl font-bold text-gray-900">Rp {{ number_format($totalSpent, 0, ',', '.') }}</div>
                        <div class="text-xs sm:text-sm text-gray-600">Total Pengeluaran</div>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-2xl sm:rounded-3xl shadow-lg p-4 sm:p-6">
                <div class="flex items-center">
                    <div class="bg-green-100 rounded-full p-3 sm:p-4 mr-3 sm:mr-4">
                        <svg class="w-6 h-6 sm:w-8 sm:h-8 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                        </svg>
                    </div>
                    <div>
                        <div class="text-2xl sm:text-3xl font-bold text-gray-900">{{ number_format($averageRating, 1) }}</div>
                        <div class="text-xs sm:text-sm text-gray-600">Rating Rata-rata</div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Filter -->
        <div class="bg-white rounded-2xl sm:rounded-3xl shadow-lg p-4 sm:p-6 mb-6 sm:mb-8">
            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                <p class="text-gray-700 font-medium">Urutkan berdasarkan:</p>
                <div class="flex flex-wrap gap-3">
                    <a href="{{ route('history.index', ['sort' => 'date']) }}" 
                       class="px-6 py-2 rounded-xl font-medium transition-colors {{ $sortBy === 'date' ? 'bg-pink-500 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                        <svg class="w-5 h-5 inline mr-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/>
                        </svg>
                        Tanggal
                    </a>
                    <a href="{{ route('history.index', ['sort' => 'rating']) }}" 
                       class="px-6 py-2 rounded-xl font-medium transition-colors {{ $sortBy === 'rating' ? 'bg-pink-500 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                        <svg class="w-5 h-5 inline mr-1" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                        </svg>
                        Rating
                    </a>
                </div>
            </div>
        </div>
        
        <!-- Order History -->
        <div class="space-y-4 sm:space-y-6">
            @forelse($orders as $order)
                <div class="bg-white rounded-2xl sm:rounded-3xl shadow-lg p-4 sm:p-6 hover:shadow-xl transition-shadow">
                    <div class="flex flex-col sm:flex-row items-start gap-4 sm:gap-6">
                        <img 
                            src="{{ $order->menuItem->image }}" 
                            alt="{{ $order->menuItem->name }}"
                            class="w-full sm:w-40 h-48 sm:h-32 object-cover rounded-2xl flex-shrink-0"
                        >
                        
                        <div class="flex-grow w-full">
                            <div class="flex flex-col sm:flex-row justify-between items-start mb-3 gap-3">
                                <div>
                                    <h3 class="text-lg sm:text-xl font-bold text-gray-900 mb-1">{{ $order->menuItem->name }}</h3>
                                    <span class="bg-gray-100 text-gray-700 px-3 py-1 rounded-full text-sm">
                                        {{ $order->menuItem->category }}
                                    </span>
                                </div>
                                <div class="text-left sm:text-right">
                                    <p class="text-xl sm:text-2xl font-bold text-pink-600">Rp {{ number_format($order->total_price, 0, ',', '.') }}</p>
                                    <p class="text-xs sm:text-sm text-gray-500">{{ $order->created_at->format('d F Y') }}</p>
                                </div>
                            </div>
                            
                            <p class="text-sm sm:text-base text-gray-600 mb-4">{{ $order->menuItem->description }}</p>
                            
                            <div class="flex justify-between items-center">
                                @php
                                    $userRating = $order->menuItem->ratings->where('user_id', Auth::id())->first();
                                @endphp
                                
                                @if($userRating)
                                    <div class="flex items-center">
                                        <span class="text-sm text-gray-600 mr-2">Rating Anda:</span>
                                        <div class="flex text-yellow-500">
                                            @for($i = 1; $i <= 5; $i++)
                                                @if($i <= $userRating->rating)
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
                                        <span class="ml-2 text-sm text-gray-600">{{ $userRating->rating }}/5</span>
                                    </div>
                                @else
                                    <div class="text-sm text-gray-500">Belum ada rating</div>
                                @endif
                                
                                <form method="POST" action="{{ route('order.store') }}">
                                    @csrf
                                    <input type="hidden" name="menu_item_id" value="{{ $order->menu_item_id }}">
                                    <input type="hidden" name="quantity" value="1">
                                    <button 
                                        type="submit" 
                                        class="bg-gradient-to-r from-pink-500 to-orange-500 text-white font-semibold px-6 py-2 rounded-xl hover:from-pink-600 hover:to-orange-600 transition-all flex items-center"
                                    >
                                        <svg class="w-5 h-5 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M3 1a1 1 0 000 2h1.22l.305 1.222a.997.997 0 00.01.042l1.358 5.43-.893.892C3.74 11.846 4.632 14 6.414 14H15a1 1 0 000-2H6.414l1-1H14a1 1 0 00.894-.553l3-6A1 1 0 0017 3H6.28l-.31-1.243A1 1 0 005 1H3zM16 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM6.5 18a1.5 1.5 0 100-3 1.5 1.5 0 000 3z"/>
                                        </svg>
                                        Pesan Lagi
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="bg-white rounded-3xl shadow-lg p-12 text-center">
                    <p class="text-gray-600 mb-4">Belum ada histori pembelian.</p>
                    <a href="{{ route('menu.index') }}" class="inline-block bg-gradient-to-r from-pink-500 to-orange-500 text-white font-semibold px-6 py-3 rounded-xl hover:from-pink-600 hover:to-orange-600 transition-all">
                        Mulai Belanja
                    </a>
                </div>
            @endforelse
        </div>
    </main>
</div>
@endsection
