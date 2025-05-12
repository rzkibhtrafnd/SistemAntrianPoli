@extends('layouts.app')

@section('content')
<div class="flex items-center justify-center min-h-screen bg-gray-100">
    <div class="w-full max-w-md p-8 bg-white shadow-lg rounded-lg">
        <h2 class="text-center text-3xl font-semibold text-gray-700 mb-6">{{ __('Login') }}</h2>

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Email -->
            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-700">{{ __('Email Address') }}</label>
                <input id="email" type="email" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                @error('email')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <!-- Password -->
            <div class="mb-6">
                <label for="password" class="block text-sm font-medium text-gray-700">{{ __('Password') }}</label>
                <input id="password" type="password" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" name="password" required autocomplete="current-password">
                @error('password')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <!-- Remember Me -->
            <div class="flex items-center justify-between mb-6">
                <div class="flex items-center">
                    <input id="remember" type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }} class="h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                    <label for="remember" class="ml-2 text-sm text-gray-600">{{ __('Remember Me') }}</label>
                </div>
                @if (Route::has('password.request'))
                    <a class="text-sm text-blue-500 hover:text-blue-700" href="{{ route('password.request') }}">
                        {{ __('Forgot Your Password?') }}
                    </a>
                @endif
            </div>

            <div class="flex justify-center">
                <button type="submit" class="w-full px-4 py-2 text-white bg-blue-500 hover:bg-blue-600 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    {{ __('Login') }}
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
