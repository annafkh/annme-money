@extends('layouts.app')
@include('components.bottom-nav')

@section('content')
<div class="px-4 py-6 bg-gradient-to-b from-indigo-50 via-white to-white min-h-screen">

    <!-- Greeting & Avatar -->
    <div class="relative flex items-center justify-between mb-6">
        <div>
            <h1 class="text-xl font-bold text-gray-800">Halo, {{ Auth::user()->name }} 👋</h1>
            <p class="text-sm text-gray-500" id="quoteText">"Kelola keuanganmu, jangan biarkan uang mengelolamu."</p>
        </div>
        <div class="relative">
            <button id="avatarButton" class="focus:outline-none">
                <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=random&color=fff" alt="Avatar" class="w-12 h-12 rounded-full shadow">
            </button>
            <div id="avatarMenu" class="hidden absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50">
                <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Profile</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Logout</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Card Saldo -->
    <div class="bg-gradient-to-r from-blue-500 to-indigo-500 text-white p-6 rounded-2xl shadow-lg mb-6">
        <h2 class="text-sm opacity-80">Total Saldo</h2>
        <p class="text-4xl font-bold mt-2 tracking-wide">Rp {{ number_format($balance, 0, ',', '.') }}</p>
    </div>

 <!-- Ringkasan Pemasukan & Pengeluaran -->
<div class="grid grid-cols-2 gap-4 mb-6">
    <!-- Pemasukan -->
    <div class="bg-white p-4 rounded-2xl shadow-md flex items-center gap-3">
        <div class="bg-green-100 p-3 rounded-full">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 sm:w-6 sm:h-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v8m4-4H8" />
            </svg>
        </div>
        <div>
            <h3 class="text-gray-500 text-xs sm:text-sm">Pemasukan</h3>
            <p class="text-green-600 text-sm sm:text-lg font-bold">
                +Rp {{ number_format($totalIncome, 0, ',', '.') }}
            </p>
        </div>
    </div>

    <!-- Pengeluaran -->
    <div class="bg-white p-4 rounded-2xl shadow-md flex items-center gap-3">
        <div class="bg-red-100 p-3 rounded-full">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 sm:w-6 sm:h-6 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 12H6" />
            </svg>
        </div>
        <div>
            <h3 class="text-gray-500 text-xs sm:text-sm">Pengeluaran</h3>
            <p class="text-red-500 text-sm sm:text-lg font-bold">
                -Rp {{ number_format($totalExpense, 0, ',', '.') }}
            </p>
        </div>
    </div>
</div>

    <!-- Chart Ringkasan -->
    <div class="bg-white p-4 rounded-2xl shadow-md mb-6">
        <canvas id="summaryChart" height="120"></canvas>
    </div>

    <!-- Transaksi Terakhir -->
    <h4 class="text-lg font-semibold text-gray-700 mb-3">Transaksi Terakhir</h4>

    <!-- Form Filter (Tersembunyi) -->
    <form method="GET" action="{{ route('dashboard') }}" class="filter-container bg-white p-4 rounded-xl shadow space-y-3 mt-4" id="filterForm" style="display: none;">
        <div class="space-y-2">
            <label class="text-sm text-gray-600">Dari</label>
            <input type="date" name="from_date" value="{{ request('from_date') }}" class="w-full px-3 py-2 border rounded-lg text-sm">
            <br><br>
            <label class="text-sm text-gray-600">Sampai</label>
            <input type="date" name="to_date" value="{{ request('to_date') }}" class="w-full px-3 py-2 border rounded-lg text-sm">
            <br><br>
            <label class="text-sm text-gray-600">Keyword</label>
            <input type="text" name="keyword" value="{{ request('keyword') }}" class="w-full px-3 py-2 border rounded-lg text-sm" placeholder="Cari: Gaji, Makan, dll">
        </div>
        <button type="submit" class="w-full bg-indigo-600 text-white px-4 py-2 rounded-lg text-sm font-semibold hover:bg-indigo-700 transition">
            Terapkan Filter
        </button>
        <button type="reset" onclick="window.location.href='{{ route('dashboard') }}';" class="w-full bg-gray-300 text-gray-700 px-4 py-2 rounded-lg text-sm font-semibold mt-3 hover:bg-gray-400 transition">
            Reset Filter
        </button>
    </form>

    <!-- List Transaksi -->
    <div class="space-y-3 mt-6">
        @forelse ($recentTransactions as $trx)
            <div class="bg-white p-4 rounded-xl shadow-sm flex justify-between items-center hover:shadow-md transition">
                <div class="flex items-center gap-3">
                    <div class="p-2 rounded-full {{ $trx->type === 'income' ? 'bg-green-100' : 'bg-red-100' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 {{ $trx->type === 'income' ? 'text-green-600' : 'text-red-500' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path d="{{ $trx->type === 'income' ? 'M12 4v16m8-8H4' : 'M18 12H6' }}" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </div>
                    <div>
                        <p class="font-medium text-gray-800">{{ $trx->description }}</p>
                        <p class="text-xs text-gray-500">{{ $trx->created_at->format('d M Y') }}</p>
                    </div>
                </div>
                <p class="{{ $trx->type === 'income' ? 'text-green-600' : 'text-red-500' }} font-semibold">
                    {{ $trx->type === 'income' ? '+' : '-' }}Rp {{ number_format($trx->amount, 0, ',', '.') }}
                </p>
            </div>
        @empty
            <p class="text-center text-gray-400 mt-10">Belum ada transaksi 😅</p>
        @endforelse
    </div>

</div>

<!-- Tombol Filter -->
<button id="toggleFilter" class="fixed bottom-20 right-6 bg-indigo-600 text-white p-4 rounded-full shadow-lg hover:bg-indigo-700 transition duration-300 transform hover:scale-110">
    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
    </svg>
</button>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Toggle Filter
    document.getElementById('toggleFilter').addEventListener('click', function() {
        const filterForm = document.getElementById('filterForm');
        filterForm.style.display = filterForm.style.display === 'none' ? 'block' : 'none';
    });

    // Avatar Menu Toggle
    const avatarButton = document.getElementById('avatarButton');
    const avatarMenu = document.getElementById('avatarMenu');
    avatarButton.addEventListener('click', function(e) {
        e.stopPropagation();
        avatarMenu.classList.toggle('hidden');
    });
    document.addEventListener('click', function(e) {
        if (!avatarMenu.contains(e.target) && !avatarButton.contains(e.target)) {
            avatarMenu.classList.add('hidden');
        }
    });

    // Random Motivasi
    const quotes = [
        "Semangat mengelola keuangan!"
    ];
    document.getElementById("quoteText").innerText = quotes[Math.floor(Math.random() * quotes.length)];

    // Chart.js
    const ctx = document.getElementById('summaryChart').getContext('2d');
    new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: ['Pemasukan', 'Pengeluaran'],
            datasets: [{
                data: [{{ $totalIncome }}, {{ $totalExpense }}],
                backgroundColor: ['#10B981', '#EF4444'],
                borderWidth: 1
            }]
        },
        options: {
            cutout: '70%',
            maintainAspectRatio: false,
            plugins: {
                legend: { position: 'bottom' }
            }
        }
    });
</script>

@endsection
