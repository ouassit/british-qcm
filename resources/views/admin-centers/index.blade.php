@extends('layouts.app')

@section('content')
<div class="dashboard-page super-admin-page">
    <section class="dashboard-header admin-dashboard-header">
        <div>
            <p class="dashboard-kicker">Super Admin</p>
            <h1>Centers</h1>
            <p class="dashboard-subtitle">Manage center accounts and their credentials.</p>
        </div>
        <a href="{{ route('admin.centers.create') }}" class="btn btn-primary"><i class="material-icons align-middle" aria-hidden="true">add_business</i> New center</a>
    </section>

    <section class="dashboard-panel">
        @if(session('success')) <div class="alert alert-success">{{ session('success') }}</div> @endif
        <div class="table-responsive">
            <table class="table table-hover admin-centers-table centers-management-table">
                <thead><tr><th>Center</th><th>Username</th><th>Contact</th><th>Expiration</th><th>Set password</th></tr></thead>
                <tbody>
                    @forelse($centers as $center)
                        <tr>
                            <td><strong>{{ $center->name }}</strong><small class="d-block text-muted">{{ $center->company ?: '—' }}</small></td>
                            <td><code>{{ $center->username }}</code></td>
                            <td>{{ $center->email }}<small class="d-block text-muted">{{ $center->telephone ?: 'No telephone' }}</small></td>
                            <td>{{ $center->expire_date ? $center->expire_date->format('Y-m-d') : 'No date' }}</td>
                            <td>
                                <form method="POST" action="{{ route('admin.centers.reset-password', $center) }}" class="center-password-form">
                                    @csrf
                                    <input type="password" name="password" class="form-control form-control-sm @error('password') is-invalid @enderror" placeholder="New password (min. 4)" minlength="4" required>
                                    <input type="password" name="password_confirmation" class="form-control form-control-sm" placeholder="Confirm password" minlength="4" required>
                                    <button class="btn btn-sm btn-warning" type="submit">Update password</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5"><div class="empty-state"><strong>No centers found</strong><span>Create your first center to get started.</span></div></td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>
</div>
@endsection
