@extends('layouts.app')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-50 p-4">
  <div class="w-full max-w-sm bg-white rounded-lg shadow-sm p-6">
    <h2 class="text-2xl font-semibold text-gray-800 text-center mb-6">Welcome Back</h2>

    @if(session('status'))
      <div class="mb-4 text-sm text-green-700 bg-green-100 p-3 rounded">
        {{ session('status') }}
      </div>
    @endif
    @if(session('error'))
      <div class="mb-4 text-sm text-red-700 bg-red-100 p-3 rounded">
        {{ session('error') }}
      </div>
    @endif

    <form method="POST" action="{{ route('login') }}" class="space-y-5">
      @csrf

      <div>
        <label for="email" class="block text-sm text-gray-600 mb-1">Email</label>
        <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
               class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-indigo-200"
               placeholder="you@example.com">
        @error('email')
          <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
        @enderror
      </div>

      <div class="relative">
        <label for="password" class="block text-sm text-gray-600 mb-1">Password</label>
        <input id="password" type="password" name="password" required
               class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-indigo-200"
               placeholder="••••••••">
               <br><br>
        <button type="button" onclick="togglePassword()" class="absolute inset-y-0 right-3 flex items-center text-gray-400">
          <svg id="eyeIcon" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none"
               viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7
                     -1.274 4.057-5.064 7-9.542 7
                     -4.478 0-8.268-2.943-9.542-7z"/>
          </svg>
        </button>
        @error('password')
          <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
        @enderror
      </div>

      <div class="flex items-center justify-between text-sm">
        <label class="inline-flex items-center text-gray-600">
          <input type="checkbox" name="remember"
                 class="h-4 w-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-200">
          <span class="ml-2">Remember me</span>
        </label>
        @if(Route::has('password.request'))
          <a href="{{ route('password.request') }}" class="text-indigo-600 hover:underline">
            Forgot password?
          </a>
        @endif
      </div>
      <button type="submit"
              class="w-full py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700 transition">
        Log In
      </button>
    </form>
    <p class="mt-6 text-center text-sm text-gray-600">
      Don’t have an account?
      <a href="{{ route('register') }}" class="text-indigo-600 hover:underline">Sign up</a>
    </p>
    <div class="flex items-center my-6">
      <hr class="flex-grow border-t border-gray-300">
      <span class="mx-4 text-gray-500 text-sm">Or sign in with</span>
      <hr class="flex-grow border-t border-gray-300">
    </div>
  <a
   class="flex items-center justify-center gap-2 bg-white text-gray-700 border border-gray-300 rounded-lg px-4 py-2 shadow hover:bg-gray-50 w-full mt-4">
   <img src="https://www.gstatic.com/firebasejs/ui/2.0.0/images/auth/google.svg" alt="Google" class="h-5 w-5">
   Login with Google
  </a>
  </div>
</div>

<script>
  function togglePassword() {
    const pw = document.getElementById('password');
    const type = pw.type === 'password' ? 'text' : 'password';
    pw.type = type;
  }
</script>
@endsection
