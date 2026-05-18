@extends('admin.layout')

@section('content')
<div>
    <div class="mb-8">
        <a href="{{ route('admin.menu.index') }}" class="text-amber-600 hover:text-amber-800">← Kembali ke Menu</a>
    </div>

    <h1 class="text-3xl font-bold text-gray-800 mb-8">Edit Menu</h1>

    <div class="bg-white rounded-xl shadow-md p-6">
        <form action="{{ route('admin.menu.update', $menuItem) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-gray-700 font-medium mb-2">Kategori *</label>
                    <select name="category_id" required class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-transparent">
                        <option value="">Pilih Kategori</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ $menuItem->category_id == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-gray-700 font-medium mb-2">Nama Menu *</label>
                    <input type="text" name="name" required value="{{ $menuItem->name }}" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-transparent" placeholder="Masukkan nama menu">
                </div>

                <div class="md:col-span-2">
                    <label class="block text-gray-700 font-medium mb-2">Deskripsi</label>
                    <textarea name="description" rows="3" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-transparent" placeholder="Masukkan deskripsi menu">{{ $menuItem->description }}</textarea>
                </div>

                <div>
                    <label class="block text-gray-700 font-medium mb-2">Harga *</label>
                    <input type="number" name="price" required step="0.01" min="0" value="{{ $menuItem->price }}" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-transparent" placeholder="Masukkan harga">
                </div>

                <div>
                    <label class="block text-gray-700 font-medium mb-2">Gambar</label>
                    <input type="file" name="image" accept="image/*" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-transparent">
                    @if($menuItem->image)
                        <p class="mt-2 text-sm text-gray-500">Gambar saat ini: <img src="{{ asset('storage/' . $menuItem->image) }}" alt="{{ $menuItem->name }}" class="w-20 h-20 object-cover rounded mt-1"></p>
                    @endif
                </div>

                <div>
                    <label class="block text-gray-700 font-medium mb-2">Status</label>
                    <label class="flex items-center">
                        <input type="checkbox" name="is_available" value="1" {{ $menuItem->is_available ? 'checked' : '' }} class="mr-2">
                        <span>Tersedia</span>
                    </label>
                </div>
            </div>

            <div class="mt-6">
                <button type="submit" class="bg-amber-600 text-white px-6 py-2 rounded-lg hover:bg-amber-700 transition">
                    Update Menu
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
