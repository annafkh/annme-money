<div class="fixed bottom-0 left-0 right-0 bg-white shadow-md border-t z-50">
    <div class="flex justify-around items-center py-7">
        <a href="{{ route('dashboard') }}" class="flex flex-col items-center {{ request()->routeIs('dashboard') ? 'text-blue-600' : 'text-gray-400' }}">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 -mt-6 mb-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10l9-7 9 7v10a2 2 0 01-2 2H5a2 2 0 01-2-2V10z" />
            </svg>
            <span class="text-xs">Beranda</span>
        </a>

        <a href="{{ route('income.index') }}" class="flex flex-col items-center {{ request()->routeIs('income.*') ? 'text-green-600' : 'text-gray-400' }}">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 -mt-6 mb-1" viewBox="0 0 24 24" fill="currentColor">
                <path d="M21 11H11V6l-5 6 5 6v-5h10v-2zM3 4h18a1 1 0 0 1 1 1v2h-2V6H4v12h16v-1h2v2a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V5a1 1 0 0 1 1-1z"/>
            </svg>
            <span class="text-xs">Pemasukan</span>
        </a>

        <a href="{{ route('expense.index') }}" class="flex flex-col items-center {{ request()->routeIs('expense.*') ? 'text-red-600' : 'text-gray-400' }}">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 -mt-6 mb-1" viewBox="0 0 24 24" fill="currentColor">
                <path d="M3 13h10v5l5-6-5-6v5H3v2zm18-9H3a1 1 0 0 0-1 1v2h2V6h16v12H4v-1H2v2a1 1 0 0 0 1 1h18a1 1 0 0 0 1-1V5a1 1 0 0 0-1-1z"/>
            </svg>
            <span class="text-xs">Pengeluaran</span>
        </a>

        <a href="{{ route('goals.index') }}" class="flex flex-col items-center {{ request()->routeIs('goals.*') ? 'text-blue-600' : 'text-gray-400' }}">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 -mt-6 mb-1" viewBox="0 0 24 24" fill="currentColor">
                <path d="M3 3v18h18v-2H5V3H3zm15.59 3.58L13 12.17l-3.29-3.3-4.3 4.3 1.42 1.42L10 11.41l3.29 3.3 5.3-5.29z"/>
            </svg>
            <span class="text-xs">Goals</span>
        </a>
    </div>
</div>
