@extends('layouts.app')
@include('components.bottom-nav')

@section('content')
<div class="px-4 py-6 bg-gradient-to-b from-indigo-50 via-white to-white min-h-screen">

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
                <a href="{{ route('profile.edit') }}" 
                class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                Profile
             </a>
             
             <a href="{{ route('categories.index') }}" 
                class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 {{ request()->routeIs('categories.*') ? 'bg-gray-100 font-semibold' : '' }}">
                Kategori
             </a>
             
             <form method="POST" action="{{ route('logout') }}">
                 @csrf
                 <button type="submit" 
                         class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                     Logout
                 </button>
             </form>
             
            </div>
        </div>
    </div>

    <div class="bg-gradient-to-r from-blue-500 to-indigo-500 text-white p-6 rounded-2xl shadow-lg mb-6 relative">
        <h2 class="text-sm opacity-80">Total Saldo</h2>
        <p id="balanceAmount" class="text-4xl font-bold mt-2 tracking-wide">••••••••</p>

        <button onclick="toggleBalance()" class="absolute top-4 right-4 text-white opacity-70 hover:opacity-100">
            <svg id="eyeIcon" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.478 0-8.268-2.943-9.542-7z"/>
            </svg>
        </button>
    </div>

 <div class="grid grid-cols-2 gap-4 mb-6">
    <!-- Pemasukan -->
    <a href="{{ route('income.index') }}"
       class="block bg-white p-2 rounded-2xl shadow-md flex items-center gap-3 hover:shadow-lg transition cursor-pointer">
      <div class="bg-green-100 p-2 rounded-full">
      </div>
      <div>
        <p class="text-gray-500 text-xs">Pemasukan</p>
        <p class="text-green-600 text-sm font-bold" id="incomeAmount">••••••••</p>
      </div>
    </a>
  
    <!-- Pengeluaran -->
    <a href="{{ route('expense.index') }}"
       class="block bg-white p-2 rounded-2xl shadow-md flex items-center gap-3 hover:shadow-lg transition cursor-pointer">
      <div class="bg-red-100 p-2 rounded-full">
      </div>
      <div>
        <p class="text-gray-500 text-xs">Pengeluaran</p>
        <p class="text-red-500 text-sm font-bold" id="expenseAmount">••••••••</p>
      </div>
    </a>
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
            <br><br>
            <label class="text-sm text-gray-600">Kategori</label>
            <select name="category_id" class="w-full px-3 py-2 border rounded-lg text-sm">
                <option value="">Semua Kategori</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
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
    @foreach ($recentTransactions as $trx)
        <div class="bg-white p-4 rounded-xl shadow-sm flex justify-between items-center hover:shadow-md transition">
            <div class="flex items-center gap-3">
                <div class="p-2 rounded-full {{ $trx->type === 'income' ? 'bg-green-100' : 'bg-red-100' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 {{ $trx->type === 'income' ? 'text-green-600' : 'text-red-500' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path d="{{ $trx->type === 'income' ? 'M23.85,.15c-.2-.2-.51-.2-.71,0L1.42,21.88c-.26-.4-.42-.87-.42-1.38V10.5c0-.28-.22-.5-.5-.5s-.5,.22-.5,.5v10c0,1.93,1.57,3.5,3.5,3.5H13.5c.28,0,.5-.22,.5-.5s-.22-.5-.5-.5H3.5c-.51,0-.98-.15-1.38-.42L23.85,.85c.2-.2,.2-.51,0-.71Z' : 
                        'M20.5,0H10.5c-.276,0-.5,.224-.5,.5s.224,.5,.5,.5h10c.509,0,.982,.153,1.378,.415L.146,23.146c-.195,.195-.195,.512,0,.707,.098,.098,.226,.146,.354,.146s.256-.049,.354-.146L22.585,2.122c.262,.395,.415,.869,.415,1.378V13.5c0,.276,.224,.5,.5,.5s.5-.224,.5-.5V3.5c0-1.93-1.57-3.5-3.5-3.5Z' }}" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </div>
                <div>
                    <p class="font-medium text-gray-800 text-sm">{{ $trx->title }}</p>
                    <p class="text-xs text-gray-500">{{ $trx->created_at->format('d M Y') }}</p>
                </div>
            </div>
            <div class="text-right">
                <p class="text-sm text-gray-500">{{ $trx->description }}</p>
                <p class="{{ $trx->type === 'income' ? 'text-green-600' : 'text-red-500' }} font-semibold text-sm">
                    {{ $trx->type === 'income' ? '+' : '-' }}Rp {{ number_format($trx->amount, 0, ',', '.') }}
                </p>
                <p class="text-xs text-gray-400">{{ $trx->created_at->format('d M Y') }}</p>
            </div>
        </div>
    @endforeach

    @if ($recentTransactions->isEmpty())
        <p class="text-center text-gray-400 mt-10">Belum ada transaksi 😅</p>
    @endif
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

    let balanceVisible = false;

    const balanceAmount = document.getElementById('balanceAmount');
    const incomeAmount = document.getElementById('incomeAmount');
    const expenseAmount = document.getElementById('expenseAmount');

    const realBalance = "Rp {{ number_format($balance, 0, ',', '.') }}";
    const realIncome = "Rp {{ number_format($totalIncome, 0, ',', '.') }}";
    const realExpense = "Rp {{ number_format($totalExpense, 0, ',', '.') }}";

    function toggleBalance() {
    balanceVisible = !balanceVisible;
    
    balanceAmount.innerText = balanceVisible ? realBalance : '••••••••';
    incomeAmount.innerText = balanceVisible ? realIncome : '••••••••';
    expenseAmount.innerText = balanceVisible ? realExpense : '••••••••';
        eyeIcon.innerHTML = balanceVisible
    ? `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
        d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a9.978 9.978 0 012.284-3.668M9.88 9.88a3 3 0 104.24 4.24M15 12a3 3 0 00-3-3M3 3l18 18"/>`
    : `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
       <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7
        -1.274 4.057-5.064 7-9.542 7-4.478 0-8.268-2.943-9.542-7z"/>`;
    }
</script>

@endsection
