@extends('admin.layout')

@section('title', 'Kelola Pesanan')
@section('page-title', 'Kelola Pesanan')

@section('content')
<div class="mb-6 flex flex-col lg:flex-row justify-between items-start lg:items-center gap-4">
    <div class="bg-white rounded-xl shadow px-4 sm:px-6 py-3 sm:py-4 w-full lg:w-auto">
        <p class="text-xs sm:text-sm text-gray-600">Total Pendapatan</p>
        <p class="text-xl sm:text-2xl font-bold text-green-600 wrap-break-word">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</p>
    </div>
    
    <div class="flex flex-col gap-3 w-full">
        <form method="GET" action="{{ route('admin.orders.index') }}" class="flex flex-col sm:flex-row gap-3">
            <input 
                type="text" 
                name="search" 
                value="{{ $search }}"
                placeholder="Cari pelanggan atau menu..."
                class="flex-1 px-3 sm:px-4 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500"
            >
            <input 
                type="date" 
                name="date" 
                value="{{ $dateFilter }}"
                class="px-3 sm:px-4 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500"
            >
            <div class="flex gap-2 sm:gap-3">
                <button 
                    type="submit" 
                    class="bg-orange-600 text-white px-4 sm:px-6 py-2 rounded-lg hover:bg-orange-700 transition text-sm font-medium"
                >
                    Filter
                </button>
                @if($search || $dateFilter)
                    <a 
                        href="{{ route('admin.orders.index') }}" 
                        class="border border-gray-300 text-gray-700 px-4 sm:px-6 py-2 rounded-lg hover:bg-gray-50 transition text-sm font-medium"
                    >
                        Reset
                    </a>
                @endif
            </div>
        </form>
    </div>
</div>

<div class="bg-white rounded-xl md:rounded-2xl shadow overflow-hidden">
    <!-- Desktop Table View -->
    <div class="hidden lg:block">
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

    <!-- Mobile Card View -->
    <div class="lg:hidden">
        @forelse($orders as $order)
            <div class="border-b border-gray-200 p-4">
                <div class="flex justify-between items-start mb-3">
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-semibold text-gray-900">#{{ $order->id }}</p>
                        <p class="text-xs text-gray-500">{{ $order->created_at->format('d M Y, H:i') }}</p>
                    </div>
                    <div class="text-right shrink-0 ml-3">
                        <p class="text-sm font-bold text-green-600">Rp {{ number_format($order->total_price, 0, ',', '.') }}</p>
                        <p class="text-xs text-gray-500">{{ $order->quantity }}x</p>
                    </div>
                </div>
                
                <div class="flex items-start space-x-3 mb-3">
                    <img src="{{ $order->menuItem->image }}" alt="{{ $order->menuItem->name }}" class="w-12 h-12 rounded-lg object-cover shrink-0">
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-gray-900 truncate">{{ $order->menuItem->name }}</p>
                        <p class="text-xs text-gray-500">{{ $order->menuItem->category }}</p>
                        <p class="text-xs text-gray-600 mt-1">{{ $order->user->name }}</p>
                        <p class="text-xs text-gray-500 truncate">{{ $order->user->email }}</p>
                    </div>
                </div>
                
                <div class="flex justify-end">
                    <form method="POST" action="{{ route('admin.orders.destroy', $order->id) }}" onsubmit="return confirm('Yakin ingin menghapus pesanan ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600 hover:text-red-900 font-medium text-sm">
                            Hapus
                        </button>
                    </form>
                </div>
            </div>
        @empty
            <div class="p-8 text-center text-gray-500">
                Tidak ada pesanan ditemukan.
            </div>
        @endforelse
    </div>
    
    @if($orders->hasPages())
        <div class="px-4 md:px-6 py-4 border-t border-gray-200">
            {{ $orders->links() }}
        </div>
    @endif
</div>
@endsection
