@extends('admin.layout')

@section('title', 'Laporan Rating')
@section('page-title', 'Laporan Rating')

@section('content')
<div class="space-y-6">
    <!-- Filter -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <form method="GET" action="{{ route('admin.reports.ratings') }}" class="flex flex-wrap gap-4 items-end">
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
            <a href="{{ route('admin.reports.print', ['type' => 'ratings', 'start_date' => $startDate, 'end_date' => $endDate]) }}" target="_blank" class="px-6 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition font-medium">
                Cetak
            </a>
        </form>
    </div>

    <!-- Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">Total Rating</p>
                    <p class="text-2xl font-bold text-blue-600">{{ $totalRatings }}</p>
                </div>
                <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                    </svg>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">Rata-rata Rating</p>
                    <div class="flex items-center">
                        <p class="text-2xl font-bold text-yellow-500">{{ number_format($averageRating, 1) }}</p>
                        <span class="text-yellow-500 text-2xl ml-1">★</span>
                    </div>
                </div>
                <div class="w-12 h-12 bg-yellow-100 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-yellow-600" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Rating Distribution -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Distribusi Rating</h3>
        <div class="space-y-3">
            @for($i = 5; $i >= 1; $i--)
            @php $count = $ratingDistribution[$i] ?? 0; $percentage = $totalRatings > 0 ? ($count / $totalRatings) * 100 : 0; @endphp
            <div class="flex items-center">
                <span class="w-8 text-sm font-medium text-gray-600">{{ $i }} ★</span>
                <div class="flex-1 mx-4 h-6 bg-gray-100 rounded-full overflow-hidden">
                    <div class="h-full bg-yellow-400 rounded-full transition-all" style="width: {{ $percentage }}%"></div>
                </div>
                <span class="w-16 text-sm text-gray-600 text-right">{{ $count }} ({{ number_format($percentage, 0) }}%)</span>
            </div>
            @endfor
        </div>
    </div>

    <!-- Menu Ratings -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Rating per Menu</h3>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="border-b border-gray-200">
                        <th class="text-left py-3 px-4 text-sm font-medium text-gray-600">Menu</th>
                        <th class="text-left py-3 px-4 text-sm font-medium text-gray-600">Kategori</th>
                        <th class="text-right py-3 px-4 text-sm font-medium text-gray-600">Jumlah Rating</th>
                        <th class="text-right py-3 px-4 text-sm font-medium text-gray-600">Rata-rata</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($menuRatings as $item)
                    <tr class="border-b border-gray-100 hover:bg-gray-50">
                        <td class="py-3 px-4">
                            <div class="flex items-center">
                                <img src="{{ $item->image }}" alt="{{ $item->name }}" class="w-10 h-10 rounded-lg object-cover mr-3">
                                <span class="text-sm font-medium text-gray-800">{{ $item->name }}</span>
                            </div>
                        </td>
                        <td class="py-3 px-4 text-sm text-gray-600">{{ $item->category }}</td>
                        <td class="py-3 px-4 text-sm text-gray-600 text-right">{{ $item->rating_count }}</td>
                        <td class="py-3 px-4 text-right">
                            <div class="flex items-center justify-end">
                                <span class="text-yellow-500 mr-1">★</span>
                                <span class="text-sm font-medium text-gray-800">{{ number_format($item->avg_rating, 1) }}</span>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="py-8 text-center text-gray-500">Tidak ada data rating</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Recent Ratings -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Rating Terbaru</h3>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="border-b border-gray-200">
                        <th class="text-left py-3 px-4 text-sm font-medium text-gray-600">Tanggal</th>
                        <th class="text-left py-3 px-4 text-sm font-medium text-gray-600">Pelanggan</th>
                        <th class="text-left py-3 px-4 text-sm font-medium text-gray-600">Menu</th>
                        <th class="text-center py-3 px-4 text-sm font-medium text-gray-600">Rating</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($ratings->take(20) as $rating)
                    <tr class="border-b border-gray-100 hover:bg-gray-50">
                        <td class="py-3 px-4 text-sm text-gray-500">{{ $rating->created_at->format('d M Y H:i') }}</td>
                        <td class="py-3 px-4 text-sm text-gray-800">{{ $rating->user->name ?? '-' }}</td>
                        <td class="py-3 px-4 text-sm text-gray-800">{{ $rating->menuItem->name ?? '-' }}</td>
                        <td class="py-3 px-4 text-center">
                            <div class="flex items-center justify-center">
                                @for($i = 1; $i <= 5; $i++)
                                <span class="{{ $i <= $rating->rating ? 'text-yellow-500' : 'text-gray-300' }}">★</span>
                                @endfor
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="py-8 text-center text-gray-500">Tidak ada rating</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
