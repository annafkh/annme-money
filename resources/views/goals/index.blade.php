@extends('layouts.app')
@include('components.bottom-nav')

@section('content')
<div class="px-4 py-6 bg-gray-50 min-h-screen">

    <!-- Header -->
    <h1 class="text-3xl font-bold mb-6 text-teal-700 flex items-center gap-2">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-teal-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6l4 2" />
            <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2" fill="none"/>
        </svg>
        Goals
    </h1>
    
    <!-- Header -->
    @if (!$goals->isEmpty())
    <div class="flex justify-between items-center mb-4">
        <a href="{{ route('goals.create') }}"
           class="bg-green-500 text-white px-4 py-2 rounded-xl hover:bg-green-600 transition duration-300">
            + Tambah
        </a>
    </div>
    @endif


    <!-- Goal List -->
    <div class="space-y-6">
        <div class="space-y-4">
            @if($goals->isEmpty())
                <div class="text-center text-gray-400 mt-20 flex flex-col items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-16 h-16 text-yellow-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6l4 2" />
                        <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2" fill="none"/>
                    </svg>
                    <p class="text-lg font-semibold text-gray-600">Belum ada goal 😢</p>
                    <p class="mt-1 text-sm text-gray-500">Ayo buat impian!</p>
                    <a href="{{ route('goals.create') }}"
                    class="mt-4 bg-yellow-400 text-white px-6 py-3 rounded-xl hover:bg-yellow-500 transition duration-300">
                     + Buat Goal
                 </a>
                </div>
            @endif

        @foreach ($goals as $goal)
        <div class="bg-white p-6 rounded-2xl shadow-md hover:shadow-lg transition-shadow duration-300">
            <div class="flex justify-between items-start">
                <div class="flex-1">
                    <h2 class="text-xl font-semibold text-gray-800">{{ $goal->title }}</h2>
                    <p class="text-sm text-gray-500 mt-1">{{ $goal->description }}</p>
                </div>
                <div class="ml-4">
                    @if ($goal->progress >= $goal->target)
                    <span class="inline-block px-3 py-1 text-sm font-medium text-green-700 bg-green-100 rounded-full">
                        🎉 Goal Tercapai!
                    </span>
                    @else
                    <p class="text-sm text-gray-400">{{ 'Rp' . number_format($goal->progress, 0, ',', '.') }} / {{ 'Rp' . number_format($goal->target, 0, ',', '.') }}</p>
                    @endif
                </div>
            </div>

            <!-- Progress Bar -->
            <div class="mt-4">
                <div class="w-full h-3 bg-gray-200 rounded-full overflow-hidden">
                    <div class="h-full bg-teal-500 rounded-full transition-all duration-500"
                         style="width: {{ $goal->target > 0 ? ($goal->progress / $goal->target) * 100 : 0 }}%;">
                    </div>
                </div>
                <p class="text-sm text-gray-500 mt-1">
                    {{ $goal->target > 0 ? number_format($goal->progress / $goal->target * 100, 2) : '0.00' }}% tercapai
                </p>                
            </div>

            <!-- Edit & Delete -->
            <div class="flex justify-end items-center space-x-2 mt-4">
                @if ($goal->progress < $goal->target)
                    <form action="{{ route('goals.edit', $goal->id) }}" method="GET">
                        <button type="submit"
                                class="px-3 py-1 text-sm text-white bg-yellow-500 rounded-lg hover:bg-yellow-600">
                            Edit
                        </button>
                    </form>
                @endif
            
                <!-- Button Detail -->
                <form action="{{ route('goals.show', $goal->id) }}" method="GET">
                    <button type="submit"
                            class="px-3 py-1 text-sm text-white bg-teal-500 rounded-lg hover:bg-teal-600">
                        Detail
                    </button>
                </form>
            
                <form action="{{ route('goals.destroy', $goal->id) }}" method="POST"
                      onsubmit="return confirm('Yakin ingin menghapus goal ini?');"
                      class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                            class="px-3 py-1 text-sm text-white bg-red-500 rounded-lg hover:bg-red-600">
                        Hapus
                    </button>
                </form>
            </div>
        </div>
        @endforeach
    </div>

</div>
@endsection
