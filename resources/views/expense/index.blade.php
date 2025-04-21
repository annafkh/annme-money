@extends('layouts.app')
@include('components.bottom-nav')

@section('content')
<div class="px-4 py-6 bg-gray-50 min-h-screen">
    <!-- Header -->
    <h1 class="text-3xl font-bold mb-6 text-red-600 flex items-center gap-2">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m5,20c0,.552-.448,1-1,1s-1-.448-1-1,.448-1,1-1,1,.448,1,1Zm15-9c-.552,0-1,.448-1,1s.448,1,1,1,1-.448,1-1-.448-1-1-1Zm-16,0c-.552,0-1,.448-1,1s.448,1,1,1,1-.448,1-1-.448-1-1-1Zm16,8c-.552,0-1,.448-1,1s.448,1,1,1,1-.448,1-1-.448-1-1-1Zm4-6.5v7c0,2.481-2.019,4.5-4.5,4.5H4.5c-2.481,0-4.5-2.019-4.5-4.5v-7c0-2.481,2.019-4.5,4.5-4.5h7V1.276l-2.651,2.582c-.097.095-.223.142-.349.142-.13,0-.26-.051-.358-.151-.192-.197-.188-.514.01-.707L10.925.44c.244-.244.681-.44,1.075-.44s.809.213,1.041.445l2.806,2.694c.199.191.205.508.014.707-.19.198-.506.206-.707.014l-2.653-2.548v6.688h7c2.481,0,4.5,2.019,4.5,4.5Zm-1,0c0-1.93-1.57-3.5-3.5-3.5H4.5c-1.93,0-3.5,1.57-3.5,3.5v7c0,1.93,1.57,3.5,3.5,3.5h15c1.93,0,3.5-1.57,3.5-3.5v-7Zm-7,3.5c0,2.206-1.794,4-4,4s-4-1.794-4-4,1.794-4,4-4,4,1.794,4,4Zm-1,0c0-1.654-1.346-3-3-3s-3,1.346-3,3,1.346,3,3,3,3-1.346,3-3Z" />
        </svg>
        Pengeluaran
    </h1>

    <!-- Add Button -->
    <div class="flex justify-end items-center mb-4">
        <a href="{{ route('expense.create') }}"
        class="bg-green-500 text-white px-4 py-2 rounded-xl hover:bg-green-600 transition duration-300">
            + Tambah
        </a>
    </div>

    <!-- Expense List -->
    <div class="space-y-6">
        @if($expenses->isEmpty())
            <div class="text-center text-gray-400 mt-20 flex flex-col items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-16 h-16 text-red-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 14l6-6M15 14l-6-6" />
                </svg>
                <p class="text-lg font-semibold text-gray-600">Belum ada Pengeluaran</p>
                <p class="mt-1 text-sm text-gray-500">Ingat jangan boros-boros!</p>
                <a href="{{ route('expense.create') }}"
                   class="mt-4 bg-red-500 text-white px-6 py-3 rounded-xl hover:bg-red-600 transition duration-300">
                    + Tambah Pengeluaran
                </a>
            </div>
        @else
            @foreach($expenses as $expense)
                <div class="bg-white p-6 rounded-2xl shadow-md hover:shadow-lg transition-shadow duration-300">
                    <div class="flex justify-between items-start">
                        <div class="flex-1">
                            <h2 class="text-xl font-semibold text-gray-800">{{ $expense->title }}</h2>
                            <p class="text-sm text-gray-500 mt-1">{{ optional($expense->category)->name ?? '-' }}</p>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm text-gray-400">{{ $expense->date }}</p>
                            <p class="text-lg font-bold text-red-600">Rp {{ number_format($expense->amount, 0, ',', '.') }}</p>
                        </div>
                    </div>

                    <!-- Edit & Delete -->
                    <div class="flex justify-end items-center space-x-2 mt-4">
                        <form action="{{ route('expense.edit', $expense->id) }}" method="GET">
                            <button type="submit"
                            class="px-3 py-1 text-sm text-white bg-yellow-500 rounded-lg hover:bg-yellow-600">
                                Edit
                            </button>
                        </form>

                        <form action="{{ route('expense.destroy', $expense->id) }}" method="POST"
                            onsubmit="return confirm('Yakin ingin menghapus pengeluaran ini?');"
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
        @endif
    </div>
</div>
@endsection
