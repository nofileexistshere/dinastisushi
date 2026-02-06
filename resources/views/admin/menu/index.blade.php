@extends('admin.layout')

@section('title', 'Kelola Menu')
@section('page-title', 'Kelola Menu')

@section('content')
<div class="mb-6 flex flex-col gap-4">
    <a href="{{ route('admin.menu.create') }}" class="w-full sm:w-auto px-6 py-3 rounded-lg transition font-semibold flex items-center justify-center shadow-md" style="background-color: #f97316; color: white;">
        <svg class="w-5 h-5 mr-2" fill="white" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd"/>
        </svg>
        <span style="color: white;">Tambah Menu Baru</span>
    </a>
    
    <form method="GET" action="{{ route('admin.menu.index') }}" class="flex flex-col sm:flex-row gap-3 w-full">
        <input 
            type="text" 
            name="search" 
            value="{{ $search }}"
            placeholder="Cari menu..."
            class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500"
        >
        <select 
            name="category" 
            class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500"
        >
            <option value="Semua" {{ $category === 'Semua' ? 'selected' : '' }}>Semua Kategori</option>
            <option value="Nigiri" {{ $category === 'Nigiri' ? 'selected' : '' }}>Nigiri</option>
            <option value="Maki" {{ $category === 'Maki' ? 'selected' : '' }}>Maki</option>
            <option value="Sashimi" {{ $category === 'Sashimi' ? 'selected' : '' }}>Sashimi</option>
            <option value="Special" {{ $category === 'Special' ? 'selected' : '' }}>Special</option>
        </select>
        <button 
            type="submit" 
            class="w-full sm:w-auto bg-orange-600 text-white px-6 py-2 rounded-lg hover:bg-orange-700 transition"
        >
            Filter
        </button>
        @if($search || $category !== 'Semua')
            <a 
                href="{{ route('admin.menu.index') }}" 
                class="w-full sm:w-auto text-center border border-gray-300 text-gray-700 px-6 py-2 rounded-lg hover:bg-gray-50 transition"
            >
                Reset
            </a>
        @endif
    </form>
</div>

<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 md:gap-6">
    @forelse($menuItems as $item)
        <div class="bg-white rounded-xl md:rounded-2xl shadow overflow-hidden hover:shadow-xl transition">
            <img 
                src="{{ $item->image }}" 
                alt="{{ $item->name }}"
                class="w-full h-48 object-cover"
            >
            <div class="p-6">
                <div class="flex justify-between items-start mb-3">
                    <h3 class="text-lg font-bold text-gray-900">{{ $item->name }}</h3>
                    <span class="bg-gray-100 text-gray-700 px-3 py-1 rounded-full text-xs">
                        {{ $item->category }}
                    </span>
                </div>
                
                <p class="text-gray-600 text-sm mb-4">{{ Str::limit($item->description, 80) }}</p>
                
                <div class="flex items-center mb-4">
                    <div class="flex text-yellow-500 mr-2">
                        @for($i = 1; $i <= 5; $i++)
                            @if($i <= floor($item->average_rating))
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                            @else
                                <svg class="w-4 h-4 text-gray-300" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                            @endif
                        @endfor
                    </div>
                    <span class="text-sm text-gray-600">{{ number_format($item->average_rating, 1) }} ({{ $item->rating_count }})</span>
                </div>
                
                <div class="flex justify-between items-center">
                    <p class="text-2xl font-bold text-orange-600">Rp {{ number_format($item->price, 0, ',', '.') }}</p>
                    
                    <div class="flex gap-2">
                        <a 
                            href="{{ route('admin.menu.edit', $item->id) }}" 
                            class="text-blue-600 hover:text-blue-700 font-medium"
                        >
                            Edit
                        </a>
                        <form 
                            method="POST" 
                            action="{{ route('admin.menu.destroy', $item->id) }}" 
                            onsubmit="return confirm('Yakin ingin menghapus menu ini?')"
                            class="inline"
                        >
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-700 font-medium">
                                Hapus
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="col-span-3 text-center py-12 bg-white rounded-2xl shadow">
            <p class="text-gray-500">Tidak ada menu ditemukan.</p>
        </div>
    @endforelse
</div>

@if($menuItems->hasPages())
    <div class="mt-6">
        {{ $menuItems->links() }}
    </div>
@endif
@endsection
