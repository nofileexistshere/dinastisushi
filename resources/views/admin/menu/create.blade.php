@extends('admin.layout')

@section('title', 'Tambah Menu Baru')
@section('page-title', 'Tambah Menu Baru')

@section('content')
<div class="max-w-3xl">
    <div class="bg-white rounded-2xl shadow p-6">
        <form method="POST" action="{{ route('admin.menu.store') }}">
            @csrf
            
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">Nama Menu *</label>
                <input 
                    type="text" 
                    name="name" 
                    value="{{ old('name') }}"
                    required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 @error('name') border-red-500 @enderror"
                    placeholder="Contoh: Salmon Nigiri"
                >
                @error('name')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">Deskripsi *</label>
                <textarea 
                    name="description" 
                    rows="4"
                    required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 @error('description') border-red-500 @enderror"
                    placeholder="Deskripsi menu..."
                >{{ old('description') }}</textarea>
                @error('description')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Harga (Rp) *</label>
                    <input 
                        type="number" 
                        name="price" 
                        value="{{ old('price') }}"
                        min="0"
                        step="1000"
                        required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 @error('price') border-red-500 @enderror"
                        placeholder="25000"
                    >
                    @error('price')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Kategori *</label>
                    <select 
                        name="category" 
                        required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 @error('category') border-red-500 @enderror"
                    >
                        <option value="">Pilih Kategori</option>
                        <option value="Nigiri" {{ old('category') === 'Nigiri' ? 'selected' : '' }}>Nigiri</option>
                        <option value="Maki" {{ old('category') === 'Maki' ? 'selected' : '' }}>Maki</option>
                        <option value="Sashimi" {{ old('category') === 'Sashimi' ? 'selected' : '' }}>Sashimi</option>
                        <option value="Special" {{ old('category') === 'Special' ? 'selected' : '' }}>Special</option>
                    </select>
                    @error('category')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">URL Gambar *</label>
                <input 
                    type="url" 
                    name="image" 
                    value="{{ old('image') }}"
                    required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 @error('image') border-red-500 @enderror"
                    placeholder="https://images.unsplash.com/..."
                >
                <p class="mt-1 text-xs text-gray-500">Gunakan URL gambar dari Unsplash atau sumber lainnya</p>
                @error('image')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">Tags (opsional)</label>
                <input 
                    type="text" 
                    name="tags" 
                    value="{{ old('tags') }}"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 @error('tags') border-red-500 @enderror"
                    placeholder="Salmon, Nasi Sushi, Nori (pisahkan dengan koma)"
                >
                <p class="mt-1 text-xs text-gray-500">Pisahkan dengan koma. Contoh: Salmon, Premium, Pedas</p>
                @error('tags')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex gap-3">
                <button 
                    type="submit" 
                    class="bg-orange-600 text-white px-6 py-3 rounded-lg hover:bg-orange-700 transition font-semibold"
                >
                    Simpan Menu
                </button>
                <a 
                    href="{{ route('admin.menu.index') }}" 
                    class="border border-gray-300 text-gray-700 px-6 py-3 rounded-lg hover:bg-gray-50 transition font-semibold"
                >
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
