@extends('layouts.app')

@section('title', 'Masuk - Dinasti Sushi')

@section('content')
<div class="min-h-screen flex items-center justify-center p-4 sm:p-6">
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 lg:gap-8 max-w-6xl w-full">
        <!-- Left Section -->
        <div class="bg-white rounded-3xl shadow-2xl p-6 sm:p-8 lg:p-12 hidden lg:block">
            <h1 class="text-4xl lg:text-5xl font-bold text-gray-900 mb-3">Dinasti Sushi</h1>
            <p class="text-lg lg:text-xl text-gray-600 mb-12">Sistem Rekomendasi Menu Sushi Berbasis AI</p>
            
            <div class="space-y-6">
                <h2 class="text-xl font-semibold text-gray-800">Fitur Unggulan:</h2>
                
                <div class="space-y-4">
                    <div class="flex items-start">
                        <svg class="w-6 h-6 text-green-500 mr-3 flex-shrink-0 mt-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        <p class="text-gray-700">Rekomendasi personal berdasarkan preferensi Anda</p>
                    </div>
                    
                    <div class="flex items-start">
                        <svg class="w-6 h-6 text-green-500 mr-3 flex-shrink-0 mt-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        <p class="text-gray-700">Algoritma Collaborative Filtering yang canggih</p>
                    </div>
                    
                    <div class="flex items-start">
                        <svg class="w-6 h-6 text-green-500 mr-3 flex-shrink-0 mt-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        <p class="text-gray-700">Histori pembelian dan rating terintegrasi</p>
                    </div>
                    
                    <div class="flex items-start">
                        <svg class="w-6 h-6 text-green-500 mr-3 flex-shrink-0 mt-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        <p class="text-gray-700">Analisis kesamaan preferensi antar pengguna</p>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Right Section - Login/Register Form -->
        <div class="bg-white rounded-3xl shadow-2xl p-6 sm:p-8 lg:p-12" x-data="{ activeTab: 'login' }">
            <!-- Mobile Header -->
            <div class="lg:hidden text-center mb-6">
                <h1 class="text-3xl font-bold text-gray-900 mb-2">Dinasti Sushi</h1>
                <p class="text-sm text-gray-600">Sistem Rekomendasi Menu Sushi Berbasis AI</p>
            </div>
            <!-- Tab Buttons -->
            <div class="flex mb-8 border-b border-gray-200">
                <button 
                    @click="activeTab = 'login'"
                    :class="activeTab === 'login' ? 'border-pink-500 text-pink-600' : 'border-transparent text-gray-500'"
                    class="flex-1 pb-4 font-semibold border-b-2 transition-colors"
                >
                    Masuk ke Akun
                </button>
                <button 
                    @click="activeTab = 'register'"
                    :class="activeTab === 'register' ? 'border-pink-500 text-pink-600' : 'border-transparent text-gray-500'"
                    class="flex-1 pb-4 font-semibold border-b-2 transition-colors"
                >
                    Daftar Akun Baru
                </button>
            </div>
            
            @if ($errors->any())
                <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl mb-6">
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            @if (session('success'))
                <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl mb-6">
                    {{ session('success') }}
                </div>
            @endif
            
            <!-- Login Form -->
            <div x-show="activeTab === 'login'" x-transition>
                <p class="text-gray-600 mb-8">Selamat datang kembali!</p>
                
                <form method="POST" action="{{ route('login.post') }}" class="space-y-6">
                    @csrf
                    
                    <div>
                        <label for="login_email" class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                        <input 
                            type="email" 
                            name="email" 
                            id="login_email" 
                            value="{{ old('email') }}"
                            placeholder="nama@email.com"
                            required
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-pink-500 focus:border-pink-500"
                        >
                    </div>
                    
                    <div>
                        <label for="login_password" class="block text-sm font-medium text-gray-700 mb-2">Password</label>
                        <input 
                            type="password" 
                            name="password" 
                            id="login_password" 
                            placeholder="Masukkan password"
                            required
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-pink-500 focus:border-pink-500"
                        >
                    </div>
                    
                    <button 
                        type="submit" 
                        class="w-full bg-gradient-to-r from-pink-500 to-orange-500 text-white font-semibold py-3 px-6 rounded-xl hover:from-pink-600 hover:to-orange-600 transition-all"
                    >
                        Masuk
                    </button>
                    
                    <p class="text-center text-sm text-gray-600">
                        <button type="button" @click="activeTab = 'register'" class="text-pink-600 hover:text-pink-700">Belum punya akun? Daftar sekarang</button>
                    </p>
                </form>
            </div>

            <!-- Register Form -->
            <div x-show="activeTab === 'register'" x-transition>
                <p class="text-gray-600 mb-8">Mulai perjalanan kuliner Anda</p>
                
                <form method="POST" action="{{ route('register.post') }}" class="space-y-6">
                    @csrf
                    
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap</label>
                        <input 
                            type="text" 
                            name="name" 
                            id="name" 
                            value="{{ old('name') }}"
                            placeholder="Masukkan nama lengkap"
                            required
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-pink-500 focus:border-pink-500"
                        >
                    </div>
                    
                    <div>
                        <label for="register_email" class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                        <input 
                            type="email" 
                            name="email" 
                            id="register_email" 
                            value="{{ old('email') }}"
                            placeholder="nama@email.com"
                            required
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-pink-500 focus:border-pink-500"
                        >
                    </div>
                    
                    <div>
                        <label for="register_password" class="block text-sm font-medium text-gray-700 mb-2">Password</label>
                        <input 
                            type="password" 
                            name="password" 
                            id="register_password" 
                            placeholder="Masukkan password"
                            required
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-pink-500 focus:border-pink-500"
                        >
                    </div>
                    
                    <button 
                        type="submit" 
                        class="w-full bg-gradient-to-r from-pink-500 to-orange-500 text-white font-semibold py-3 px-6 rounded-xl hover:from-pink-600 hover:to-orange-600 transition-all"
                    >
                        Daftar
                    </button>
                    
                    <p class="text-center text-sm text-gray-600">
                        <button type="button" @click="activeTab = 'login'" class="text-pink-600 hover:text-pink-700">Sudah punya akun? Masuk</button>
                    </p>
                </form>
            </div>
            
            <div class="mt-8">
                <p class="text-center text-sm text-gray-600 mb-4">Coba dengan akun demo:</p>
                
                <div class="space-y-3">
                    @foreach($demoUsers as $demoUser)
                        <a 
                            href="{{ route('login.demo', $demoUser->id) }}"
                            class="flex items-center justify-center px-4 py-3 bg-gray-100 rounded-xl hover:bg-gray-200 transition-colors"
                        >
                            <svg class="w-5 h-5 text-gray-600 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                            </svg>
                            <span class="text-gray-700">{{ $demoUser->name }} ({{ explode(' ', $demoUser->name)[0] }})</span>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
