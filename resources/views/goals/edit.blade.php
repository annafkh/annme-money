@extends('layouts.app')
@include('components.bottom-nav')

@section('content')
<div class="px-4 py-6 bg-gray-50 min-h-screen">
    <h1 class="text-3xl font-bold mb-6 text-teal-700">✏️ Edit Goal</h1>

    <form action="{{ route('goals.update', $goal->id) }}" method="POST" class="bg-white p-6 rounded-2xl shadow-md space-y-5">
        @csrf
        @method('PUT')

        <div>
            <label for="title" class="block text-sm font-semibold text-gray-700 mb-1">Judul Goal</label>
            <input type="text" name="title" id="title"
                class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-teal-500"
                value="{{ $goal->title }}" required>
        </div>

        <div>
            <label for="description" class="block text-sm font-semibold text-gray-700 mb-1">Deskripsi</label>
            <textarea name="description" id="description" rows="3"
                class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-teal-500">{{ $goal->description }}</textarea>
        </div>

        <div>
            <label for="target" class="block text-sm font-semibold text-gray-700 mb-1">Target Nominal</label>
            <input type="number" name="target" id="target"
                class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-teal-500"
                value="{{ $goal->target }}" required min="1">
        </div>

        <div class="flex justify-between">
            <a href="{{ route('goals.index') }}" class="text-sm text-gray-500 hover:underline">← Kembali</a>
            <button type="submit"
                class="bg-teal-600 text-white px-6 py-2 rounded-xl hover:bg-teal-700 transition duration-300">
                Update Goal
            </button>
        </div>
    </form>
</div>
@endsection
