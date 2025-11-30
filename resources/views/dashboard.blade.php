@extends('layouts.app')

@section('title', 'Dashboard - Dinasti Sushi')

@section('content')
<div class="min-h-screen">
    <!-- Header -->
    <header class="bg-white border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center py-4 gap-4">
                <div>
                    <h1 class="text-xl sm:text-2xl font-bold text-gray-900">Dinasti Sushi</h1>
                    <p class="text-xs sm:text-sm text-gray-600">Sistem Rekomendasi AI</p>
                </div>
                
                <div class="flex items-center space-x-4 sm:space-x-6 text-sm sm:text-base">
                    <a href="{{ route('menu.index') }}" class="flex items-center text-gray-700 hover:text-pink-600 transition-colors">
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"/>
                            <path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z" clip-rule="evenodd"/>
                        </svg>
                        Menu
                    </a>
                    
                    <a href="{{ route('history.index') }}" class="flex items-center text-gray-700 hover:text-pink-600 transition-colors">
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                        </svg>
                        Histori
                    </a>
                    
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="flex items-center text-gray-700 hover:text-pink-600 transition-colors">
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M3 3a1 1 0 00-1 1v12a1 1 0 102 0V4a1 1 0 00-1-1zm10.293 9.293a1 1 0 001.414 1.414l3-3a1 1 0 000-1.414l-3-3a1 1 0 10-1.414 1.414L14.586 9H7a1 1 0 100 2h7.586l-1.293 1.293z" clip-rule="evenodd"/>
                            </svg>
                            Keluar
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </header>
    
    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        @if (session('success'))
            <div class="bg-green-50 border border-green-200 text-green-700 px-6 py-4 rounded-2xl mb-6 flex items-center">
                <svg class="w-6 h-6 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                {{ session('success') }}
            </div>
        @endif
        
        <!-- Welcome Banner -->
        <div class="bg-gradient-to-r from-pink-500 to-orange-500 rounded-2xl sm:rounded-3xl shadow-xl p-6 sm:p-8 mb-6 sm:mb-8 text-white">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
                <div>
                    <h2 class="text-2xl sm:text-3xl font-bold mb-2">Selamat Datang, {{ $user->name }}!</h2>
                    <p class="text-sm sm:text-lg opacity-90">Temukan menu sushi favorit Anda dengan rekomendasi personal</p>
                </div>
                
                <div class="grid grid-cols-2 gap-4 w-full md:w-auto md:flex md:space-x-6">
                    <div class="bg-white/20 rounded-2xl px-4 sm:px-8 py-3 sm:py-4 text-center backdrop-blur-sm">
                        <div class="text-2xl sm:text-4xl font-bold">{{ $totalOrders }}</div>
                        <div class="text-xs sm:text-sm opacity-90">Pesanan</div>
                    </div>
                    
                    <div class="bg-white/20 rounded-2xl px-4 sm:px-8 py-3 sm:py-4 text-center backdrop-blur-sm">
                        <div class="text-2xl sm:text-4xl font-bold">{{ count($recommendations) }}</div>
                        <div class="text-xs sm:text-sm opacity-90">Rekomendasi</div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Collaborative Filtering Section -->
        <div class="bg-white rounded-2xl sm:rounded-3xl shadow-lg p-6 sm:p-8 mb-6 sm:mb-8" x-data="{ open: false }">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
                <div class="flex items-center">
                    <svg class="w-6 h-6 sm:w-8 sm:h-8 text-pink-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M11.3 1.046A1 1 0 0112 2v5h4a1 1 0 01.82 1.573l-7 10A1 1 0 018 18v-5H4a1 1 0 01-.82-1.573l7-10a1 1 0 011.12-.38z" clip-rule="evenodd"/>
                    </svg>
                    <h3 class="text-lg sm:text-2xl font-bold text-gray-900">Algoritma Collaborative Filtering</h3>
                </div>
                <button @click="open = !open" class="text-pink-600 hover:text-pink-700 font-medium flex items-center">
                    <span x-text="open ? 'Sembunyikan Detail' : 'Lihat Detail'"></span>
                    <svg class="w-5 h-5 ml-1 transform transition-transform" :class="{ 'rotate-180': open }" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/>
                    </svg>
                </button>
            </div>
            
            <div x-show="open" x-transition class="bg-blue-50 rounded-2xl p-6">
                <h4 class="font-semibold text-gray-800 mb-4">Cara Kerja Sistem:</h4>
                <ol class="space-y-3 text-gray-700">
                    <li>1. Sistem menganalisis histori pembelian dan rating Anda</li>
                    <li>2. Mencari pengguna lain dengan preferensi serupa menggunakan Pearson Correlation</li>
                    <li>3. Memprediksi rating untuk menu yang belum Anda coba</li>
                    <li>4. Menggabungkan dengan analisis konten (bahan, kategori, harga)</li>
                    <li>5. Menghasilkan rekomendasi personal terbaik untuk Anda</li>
                </ol>
            </div>
        </div>
        
        <!-- Recommendations -->
        <div class="mb-8">
            <div class="flex items-center mb-6">
                <svg class="w-6 h-6 sm:w-8 sm:h-8 text-yellow-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                </svg>
                <h3 class="text-lg sm:text-2xl font-bold text-gray-900">Rekomendasi Khusus Untuk Anda</h3>
            </div>
            
            @if(count($recommendations) > 0)
                @foreach($recommendations as $rec)
                    <div class="bg-white rounded-2xl sm:rounded-3xl shadow-lg p-4 sm:p-6 lg:p-8 mb-6">
                        <div class="flex flex-col md:flex-row items-start gap-6">
                            <div class="relative flex-shrink-0 w-full md:w-64">
                                <img 
                                    src="{{ $rec['menu_item']->image }}" 
                                    alt="{{ $rec['menu_item']->name }}"
                                    class="w-full md:w-64 h-48 object-cover rounded-2xl"
                                >
                                <span class="absolute top-4 left-4 bg-pink-500 text-white px-3 sm:px-4 py-1 rounded-full text-xs sm:text-sm font-semibold">
                                    Score: {{ $rec['score'] }}
                                </span>
                            </div>
                            
                            <div class="flex-grow w-full">
                                <div class="flex flex-col sm:flex-row justify-between items-start gap-4 mb-4">
                                    <div class="flex-grow">
                                        <h4 class="text-xl sm:text-2xl font-bold text-gray-900 mb-2">{{ $rec['menu_item']->name }}</h4>
                                        <span class="inline-block bg-gray-100 text-gray-700 px-3 py-1 rounded-full text-sm mb-3">
                                            {{ $rec['menu_item']->category }}
                                        </span>
                                        <p class="text-sm sm:text-base text-gray-600 mb-4">{{ $rec['menu_item']->description }}</p>
                                        <p class="text-2xl sm:text-3xl font-bold text-pink-600">Rp {{ number_format($rec['menu_item']->price, 0, ',', '.') }}</p>
                                    </div>
                                    
                                    <a href="{{ route('menu.show', $rec['menu_item']->id) }}" class="w-full sm:w-auto bg-gradient-to-r from-pink-500 to-orange-500 text-white font-semibold px-6 py-3 rounded-xl hover:from-pink-600 hover:to-orange-600 transition-all text-center whitespace-nowrap">
                                        Lihat Detail
                                    </a>
                                </div>
                                
                                <div class="grid grid-cols-3 gap-2 sm:gap-4 mt-6">
                                    <div class="bg-pink-50 rounded-xl p-2 sm:p-4 text-center">
                                        <div class="text-lg sm:text-2xl font-bold text-pink-600">{{ $rec['menu_item']->rating_count }}</div>
                                        <div class="text-xs sm:text-sm text-gray-600">Tersimpan</div>
                                    </div>
                                    
                                    <div class="bg-orange-50 rounded-xl p-2 sm:p-4 text-center">
                                        <div class="text-lg sm:text-2xl font-bold text-orange-600">{{ number_format($rec['menu_item']->average_rating, 1) }}</div>
                                        <div class="text-xs sm:text-sm text-gray-600">Rating</div>
                                    </div>
                                    
                                    <div class="bg-green-50 rounded-xl p-2 sm:p-4 text-center">
                                        <div class="text-lg sm:text-2xl font-bold text-green-600">{{ $rec['similar_users'] }}</div>
                                        <div class="text-xs sm:text-sm text-gray-600">User Serupa</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="bg-white rounded-3xl shadow-lg p-8 text-center">
                    <p class="text-gray-600 mb-4">Belum ada rekomendasi. Mulai pesan dan beri rating untuk mendapatkan rekomendasi personal!</p>
                    <a href="{{ route('menu.index') }}" class="inline-block bg-gradient-to-r from-pink-500 to-orange-500 text-white font-semibold px-6 py-3 rounded-xl hover:from-pink-600 hover:to-orange-600 transition-all">
                        Lihat Menu
                    </a>
                </div>
            @endif
        </div>
    </main>
</div>
@endsection
