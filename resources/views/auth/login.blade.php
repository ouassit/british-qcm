@extends('layouts.app')

@section('content')
<div class="login-page">
    <section class="login-card">
        <div class="login-panel">
            <span class="app-brand-mark login-brand-mark">PT</span>
            <p class="dashboard-kicker">Placement Test Platform</p>
            <h1>Sign in</h1>
            <p>Access your dashboard, manage placement tests, and follow student progress.</p>

            <div class="login-feature-list">
                <span><i class="material-icons" aria-hidden="true">dashboard</i> Center statistics</span>
                <span><i class="material-icons" aria-hidden="true">assignment</i> Student tests</span>
                <span><i class="material-icons" aria-hidden="true">verified_user</i> Secure access</span>
            </div>
        </div>

        <div class="login-form-panel">
            <div class="login-form-heading">
                <h2>{{ __('Welcome back') }}</h2>
                <p>{{ __('Use your username and password to continue.') }}</p>
            </div>

            <form method="POST" action="{{ route('login') }}" class="login-form">
                @csrf

                <div class="form-group">
                    <label for="username">{{ __('Username') }}</label>
                    <div class="input-icon-field">
                        <i class="material-icons" aria-hidden="true">person</i>
                        <input id="username" type="text" class="form-control @error('username') is-invalid @enderror" name="username" value="{{ old('username') }}" required autocomplete="username" autofocus>
                    </div>

                    @error('username')
                        <span class="invalid-feedback d-block" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password">{{ __('Password') }}</label>
                    <div class="input-icon-field">
                        <i class="material-icons" aria-hidden="true">lock</i>
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                    </div>

                    @error('password')
                        <span class="invalid-feedback d-block" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="login-options">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                        <label class="form-check-label" for="remember">
                            {{ __('Remember me') }}
                        </label>
                    </div>

                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}">
                            {{ __('Forgot password?') }}
                        </a>
                    @endif
                </div>

                <button type="submit" class="btn btn-primary login-submit">
                    <i class="material-icons" aria-hidden="true">login</i>
                    <span>{{ __('Login') }}</span>
                </button>
            </form>
        </div>
    </section>
</div>
@endsection
