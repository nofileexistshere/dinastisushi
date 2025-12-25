<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard') - Dinasti Sushi</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-gray-100" x-data="{ sidebarOpen: true, mobileMenuOpen: false }">
    <div class="min-h-screen">
        <!-- Mobile Overlay (click to close) -->
        <div x-show="mobileMenuOpen" @click="mobileMenuOpen = false" class="fixed inset-0 z-40 md:hidden"></div>
        
        <!-- Sidebar -->
        <aside :class="[
            sidebarOpen ? 'w-64' : 'w-20',
            mobileMenuOpen ? 'translate-x-0' : '-translate-x-full md:translate-x-0'
        ]" class="bg-white text-gray-800 fixed left-0 top-0 h-full min-h-screen overflow-hidden shadow-lg border-r border-gray-200 transition-all duration-300 z-50" x-cloak>
            <div class="p-4 h-full overflow-y-auto">
                <div class="mb-8">
                    <div x-show="sidebarOpen" class="flex items-center justify-between">
                        <div class="flex items-center">
                            <span class="text-3xl mr-3">🍣</span>
                            <h1 class="text-xl font-bold">Admin Panel</h1>
                        </div>
                        <button @click="sidebarOpen = !sidebarOpen" class="p-2 rounded-lg hover:bg-gray-100 transition">
                            <svg class="w-6 h-6 text-gray-700" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd"/>
                            </svg>
                        </button>
                    </div>
                    <div x-show="!sidebarOpen" class="flex justify-center">
                        <button @click="sidebarOpen = !sidebarOpen" class="p-2 rounded-lg hover:bg-gray-100 transition">
                            <svg class="w-6 h-6 text-gray-700" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd"/>
                            </svg>
                        </button>
                    </div>
                </div>
                <nav class="space-y-1">
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center px-3 py-3 rounded-lg transition {{ request()->routeIs('admin.dashboard') ? 'bg-orange-500 text-white hover:bg-orange-600' : 'text-gray-700 hover:bg-orange-50 hover:text-orange-600' }}" :class="!sidebarOpen ? 'justify-center' : ''" :title="!sidebarOpen ? 'Dashboard' : ''">
                        <svg class="w-5 h-5 flex-shrink-0" :class="sidebarOpen ? 'mr-3' : ''" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z"/>
                        </svg>
                        <span x-show="sidebarOpen" x-transition class="text-sm font-medium whitespace-nowrap">Dashboard</span>
                    </a>
                    
                    <a href="{{ route('admin.orders.index') }}" class="flex items-center px-3 py-3 rounded-lg transition {{ request()->routeIs('admin.orders.*') ? 'bg-orange-500 text-white hover:bg-orange-600' : 'text-gray-700 hover:bg-orange-50 hover:text-orange-600' }}" :class="!sidebarOpen ? 'justify-center' : ''" :title="!sidebarOpen ? 'Kelola Pesanan' : ''">
                        <svg class="w-5 h-5 flex-shrink-0" :class="sidebarOpen ? 'mr-3' : ''" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M3 1a1 1 0 000 2h1.22l.305 1.222a.997.997 0 00.01.042l1.358 5.43-.893.892C3.74 11.846 4.632 14 6.414 14H15a1 1 0 000-2H6.414l1-1H14a1 1 0 00.894-.553l3-6A1 1 0 0017 3H6.28l-.31-1.243A1 1 0 005 1H3zM16 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM6.5 18a1.5 1.5 0 100-3 1.5 1.5 0 000 3z"/>
                        </svg>
                        <span x-show="sidebarOpen" x-transition class="text-sm font-medium whitespace-nowrap">Kelola Pesanan</span>
                    </a>
                    
                    <a href="{{ route('admin.menu.index') }}" class="flex items-center px-3 py-3 rounded-lg transition {{ request()->routeIs('admin.menu.*') ? 'bg-orange-500 text-white hover:bg-orange-600' : 'text-gray-700 hover:bg-orange-50 hover:text-orange-600' }}" :class="!sidebarOpen ? 'justify-center' : ''" :title="!sidebarOpen ? 'Kelola Menu' : ''">
                        <svg class="w-5 h-5 flex-shrink-0" :class="sidebarOpen ? 'mr-3' : ''" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z" clip-rule="evenodd"/>
                        </svg>
                        <span x-show="sidebarOpen" x-transition class="text-sm font-medium whitespace-nowrap">Kelola Menu</span>
                    </a>
                    
                    <div class="border-t border-gray-200 my-3"></div>
                    
                    <a href="{{ route('dashboard') }}" class="flex items-center px-3 py-3 rounded-lg transition text-gray-700 hover:bg-orange-50 hover:text-orange-600" :class="!sidebarOpen ? 'justify-center' : ''" :title="!sidebarOpen ? 'Lihat Website' : ''">
                        <svg class="w-5 h-5 flex-shrink-0" :class="sidebarOpen ? 'mr-3' : ''" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M3 3a1 1 0 000 2v8a2 2 0 002 2h2.586l-1.293 1.293a1 1 0 101.414 1.414L10 15.414l2.293 2.293a1 1 0 001.414-1.414L12.414 15H15a2 2 0 002-2V5a1 1 0 100-2H3zm11.707 4.707a1 1 0 00-1.414-1.414L10 9.586 8.707 8.293a1 1 0 00-1.414 0l-2 2a1 1 0 101.414 1.414L8 10.414l1.293 1.293a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        <span x-show="sidebarOpen" x-transition class="text-sm font-medium whitespace-nowrap">Lihat Website</span>
                    </a>
                    
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full flex items-center px-3 py-3 rounded-lg transition text-left text-gray-700 hover:bg-orange-50 hover:text-orange-600" :class="!sidebarOpen ? 'justify-center' : ''" :title="!sidebarOpen ? 'Logout' : ''">
                            <svg class="w-5 h-5 flex-shrink-0" :class="sidebarOpen ? 'mr-3' : ''" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M3 3a1 1 0 00-1 1v12a1 1 0 102 0V4a1 1 0 00-1-1zm10.293 9.293a1 1 0 001.414 1.414l3-3a1 1 0 000-1.414l-3-3a1 1 0 10-1.414 1.414L14.586 9H7a1 1 0 100 2h7.586l-1.293 1.293z" clip-rule="evenodd"/>
                            </svg>
                            <span x-show="sidebarOpen" x-transition class="text-sm font-medium whitespace-nowrap">Logout</span>
                        </button>
                    </form>
                </nav>
            </div>
        </aside>

        <!-- Main Content -->
        <div class="transition-all duration-300 md:ml-20" :class="sidebarOpen ? 'md:ml-64' : 'md:ml-20'">
            <!-- Top Bar -->
            <header class="bg-white border-b border-gray-200 sticky top-0 z-40">
                <div class="px-4 md:px-6 py-4 flex justify-between items-center">
                    <!-- Mobile Menu Button -->
                    <button @click="mobileMenuOpen = !mobileMenuOpen" class="md:hidden p-2 rounded-lg hover:bg-gray-100 transition">
                        <svg class="w-6 h-6 text-gray-700" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd"/>
                        </svg>
                    </button>
                    <h2 class="text-lg md:text-xl font-semibold text-gray-800 flex-1 text-center md:text-left">@yield('page-title', 'Dashboard')</h2>
                    <div class="hidden md:flex items-center space-x-4">
                        <div class="text-right">
                            <p class="text-sm font-medium text-gray-900">{{ Auth::user()->name }}</p>
                            <p class="text-xs text-gray-500">Administrator</p>
                        </div>
                        <div class="w-10 h-10 rounded-full bg-orange-100 flex items-center justify-center">
                            <svg class="w-6 h-6 text-orange-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 2a4 4 0 100 8 4 4 0 000-8zM4 14a6 6 0 1112 0v1a1 1 0 01-1 1H5a1 1 0 01-1-1v-1z" clip-rule="evenodd" />
                            </svg>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Content -->
            <main class="p-4 md:p-6">
                @if(session('success'))
                    <div class="mb-6 px-4 py-3 rounded-lg bg-green-50 text-green-700 text-sm border border-green-200">
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="mb-6 px-4 py-3 rounded-lg bg-red-50 text-red-700 text-sm border border-red-200">
                        {{ session('error') }}
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>
</body>
</html>
