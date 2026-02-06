@extends('admin.layout')

@section('title', 'Laporan Pengguna')
@section('page-title', 'Laporan Pengguna')

@section('content')
<div class="space-y-6">
    <!-- Filter -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <form method="GET" action="{{ route('admin.reports.users') }}" class="flex flex-wrap gap-4 items-end">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Mulai</label>
                <input type="date" name="start_date" value="{{ $startDate }}" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Akhir</label>
                <input type="date" name="end_date" value="{{ $endDate }}" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500">
            </div>
            <button type="submit" class="px-6 py-2 bg-orange-500 text-white rounded-lg hover:bg-orange-600 transition font-medium">
                Filter
            </button>
            <a href="{{ route('admin.reports.print', ['type' => 'users', 'start_date' => $startDate, 'end_date' => $endDate]) }}" target="_blank" class="inline-flex items-center px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-medium">
                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M5 4v3H4a2 2 0 00-2 2v3a2 2 0 002 2h1v2a2 2 0 002 2h6a2 2 0 002-2v-2h1a2 2 0 002-2V9a2 2 0 00-2-2h-1V4a2 2 0 00-2-2H7a2 2 0 00-2 2zm8 0H7v3h6V4zm0 8H7v4h6v-4z" clip-rule="evenodd"/>
                </svg>
                Cetak
            </a>
        </form>
    </div>

    <!-- Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">Total Pengguna</p>
                    <p class="text-2xl font-bold text-blue-600">{{ $totalUsers }}</p>
                </div>
                <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"/>
                    </svg>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">Pengguna Aktif</p>
                    <p class="text-2xl font-bold text-green-600">{{ $activeUsers }}</p>
                </div>
                <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">Pengguna Baru</p>
                    <p class="text-2xl font-bold text-orange-600">{{ $newUsers }}</p>
                </div>
                <div class="w-12 h-12 bg-orange-100 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-orange-600" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M8 9a3 3 0 100-6 3 3 0 000 6zM8 11a6 6 0 016 6H2a6 6 0 016-6zM16 7a1 1 0 10-2 0v1h-1a1 1 0 100 2h1v1a1 1 0 102 0v-1h1a1 1 0 100-2h-1V7z"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Top Spenders -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Top 10 Pelanggan</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">
            @foreach($topSpenders as $index => $user)
            <div class="bg-gradient-to-br from-orange-50 to-pink-50 rounded-xl p-4 border border-orange-100 text-center">
                <div class="w-12 h-12 bg-orange-100 rounded-full flex items-center justify-center mx-auto mb-2">
                    <span class="text-orange-600 font-bold">{{ $index + 1 }}</span>
                </div>
                <h4 class="font-semibold text-gray-800 text-sm truncate">{{ $user->name }}</h4>
                <p class="text-xs text-gray-500">{{ $user->orders_count }} pesanan</p>
                <p class="text-sm font-bold text-green-600 mt-1">Rp {{ number_format($user->orders_sum_total_price ?? 0, 0, ',', '.') }}</p>
            </div>
            @endforeach
        </div>
    </div>

    <!-- All Users Table -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Daftar Pengguna</h3>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="border-b border-gray-200">
                        <th class="text-left py-3 px-4 text-sm font-medium text-gray-600">ID</th>
                        <th class="text-left py-3 px-4 text-sm font-medium text-gray-600">Nama</th>
                        <th class="text-left py-3 px-4 text-sm font-medium text-gray-600">Email</th>
                        <th class="text-right py-3 px-4 text-sm font-medium text-gray-600">Pesanan</th>
                        <th class="text-right py-3 px-4 text-sm font-medium text-gray-600">Total Belanja</th>
                        <th class="text-right py-3 px-4 text-sm font-medium text-gray-600">Rating Diberikan</th>
                        <th class="text-left py-3 px-4 text-sm font-medium text-gray-600">Bergabung</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                    <tr class="border-b border-gray-100 hover:bg-gray-50">
                        <td class="py-3 px-4 text-sm text-gray-500">#{{ $user->id }}</td>
                        <td class="py-3 px-4 text-sm font-medium text-gray-800">{{ $user->name }}</td>
                        <td class="py-3 px-4 text-sm text-gray-600">{{ $user->email }}</td>
                        <td class="py-3 px-4 text-sm text-gray-600 text-right">{{ $user->orders_count }}</td>
                        <td class="py-3 px-4 text-sm font-medium text-green-600 text-right">Rp {{ number_format($user->orders_sum_total_price ?? 0, 0, ',', '.') }}</td>
                        <td class="py-3 px-4 text-sm text-gray-600 text-right">{{ $user->ratings_count }}</td>
                        <td class="py-3 px-4 text-sm text-gray-500">{{ $user->created_at->format('d M Y') }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="py-8 text-center text-gray-500">Tidak ada data pengguna</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
