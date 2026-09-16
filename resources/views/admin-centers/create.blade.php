@extends('layouts.app')

@section('content')
<div class="dashboard-page super-admin-page">
    <section class="dashboard-header admin-dashboard-header">
        <div>
            <p class="dashboard-kicker">Super Admin</p>
            <h1>Create center</h1>
            <p class="dashboard-subtitle">Create a new center account. Tests and questions can then be imported from another center.</p>
        </div>
    </section>

    <section class="dashboard-panel import-panel">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <form method="POST" action="{{ route('admin.centers.store') }}">
            @csrf
            <div class="row">
                <div class="col-md-6 form-group">
                    <label for="name">Center name</label>
                    <input id="name" name="name" type="text" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required autofocus>
                    @error('name') <span class="invalid-feedback">{{ $message }}</span> @enderror
                </div>
                <div class="col-md-6 form-group">
                    <label for="username">Username</label>
                    <input id="username" name="username" type="text" class="form-control @error('username') is-invalid @enderror" value="{{ old('username') }}" required>
                    @error('username') <span class="invalid-feedback">{{ $message }}</span> @enderror
                </div>
                <div class="col-md-6 form-group">
                    <label for="email">Email</label>
                    <input id="email" name="email" type="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required>
                    @error('email') <span class="invalid-feedback">{{ $message }}</span> @enderror
                </div>
                <div class="col-md-6 form-group">
                    <label for="telephone">Telephone <small>(optional)</small></label>
                    <input id="telephone" name="telephone" type="text" class="form-control @error('telephone') is-invalid @enderror" value="{{ old('telephone') }}">
                    @error('telephone') <span class="invalid-feedback">{{ $message }}</span> @enderror
                </div>
                <div class="col-md-6 form-group">
                    <label for="company">Company <small>(optional)</small></label>
                    <input id="company" name="company" type="text" class="form-control @error('company') is-invalid @enderror" value="{{ old('company') }}">
                    @error('company') <span class="invalid-feedback">{{ $message }}</span> @enderror
                </div>
                <div class="col-md-6 form-group">
                    <label for="expire_date">Expiration date <small>(defaults to one month)</small></label>
                    <input id="expire_date" name="expire_date" type="date" class="form-control @error('expire_date') is-invalid @enderror" value="{{ old('expire_date') }}">
                    @error('expire_date') <span class="invalid-feedback">{{ $message }}</span> @enderror
                </div>
                <div class="col-md-6 form-group">
                    <label for="password">Password</label>
                    <input id="password" name="password" type="password" class="form-control @error('password') is-invalid @enderror" required>
                    @error('password') <span class="invalid-feedback">{{ $message }}</span> @enderror
                </div>
                <div class="col-md-6 form-group">
                    <label for="password_confirmation">Confirm password</label>
                    <input id="password_confirmation" name="password_confirmation" type="password" class="form-control" required>
                </div>
            </div>
            <button type="submit" class="btn btn-primary"><i class="material-icons align-middle" aria-hidden="true">add_business</i> Create center</button>
        </form>
    </section>
</div>
@endsection
