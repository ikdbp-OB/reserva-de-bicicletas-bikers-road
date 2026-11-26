@extends('layouts.app')

@section('title', 'Login')

@section('content')

    <div class="login-container">
        <div class="login-header">
            <h1>{{ __('pid_login') }}</h1>
        </div>

        <!-- Session Status -->
        <x-auth-session-status class="login-status" :status="session('status')" />

        <form method="POST" action="{{ route('login') }}" class="login-form">
            @csrf

            <!-- Email Address -->
            <div class="login-group">
                <x-input-label for="email" :value="__('pid_email')" />
                <x-text-input id="email" class="login-input" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="login-error" />
            </div>

            <!-- Password -->
            <div class="login-group">
                <x-input-label for="password" :value="__('pid_password')" />

                <x-text-input id="password" class="login-input"
                                type="password"
                                name="password"
                                required autocomplete="current-password" />

                <x-input-error :messages="$errors->get('password')" class="login-error" />
            </div>

            <!-- Remember Me -->
            <div class="login-remember">
                <label for="remember_me" class="">
                    <input id="remember_me" type="checkbox" class="" name="remember">
                    <span class="">{{ __('pid_remember_me') }}</span>
                </label>
            </div>

            <div class="login-links">
                @if (Route::has('password.request'))
                    <a class="login-link" href="{{ route('password.request') }}">
                        {{ __('pid_forgot_password') }}
                    </a>
                @endif

                @if (Route::has('register'))
                    <a class="login-link" href="{{ route('register') }}">
                        {{ __('pid_register') }}
                    </a>
                @endif
            </div>

            <div class="login-actions">
                <x-primary-button class="login-button">
                    {{ __('Log in') }}
                </x-primary-button>
            </div>
        </form>
    </div>

@endsection