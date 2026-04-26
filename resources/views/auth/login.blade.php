@extends('layouts.auth')

@section('title', 'Login')

@section('content')
    <h2 class="auth-heading">Welcome back</h2>
    <p class="auth-subheading">Sign in to your salon account</p>

    @if ($errors->any())
        <div style="background:rgba(201,106,106,0.12);color:#c96a6a;border:1px solid rgba(201,106,106,0.3);padding:12px 16px;border-radius:8px;font-size:0.85rem;margin-bottom:20px;">
            {{ $errors->first() }}
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="form-group">
            <label class="form-label" for="email">Email Address</label>
            <input
                type="email"
                id="email"
                name="email"
                class="form-control"
                value="{{ old('email') }}"
                required
                autofocus
                placeholder="admin@gmail.com"
            >
            @error('email')
                <p class="form-error">{{ $message }}</p>
            @enderror
        </div>

        <div class="form-group">
            <label class="form-label" for="password">Password</label>
            <input
                type="password"
                id="password"
                name="password"
                class="form-control"
                required
                placeholder="••••••••"
            >
            @error('password')
                <p class="form-error">{{ $message }}</p>
            @enderror
        </div>

        <div class="remember-row">
            <input type="checkbox" id="remember_me" name="remember">
            <label for="remember_me">Remember me</label>
        </div>

        <button type="submit" class="btn-login">Sign In</button>
    </form>
@endsection
