@extends('layouts.app')

@section('content')
<div class="login-page">
    <section class="login-card">
        <div class="login-panel">
            <span class="app-brand-mark login-brand-mark">PT</span>
            <p class="dashboard-kicker">New client setup</p>
            <h1>Create account</h1>
            <p>Start with demo categories, a demo placement test, and sample questions so you can explore the platform immediately.</p>

            <div class="login-feature-list">
                <span><i class="material-icons" aria-hidden="true">category</i> Grammar and Listening categories</span>
                <span><i class="material-icons" aria-hidden="true">assignment</i> Demo placement test</span>
                <span><i class="material-icons" aria-hidden="true">quiz</i> Sample questions and answers</span>
            </div>
        </div>

        <div class="login-form-panel">
            <div class="login-form-heading">
                <h2>{{ __('Create your workspace') }}</h2>
                <p>{{ __('Use your username to sign in after registration.') }}</p>
            </div>

                    <form method="POST" action="{{ route('register') }}" class="login-form">
                        @csrf

                        <div class="form-group">
                            <label for="name">{{ __('Center name') }}</label>
                            <div class="input-icon-field">
                                <i class="material-icons" aria-hidden="true">business</i>
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                            </div>

                            @error('name')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="username">{{ __('Username') }}</label>
                            <div class="input-icon-field">
                                <i class="material-icons" aria-hidden="true">person</i>
                                <input id="username" type="text" class="form-control @error('username') is-invalid @enderror" name="username" value="{{ old('username') }}" required autocomplete="username">
                            </div>

                            @error('username')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="email">{{ __('Email address') }}</label>
                            <div class="input-icon-field">
                                <i class="material-icons" aria-hidden="true">mail</i>
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">
                            </div>

                            @error('email')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="company">{{ __('Company') }}</label>
                            <div class="input-icon-field">
                                <i class="material-icons" aria-hidden="true">store</i>
                                <input id="company" type="text" class="form-control @error('company') is-invalid @enderror" name="company" value="{{ old('company') }}" required autocomplete="organization">
                            </div>

                            @error('company')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="telephone">{{ __('Telephone') }}</label>
                            <div class="input-icon-field">
                                <i class="material-icons" aria-hidden="true">phone</i>
                                <input id="telephone" type="text" class="form-control @error('telephone') is-invalid @enderror" name="telephone" value="{{ old('telephone') }}" required autocomplete="tel">
                            </div>

                            @error('telephone')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="password">{{ __('Password') }}</label>
                            <div class="input-icon-field">
                                <i class="material-icons" aria-hidden="true">lock</i>
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                            </div>

                            @error('password')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="password-confirm">{{ __('Confirm password') }}</label>
                            <div class="input-icon-field">
                                <i class="material-icons" aria-hidden="true">verified_user</i>
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary login-submit">
                            <i class="material-icons" aria-hidden="true">person_add</i>
                            <span>{{ __('Create account') }}</span>
                        </button>

                        <p class="mt-3 mb-0">
                            <a href="{{ route('login') }}">{{ __('Already have an account? Login') }}</a>
                        </p>
                    </form>
        </div>
    </section>
</div>
@endsection
