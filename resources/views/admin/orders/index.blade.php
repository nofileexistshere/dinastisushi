@extends('admin.layout')

@section('title', 'Kelola Pesanan')
@section('page-title', 'Kelola Pesanan')

@section('content')
<div class="mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
    <div class="bg-white rounded-xl shadow px-6 py-4">
        <p class="text-sm text-gray-600">Total Pendapatan</p>
        <p class="text-2xl font-bold text-green-600">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</p>
    </div>
    
    <div class="flex flex-col sm:flex-row gap-3 w-full sm:w-auto">
        <form method="GET" action="{{ route('admin.orders.index') }}" class="flex gap-3 flex-1">
            <input 
                type="text" 
                name="search" 
                value="{{ $search }}"
                placeholder="Cari pelanggan atau menu..."
                class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500"
            >
            <input 
                type="date" 
                name="date" 
                value="{{ $dateFilter }}"
                class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500"
            >
            <button 
                type="submit" 
                class="bg-orange-600 text-white px-6 py-2 rounded-lg hover:bg-orange-700 transition"
            >
                Filter
            </button>
            @if($search || $dateFilter)
                <a 
                    href="{{ route('admin.orders.index') }}" 
                    class="border border-gray-300 text-gray-700 px-6 py-2 rounded-lg hover:bg-gray-50 transition"
                >
                    Reset
                </a>
            @endif
        </form>
    </div>
</div>

<div class="bg-white rounded-xl md:rounded-2xl shadow overflow-hidden">
    <div class="overflow-x-auto -mx-4 md:mx-0">
        <div class="inline-block min-w-full align-middle">
            <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pelanggan</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Menu</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jumlah</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total Harga</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($orders as $order)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">#{{ $order->id }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">{{ $order->user->name }}</div>
                            <div class="text-sm text-gray-500">{{ $order->user->email }}</div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center">
                                <img src="{{ $order->menuItem->image }}" alt="{{ $order->menuItem->name }}" class="w-10 h-10 rounded-lg object-cover mr-3">
                                <div>
                                    <div class="text-sm font-medium text-gray-900">{{ $order->menuItem->name }}</div>
                                    <div class="text-sm text-gray-500">{{ $order->menuItem->category }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $order->quantity }}x</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-green-600">
                            Rp {{ number_format($order->total_price, 0, ',', '.') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $order->created_at->format('d M Y, H:i') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            <form method="POST" action="{{ route('admin.orders.destroy', $order->id) }}" onsubmit="return confirm('Yakin ingin menghapus pesanan ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900 font-medium">
                                    Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-6 py-12 text-center text-gray-500">
                            Tidak ada pesanan ditemukan.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        </div>
    </div>
    
    @if($orders->hasPages())
        <div class="px-4 md:px-6 py-4 border-t border-gray-200">
            {{ $orders->links() }}
        </div>
    @endif
</div>
@endsection
