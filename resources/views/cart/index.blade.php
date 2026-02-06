    @extends('layouts.app')

    @section('title', 'Keranjang - Dinasti Sushi')

    @section('content')
    <div class="min-h-screen">
        <header class="bg-white border-b border-gray-200">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center py-4">
                    <div class="flex items-center">
                        <a href="{{ route('menu.index') }}" class="mr-4">
                            <svg class="w-6 h-6 text-gray-600 hover:text-pink-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd"/>
                            </svg>
                        </a>
                        <h1 class="text-2xl font-bold text-gray-900">Keranjang</h1>
                    </div>
                </div>
            </div>
        </header>

        <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="bg-white rounded-3xl shadow-lg p-6">
                @if(session('success'))
                    <div class="mb-4 px-4 py-3 rounded-xl bg-green-50 text-green-700 text-sm">
                        {{ session('success') }}
                    </div>
                @endif

                @if(empty($items))
                    <p class="text-gray-600 text-center py-8">Keranjang kamu masih kosong.</p>
                @else
                    <div class="space-y-4 mb-6">
                        @foreach($items as $row)
                            @php($item = $row['model'])
                            <div class="flex justify-between items-center border-gray-100 pb-4">
                                <div class="flex items-center space-x-4">
                                    <div class="w-16 h-16 sm:w-20 sm:h-20 rounded-2xl overflow-hidden bg-gray-100 flex-shrink-0">
                                        <img src="{{ $item->image }}" alt="{{ $item->name }}" class="w-full sm:w-40 h-48 sm:h-32 object-cover rounded-2xl flex-shrink-0">
                                    </div>
                                    <div>
                                        <p class="font-semibold text-gray-900">{{ $item->name }}</p>
                                        <form method="POST" action="{{ route('cart.update') }}" class="mt-1 flex items-center space-x-4">
                                            @csrf
                                            <input type="hidden" name="menu_item_id" value="{{ $item->id }}">

                                            <label class="text-sm text-gray-700">Jumlah:</label>
                                            <input
                                                type="number"
                                                name="quantity"
                                                value="{{ $row['quantity'] }}"
                                                min="1"
                                                class="w-24 px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-pink-500 focus:border-pink-500"
                                            >

                                            <button type="submit" class="text-xs text-pink-600 hover:text-pink-700 ml-0.1 font-semibold">Update</button>
                                        </form>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <p class="font-semibold text-pink-600">Rp {{ number_format($row['total_price'], 0, ',', '.') }}</p>
                                    <form method="POST" action="{{ route('cart.remove') }}" class="mt-1">
                                        @csrf
                                        <input type="hidden" name="menu_item_id" value="{{ $item->id }}">
                                        <button type="submit" class="text-xs text-red-500 hover:text-red-600">Hapus</button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="flex justify-between items-center border-t border-gray-200 pt-4 mb-4">
                        <p class="text-lg font-semibold text-gray-900">Total</p>
                        <p class="text-2xl font-bold text-pink-600">Rp {{ number_format($total, 0, ',', '.') }}</p>
                    </div>

                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-2">
                        <form method="POST" action="{{ route('cart.clear') }}">
                            @csrf
                            <button
                                type="submit"
                                class="w-full sm:w-auto border border-red-200 text-red-500 font-semibold py-2 px-4 rounded-xl hover:bg-red-50 transition-all text-sm"
                            >
                                Hapus Semua
                            </button>
                        </form>

                        @auth
                            <form method="POST" action="{{ route('order.checkout') }}" class="w-full sm:w-auto">
                                @csrf
                                <button
                                    type="submit"
                                    class="w-full sm:w-auto bg-gradient-to-r from-pink-500 to-orange-500 text-white font-semibold py-3 px-6 rounded-xl hover:from-pink-600 hover:to-orange-600 transition-all text-base text-center"
                                >
                                    Checkout Sekarang
                                </button>
                            </form>
                        @else
                            <a
                                href="{{ route('login') }}"
                                class="w-full sm:w-auto bg-gradient-to-r from-pink-500 to-orange-500 text-white font-semibold py-3 px-6 rounded-xl hover:from-pink-600 hover:to-orange-600 transition-all text-base text-center inline-block"
                            >
                                Login untuk Checkout
                            </a>
                        @endauth
                    </div>

                    @auth
                        <p class="mt-4 text-sm text-gray-500">* Klik checkout untuk memproses pesanan Anda.</p>
                    @else
                        <p class="mt-4 text-sm text-gray-500">* Silakan login terlebih dahulu untuk melakukan checkout.</p>
                    @endauth
                @endif
            </div>
        </main>
    </div>
    @endsection
