@extends('layouts.app')
@include('components.bottom-nav')
@section('content')
<div class="p-4">
    <div class="flex justify-between items-center mb-4">
        <h1 class="text-xl font-bold">Kategori</h1>
        <a href="{{ route('categories.create') }}"
            class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-xl">+ Tambah</a>
    </div>

    @foreach($categories as $category)
        <div class="bg-white shadow p-4 rounded-xl mb-2 flex justify-between items-center">
            <div>
                <p class="font-semibold">{{ $category->name }}</p>
                <p class="text-sm text-gray-500 capitalize">{{ $category->type }}</p>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('categories.edit', $category) }}"
                    class="text-blue-500 hover:underline">Edit</a>
                <form action="{{ route('categories.destroy', $category) }}" method="POST"
                    onsubmit="return confirm('Yakin hapus kategori ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-red-500 hover:underline">Hapus</button>
                </form>
            </div>
        </div>
    @endforeach
</div>
@endsection