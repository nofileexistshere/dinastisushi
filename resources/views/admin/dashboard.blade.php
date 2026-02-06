@extends('admin.layout')

@section('title', 'Admin Dashboard')
@section('page-title', 'Dashboard')

@section('content')
<!-- Statistics Cards -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6 mb-6">
    <div class="bg-white rounded-2xl shadow p-4 sm:p-6">
        <div class="flex items-center justify-between">
            <div class="flex-1 min-w-0">
                <p class="text-xs sm:text-sm text-gray-600 mb-1">Total Pesanan</p>
                <p class="text-2xl sm:text-3xl font-bold text-gray-900 wrap-break-word">{{ $totalOrders }}</p>
            </div>
            <div class="w-10 h-10 sm:w-12 sm:h-12 bg-orange-100 rounded-xl flex items-center justify-center shrink-0 ml-3">
                <svg class="w-5 h-5 sm:w-6 sm:h-6 text-orange-600" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M3 1a1 1 0 000 2h1.22l.305 1.222a.997.997 0 00.01.042l1.358 5.43-.893.892C3.74 11.846 4.632 14 6.414 14H15a1 1 0 000-2H6.414l1-1H14a1 1 0 00.894-.553l3-6A1 1 0 0017 3H6.28l-.31-1.243A1 1 0 005 1H3zM16 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM6.5 18a1.5 1.5 0 100-3 1.5 1.5 0 000 3z"/>
                </svg>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow p-4 sm:p-6">
        <div class="flex items-center justify-between">
            <div class="flex-1 min-w-0">
                <p class="text-xs sm:text-sm text-gray-600 mb-1">Total Pendapatan</p>
                <p class="text-lg sm:text-2xl lg:text-3xl font-bold text-gray-900 wrap-break-word">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</p>
            </div>
            <div class="w-10 h-10 sm:w-12 sm:h-12 bg-green-100 rounded-xl flex items-center justify-center shrink-0 ml-3">
                <svg class="w-5 h-5 sm:w-6 sm:h-6 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M8.433 7.418c.155-.103.346-.196.567-.267v1.698a2.305 2.305 0 01-.567-.267C8.07 8.34 8 8.114 8 8c0-.114.07-.34.433-.582zM11 12.849v-1.698c.22.071.412.164.567.267.364.243.433.468.433.582 0 .114-.07.34-.433.582a2.305 2.305 0 01-.567.267z"/>
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a1 1 0 10-2 0v.092a4.535 4.535 0 00-1.676.662C6.602 6.234 6 7.009 6 8c0 .99.602 1.765 1.324 2.246.48.32 1.054.545 1.676.662v1.941c-.391-.127-.68-.317-.843-.504a1 1 0 10-1.51 1.31c.562.649 1.413 1.076 2.353 1.253V15a1 1 0 102 0v-.092a4.535 4.535 0 001.676-.662C13.398 13.766 14 12.991 14 12c0-.99-.602-1.765-1.324-2.246A4.535 4.535 0 0011 9.092V7.151c.391.127.68.317.843.504a1 1 0 101.511-1.31c-.563-.649-1.413-1.076-2.354-1.253V5z" clip-rule="evenodd"/>
                </svg>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow p-4 sm:p-6">
        <div class="flex items-center justify-between">
            <div class="flex-1 min-w-0">
                <p class="text-xs sm:text-sm text-gray-600 mb-1">Total Menu</p>
                <p class="text-2xl sm:text-3xl font-bold text-gray-900 wrap-break-word">{{ $totalMenuItems }}</p>
            </div>
            <div class="w-10 h-10 sm:w-12 sm:h-12 bg-orange-100 rounded-xl flex items-center justify-center shrink-0 ml-3">
                <svg class="w-5 h-5 sm:w-6 sm:h-6 text-orange-600" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z" clip-rule="evenodd"/>
                </svg>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow p-4 sm:p-6">
        <div class="flex items-center justify-between">
            <div class="flex-1 min-w-0">
                <p class="text-xs sm:text-sm text-gray-600 mb-1">Total Pelanggan</p>
                <p class="text-2xl sm:text-3xl font-bold text-gray-900 wrap-break-word">{{ $totalUsers }}</p>
            </div>
            <div class="w-10 h-10 sm:w-12 sm:h-12 bg-blue-100 rounded-xl flex items-center justify-center shrink-0 ml-3">
                <svg class="w-5 h-5 sm:w-6 sm:h-6 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"/>
                </svg>
            </div>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
    <!-- Recent Orders -->
    <div class="bg-white rounded-2xl shadow p-6">
        <h3 class="text-lg font-bold text-gray-900 mb-4">Pesanan Terbaru</h3>
        <div class="space-y-3 max-h-96 overflow-y-auto custom-scrollbar">
            @forelse($recentOrders as $order)
                <div class="flex items-start justify-between border-b border-gray-100 pb-3 last:border-0">
                    <div class="flex-1 min-w-0 pr-4">
                        <p class="font-semibold text-gray-900 truncate">{{ $order->menuItem->name }}</p>
                        <p class="text-sm text-gray-600 truncate">{{ $order->user->name }}</p>
                        <p class="text-xs text-gray-500">{{ $order->created_at->diffForHumans() }}</p>
                    </div>
                    <div class="text-right flex-shrink-0">
                        <p class="font-semibold text-orange-600 whitespace-nowrap">Rp {{ number_format($order->total_price, 0, ',', '.') }}</p>
                        <p class="text-xs text-gray-500">{{ $order->quantity }}x</p>
                    </div>
                </div>
            @empty
                <p class="text-gray-500 text-center py-8">Belum ada pesanan</p>
            @endforelse
        </div>
        <a href="{{ route('admin.orders.index') }}" class="mt-4 block text-center text-orange-600 hover:text-orange-700 font-medium text-sm">
            Lihat Semua Pesanan →
        </a>
    </div>

    <!-- Top Menu Items -->
    <div class="bg-white rounded-2xl shadow p-6">
        <h3 class="text-lg font-bold text-gray-900 mb-4">Menu Terpopuler</h3>
        <div class="space-y-3 max-h-96 overflow-y-auto custom-scrollbar">
            @forelse($topMenuItems as $item)
                <div class="flex items-center justify-between border-b border-gray-100 pb-3 last:border-0">
                    <div class="flex items-center space-x-3 flex-1 min-w-0">
                        <img src="{{ $item->image }}" alt="{{ $item->name }}" class="w-16 h-16 rounded-lg object-cover flex-shrink-0">
                        <div class="min-w-0 flex-1">
                            <p class="font-semibold text-gray-900 truncate">{{ $item->name }}</p>
                            <p class="text-sm text-gray-600">{{ $item->category }}</p>
                        </div>
                    </div>
                    <div class="text-right flex-shrink-0 ml-4">
                        <p class="font-semibold text-gray-900 whitespace-nowrap">{{ $item->orders_count }} pesanan</p>
                        <p class="text-xs text-gray-500 whitespace-nowrap">⭐ {{ number_format($item->average_rating, 1) }}</p>
                    </div>
                </div>
            @empty
                <p class="text-gray-500 text-center py-8">Belum ada data</p>
            @endforelse
        </div>
        <a href="{{ route('admin.menu.index') }}" class="mt-4 block text-center text-orange-600 hover:text-orange-700 font-medium text-sm">
            Kelola Menu →
        </a>
    </div>
</div>

<!-- Revenue Chart -->
<div class="bg-white rounded-2xl shadow p-6">
    <h3 class="text-lg font-bold text-gray-900 mb-4">Pendapatan 7 Hari Terakhir</h3>
    <div class="space-y-3">
        @forelse($dailyRevenue as $day)
            <div class="flex items-center justify-between border-b border-gray-100 pb-3 last:border-0">
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-medium text-gray-900">{{ \Carbon\Carbon::parse($day->date)->format('d M Y') }}</p>
                </div>
                <div class="flex items-center space-x-4 flex-shrink-0">
                    <span class="text-sm text-gray-600 whitespace-nowrap">{{ $day->orders }} pesanan</span>
                    <span class="font-semibold text-green-600 whitespace-nowrap">Rp {{ number_format($day->revenue, 0, ',', '.') }}</span>
                </div>
            </div>
        @empty
            <p class="text-gray-500 text-center py-8">Belum ada data pendapatan</p>
        @endforelse
    </div>
</div>
@endsection
