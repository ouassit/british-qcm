@extends('layouts.app')

@section('content')
@push('scripts')
    <script src="{{ asset('js/test-import.js') }}?v={{ time() }}"></script>
@endpush

<div class="dashboard-page super-admin-page">
    <section class="dashboard-header admin-dashboard-header">
        <div>
            <p class="dashboard-kicker">Super Admin</p>
            <h1>Import tests</h1>
            <p class="dashboard-subtitle">Copy tests, questions, and answer choices from one center to another.</p>
        </div>
    </section>

    <section class="dashboard-panel import-panel" data-tests-url="{{ route('admin.test-import.tests', ['center' => '__CENTER__']) }}" data-import-url="{{ route('admin.test-import.store') }}">
        <div id="test-import-alert" class="alert admin-alert" role="alert"></div>
        <div class="row">
            <div class="col-md-6 form-group">
                <label for="source-center">Source center</label>
                <select id="source-center" class="form-control">
                    <option value="">Select a source center</option>
                    @foreach($centers as $center)
                        <option value="{{ $center->id }}">{{ $center->name ?: $center->username ?: $center->email }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-6 form-group">
                <label for="destination-center">Destination center</label>
                <select id="destination-center" class="form-control">
                    <option value="">Select a destination center</option>
                    @foreach($centers as $center)
                        <option value="{{ $center->id }}">{{ $center->name ?: $center->username ?: $center->email }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="import-tests-area mb-4">
            <label>Existing tests in destination center</label>
            <div id="destination-tests" class="import-tests-list text-muted">Choose a destination center to view its existing tests.</div>
        </div>

        <div class="import-tests-area">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <label class="mb-0">Tests to import</label>
                <button type="button" id="select-all-tests" class="btn btn-sm btn-outline-secondary" disabled>Select all</button>
            </div>
            <div id="source-tests" class="import-tests-list text-muted">Choose a source center to view its tests.</div>
        </div>

        <div id="import-progress-wrap" class="mt-4 d-none" aria-live="polite">
            <div class="d-flex justify-content-between mb-1"><span id="import-progress-label">Preparing import…</span><span id="import-progress-value">0%</span></div>
            <div class="progress"><div id="import-progress" class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 0%"></div></div>
        </div>

        <div class="mt-4">
            <button type="button" id="import-tests" class="btn btn-primary" disabled>
                <i class="material-icons align-middle" aria-hidden="true">file_copy</i> Import selected tests
            </button>
        </div>
    </section>
</div>
@endsection
