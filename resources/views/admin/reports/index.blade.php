@extends('admin.layout')

@section('title', 'Laporan')
@section('page-title', 'Laporan')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <!-- Report 1: Laporan Penjualan -->
    <a href="{{ route('admin.reports.sales') }}" class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-lg hover:border-orange-300 transition group">
        <div class="flex items-center mb-4">
            <div class="w-14 h-14 bg-green-100 rounded-xl flex items-center justify-center group-hover:bg-green-200 transition">
                <svg class="w-7 h-7 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/>
                </svg>
            </div>
        </div>
        <h3 class="text-lg font-semibold text-gray-800 mb-2">Laporan Penjualan</h3>
        <p class="text-sm text-gray-500">Lihat detail penjualan, pendapatan harian, dan riwayat transaksi.</p>
        <div class="mt-4 flex items-center text-orange-600 text-sm font-medium">
            Lihat Laporan
            <svg class="w-4 h-4 ml-1 group-hover:translate-x-1 transition" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd"/>
            </svg>
        </div>
    </a>

    <!-- Report 2: Laporan Menu Terlaris -->
    <a href="{{ route('admin.reports.top-menu') }}" class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-lg hover:border-orange-300 transition group">
        <div class="flex items-center mb-4">
            <div class="w-14 h-14 bg-orange-100 rounded-xl flex items-center justify-center group-hover:bg-orange-200 transition">
                <svg class="w-7 h-7 text-orange-600" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                </svg>
            </div>
        </div>
        <h3 class="text-lg font-semibold text-gray-800 mb-2">Laporan Menu Terlaris</h3>
        <p class="text-sm text-gray-500">Analisis menu paling populer dan performa penjualan per kategori.</p>
        <div class="mt-4 flex items-center text-orange-600 text-sm font-medium">
            Lihat Laporan
            <svg class="w-4 h-4 ml-1 group-hover:translate-x-1 transition" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd"/>
            </svg>
        </div>
    </a>

    <!-- Report 3: Laporan Pengguna -->
    <a href="{{ route('admin.reports.users') }}" class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-lg hover:border-orange-300 transition group">
        <div class="flex items-center mb-4">
            <div class="w-14 h-14 bg-blue-100 rounded-xl flex items-center justify-center group-hover:bg-blue-200 transition">
                <svg class="w-7 h-7 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"/>
                </svg>
            </div>
        </div>
        <h3 class="text-lg font-semibold text-gray-800 mb-2">Laporan Pengguna</h3>
        <p class="text-sm text-gray-500">Data pelanggan, pelanggan aktif, dan top spenders.</p>
        <div class="mt-4 flex items-center text-orange-600 text-sm font-medium">
            Lihat Laporan
            <svg class="w-4 h-4 ml-1 group-hover:translate-x-1 transition" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd"/>
            </svg>
        </div>
    </a>

    <!-- Report 4: Laporan Rating -->
    <a href="{{ route('admin.reports.ratings') }}" class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-lg hover:border-orange-300 transition group">
        <div class="flex items-center mb-4">
            <div class="w-14 h-14 bg-yellow-100 rounded-xl flex items-center justify-center group-hover:bg-yellow-200 transition">
                <svg class="w-7 h-7 text-yellow-600" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                </svg>
            </div>
        </div>
        <h3 class="text-lg font-semibold text-gray-800 mb-2">Laporan Rating</h3>
        <p class="text-sm text-gray-500">Analisis rating dan review dari pelanggan untuk setiap menu.</p>
        <div class="mt-4 flex items-center text-orange-600 text-sm font-medium">
            Lihat Laporan
            <svg class="w-4 h-4 ml-1 group-hover:translate-x-1 transition" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd"/>
            </svg>
        </div>
    </a>
</div>
@endsection
