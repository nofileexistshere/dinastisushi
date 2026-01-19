@extends('admin.layout')

@section('title', 'Laporan Menu Terlaris')
@section('page-title', 'Laporan Menu Terlaris')

@section('content')
<div class="space-y-6">
    <!-- Filter -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <form method="GET" action="{{ route('admin.reports.top-menu') }}" class="flex flex-wrap gap-4 items-end">
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
            <a href="{{ route('admin.reports.print', ['type' => 'top-menu', 'start_date' => $startDate, 'end_date' => $endDate]) }}" target="_blank" class="px-6 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition font-medium">
                Cetak
            </a>
        </form>
    </div>

    <!-- Category Stats -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Penjualan per Kategori</h3>
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            @foreach($categoryStats as $category)
            <div class="bg-gradient-to-br from-orange-50 to-pink-50 rounded-xl p-4 border border-orange-100">
                <h4 class="font-semibold text-gray-800 mb-2">{{ $category->category }}</h4>
                <p class="text-2xl font-bold text-orange-600">{{ $category->total_sold }}</p>
                <p class="text-sm text-gray-500">item terjual</p>
                <p class="text-sm font-medium text-green-600 mt-1">Rp {{ number_format($category->total_revenue, 0, ',', '.') }}</p>
            </div>
            @endforeach
        </div>
    </div>

    <!-- Top Menu Items -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Ranking Menu</h3>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="border-b border-gray-200">
                        <th class="text-left py-3 px-4 text-sm font-medium text-gray-600">Rank</th>
                        <th class="text-left py-3 px-4 text-sm font-medium text-gray-600">Menu</th>
                        <th class="text-left py-3 px-4 text-sm font-medium text-gray-600">Kategori</th>
                        <th class="text-right py-3 px-4 text-sm font-medium text-gray-600">Harga</th>
                        <th class="text-right py-3 px-4 text-sm font-medium text-gray-600">Terjual</th>
                        <th class="text-right py-3 px-4 text-sm font-medium text-gray-600">Pesanan</th>
                        <th class="text-right py-3 px-4 text-sm font-medium text-gray-600">Pendapatan</th>
                        <th class="text-right py-3 px-4 text-sm font-medium text-gray-600">Rating</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($topMenuItems as $index => $item)
                    <tr class="border-b border-gray-100 hover:bg-gray-50">
                        <td class="py-3 px-4">
                            @if($index < 3)
                            <span class="inline-flex items-center justify-center w-8 h-8 rounded-full {{ $index == 0 ? 'bg-yellow-100 text-yellow-600' : ($index == 1 ? 'bg-gray-100 text-gray-600' : 'bg-orange-100 text-orange-600') }} font-bold text-sm">
                                {{ $index + 1 }}
                            </span>
                            @else
                            <span class="text-gray-500 text-sm ml-2">{{ $index + 1 }}</span>
                            @endif
                        </td>
                        <td class="py-3 px-4">
                            <div class="flex items-center">
                                <img src="{{ $item->image }}" alt="{{ $item->name }}" class="w-10 h-10 rounded-lg object-cover mr-3">
                                <span class="text-sm font-medium text-gray-800">{{ $item->name }}</span>
                            </div>
                        </td>
                        <td class="py-3 px-4 text-sm text-gray-600">{{ $item->category }}</td>
                        <td class="py-3 px-4 text-sm text-gray-600 text-right">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                        <td class="py-3 px-4 text-sm font-medium text-orange-600 text-right">{{ $item->total_sold }}</td>
                        <td class="py-3 px-4 text-sm text-gray-600 text-right">{{ $item->order_count }}</td>
                        <td class="py-3 px-4 text-sm font-medium text-green-600 text-right">Rp {{ number_format($item->total_revenue, 0, ',', '.') }}</td>
                        <td class="py-3 px-4 text-right">
                            <div class="flex items-center justify-end">
                                <span class="text-yellow-500 mr-1">★</span>
                                <span class="text-sm text-gray-600">{{ number_format($item->average_rating, 1) }}</span>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="py-8 text-center text-gray-500">Tidak ada data menu</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
