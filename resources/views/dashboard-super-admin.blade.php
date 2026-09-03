@extends('layouts.app')

@section('content')
@push('scripts')
   <script src="{{ asset('js/admin-dashboard.js') }}?v={{ time() }}"></script>
@endpush

<div class="dashboard-page super-admin-page">
   <section class="dashboard-header admin-dashboard-header">
      <div>
         <p class="dashboard-kicker">Super Admin</p>
         <h1>Centers overview</h1>
         <p class="dashboard-subtitle">Monitor center activity, subscription dates, content volume, and student test performance.</p>
      </div>
   </section>

   <section class="stats-grid" aria-label="Super admin statistics">
      <div class="stat-card stat-primary">
         <span class="stat-icon"><i class="material-icons" aria-hidden="true">business</i></span>
         <span class="stat-label">Centers</span>
         <strong>{{ $totalCenters }}</strong>
         <small>{{ $activeCenters }} active</small>
      </div>

      <div class="stat-card">
         <span class="stat-icon"><i class="material-icons" aria-hidden="true">event_busy</i></span>
         <span class="stat-label">Expired</span>
         <strong>{{ $expiredCenters }}</strong>
         <small>Need renewal</small>
      </div>

      <div class="stat-card">
         <span class="stat-icon"><i class="material-icons" aria-hidden="true">notifications_active</i></span>
         <span class="stat-label">Expiring soon</span>
         <strong>{{ $expiringCenters }}</strong>
         <small>15 days or less</small>
      </div>

      <div class="stat-card">
         <span class="stat-icon"><i class="material-icons" aria-hidden="true">assignment</i></span>
         <span class="stat-label">Assigned tests</span>
         <strong>{{ $centers->sum('assigned') }}</strong>
         <small>{{ $centers->sum('finished') }} completed</small>
      </div>

      <div class="stat-card">
         <span class="stat-icon"><i class="material-icons" aria-hidden="true">calendar_month</i></span>
         <span class="stat-label">Last 30 days</span>
         <strong>{{ $lastMonthStudentTests }}</strong>
         <small>Student tests assigned</small>
      </div>
   </section>

   <section class="dashboard-panel">
      <div class="panel-heading">
         <div>
            <h2>Centers</h2>
            <p>Renew subscriptions and compare usage by center</p>
         </div>
      </div>

      <div id="admin-dashboard-alert" class="alert admin-alert" role="alert"></div>

      <div class="table-responsive">
         <table class="table table-hover admin-centers-table">
            <thead>
               <tr>
                  <th>Center</th>
                  <th>Expiration</th>
                  <th>Content</th>
                  <th>Tests</th>
                  <th>Average</th>
                  <th>Options</th>
                  <th>Password</th>
                  <th>Renew</th>
               </tr>
            </thead>
            <tbody>
               @forelse($centers as $center)
                  <tr data-center-id="{{ $center['id'] }}">
                     <td>
                        <div class="center-cell">
                           <span class="recent-avatar">{{ strtoupper(substr($center['name'] ?: $center['username'] ?: 'C', 0, 1)) }}</span>
                           <div class="recent-main">
                              <strong>{{ $center['name'] ?: 'Unnamed center' }}</strong>
                              <small>{{ $center['email'] ?: $center['username'] ?: 'No contact' }}</small>
                           </div>
                        </div>
                     </td>
                     <td>
                        <div class="expiration-cell">
                           <strong class="js-expire-date">{{ $center['expire_date'] ?: 'No date' }}</strong>
                           <span class="status-badge js-expire-status {{ $center['expiration_class'] }}">{{ $center['expiration_label'] }}</span>
                           <small class="js-days-left">
                              @if(is_null($center['days_left']))
                                 No expiration date
                              @elseif($center['days_left'] < 0)
                                 {{ abs($center['days_left']) }} days late
                              @else
                                 {{ $center['days_left'] }} days left
                              @endif
                           </small>
                        </div>
                     </td>
                     <td>
                        <strong>{{ $center['questions'] }}</strong>
                        <small class="admin-muted">{{ $center['tests'] }} tests, {{ $center['categories'] }} categories</small>
                     </td>
                     <td>
                        <strong>{{ $center['assigned'] }}</strong>
                        <small class="admin-muted">{{ $center['last_month_assigned'] }} last 30 days</small>
                        <small class="admin-muted">{{ $center['finished'] }} finished, {{ $center['in_progress'] }} active</small>
                     </td>
                     <td>
                        <div class="performance-mini">
                           <strong>{{ $center['average_score'] }}%</strong>
                           <span class="performance-meter" aria-hidden="true"><span style="width: {{ $center['average_score'] }}%"></span></span>
                        </div>
                     </td>
                     <td>
                        <span class="status-badge {{ $center['export_test'] ? 'badge-finished' : 'badge-waiting' }}">
                           {{ $center['export_test'] ? 'Export enabled' : 'No export' }}
                        </span>
                     </td>
                     <td>
                        <div class="password-actions">
                           <input type="password" class="form-control form-control-sm js-center-password" placeholder="New password" minlength="6">
                           <button type="button" class="btn btn-sm btn-warning js-update-password" data-url="{{ route('admin.centers.password', $center['id']) }}">
                              <i class="material-icons" aria-hidden="true">key</i>
                              <span>Change</span>
                           </button>
                        </div>
                     </td>
                     <td>
                        <div class="renew-actions">
                           <button type="button" class="btn btn-sm btn-primary js-renew-center" data-url="{{ route('admin.centers.renew', $center['id']) }}" data-months="1">+1m</button>
                           <button type="button" class="btn btn-sm btn-primary js-renew-center" data-url="{{ route('admin.centers.renew', $center['id']) }}" data-months="3">+3m</button>
                           <button type="button" class="btn btn-sm btn-success js-renew-center" data-url="{{ route('admin.centers.renew', $center['id']) }}" data-months="12">+1y</button>
                           <input type="date" class="form-control form-control-sm js-renew-date" data-url="{{ route('admin.centers.renew', $center['id']) }}" value="{{ $center['expire_date'] }}">
                        </div>
                     </td>
                  </tr>
               @empty
                  <tr>
                     <td colspan="8">
                        <div class="empty-state">
                           <i class="material-icons" aria-hidden="true">business</i>
                           <strong>No centers found</strong>
                           <span>Create normal users to manage centers here.</span>
                        </div>
                     </td>
                  </tr>
               @endforelse
            </tbody>
         </table>
      </div>
   </section>
</div>
@endsection
