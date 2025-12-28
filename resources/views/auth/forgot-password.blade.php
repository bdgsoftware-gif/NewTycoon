@extends('frontend.layouts.guest')

@section('title', 'Forgot Password')

@section('card-header', 'Reset Your Password')

@section('content')
    <div class="mb-6 text-sm text-gray-600">
        {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
    </div>

    <!-- Session Status -->
    @if (session('status'))
        <div class="mb-4 font-medium text-sm text-green-600 bg-green-50 border border-green-200 rounded-md p-3">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <!-- Email Address -->
        <div class="mb-6">
            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">
                {{ __('Email Address') }}
            </label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i class="fas fa-envelope text-gray-400"></i>
                </div>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                    class="w-full pl-10 pr-3 py-2.5 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary transition duration-150 ease-in-out"
                    placeholder="Enter your email address">
            </div>
            @error('email')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Submit Button -->
        <div class="flex items-center justify-between">
            <a href="{{ route('login') }}"
                class="text-sm text-gray-600 hover:text-primary transition-colors duration-200 flex items-center">
                <i class="fas fa-arrow-left mr-2"></i>
                {{ __('Back to Login') }}
            </a>

            <button type="submit"
                class="bg-primary hover:bg-primary-dark text-white px-5 py-2.5 rounded-lg font-medium transition-colors duration-200 shadow-sm hover:shadow flex items-center">
                <i class="fas fa-paper-plane mr-2"></i>
                {{ __('Reset Password') }}
            </button>
        </div>
    </form>
@endsection

@section('card-footer')
    <p class="text-sm text-gray-600 text-center">
        {{ __("Didn't receive the email? Check your spam folder or") }}
        <a href="{{ route('password.request') }}" class="text-primary hover:underline font-medium">
            {{ __('try again') }}
        </a>
    </p>
@endsection
