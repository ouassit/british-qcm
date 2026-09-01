@extends('layouts.app')

@section('content')
@if($expirationNotice['show'])
   @push('scripts')
      <script>
         $(document).ready(function() {
            $('#expireModal').modal('show');

            $('[data-expire-modal-close]').on('click', function() {
               $('#expireModal').modal('hide');
            });
         });
      </script>
   @endpush
@endif

<div class="dashboard-page">
   @if($expirationNotice['show'])
      <div class="subscription-alert">
         <i class="material-icons" aria-hidden="true">warning</i>
         <div>
            {!! $expirationNotice['message'] !!}
         </div>
         <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#expireModal">Details</button>
      </div>
   @endif

   <section class="dashboard-header">
      <div>
         <p class="dashboard-kicker">Placement Test Platform</p>
         <h1>Welcome back</h1>
         <p class="dashboard-subtitle">Manage tests, questions, categories, and student results from one clear workspace.</p>
      </div>
      <a class="btn btn-primary dashboard-primary-action" href="{{ route('students_tests.index') }}">
         <i class="material-icons" aria-hidden="true">assignment</i>
         <span>View results</span>
      </a>
   </section>

   <section class="dashboard-grid">
      <a class="dashboard-tile tile-categories" href="{{ route('categories.index') }}">
         <span class="dashboard-tile-icon"><i class="material-icons" aria-hidden="true">folder</i></span>
         <span class="dashboard-tile-content">
            <strong>Categories</strong>
            <small>Organize question groups</small>
         </span>
         <i class="material-icons dashboard-tile-arrow" aria-hidden="true">arrow_forward</i>
      </a>

      <a class="dashboard-tile tile-tests" href="{{ route('quizs.index') }}">
         <span class="dashboard-tile-icon"><i class="material-icons" aria-hidden="true">quiz</i></span>
         <span class="dashboard-tile-content">
            <strong>Tests</strong>
            <small>Create and manage exams</small>
         </span>
         <i class="material-icons dashboard-tile-arrow" aria-hidden="true">arrow_forward</i>
      </a>

      <a class="dashboard-tile tile-questions" href="{{ route('questions.index') }}">
         <span class="dashboard-tile-icon"><i class="material-icons" aria-hidden="true">help_outline</i></span>
         <span class="dashboard-tile-content">
            <strong>Questions</strong>
            <small>Edit answers and ordering</small>
         </span>
         <i class="material-icons dashboard-tile-arrow" aria-hidden="true">arrow_forward</i>
      </a>

      <a class="dashboard-tile tile-students" href="{{ route('students_tests.index') }}">
         <span class="dashboard-tile-icon"><i class="material-icons" aria-hidden="true">groups</i></span>
         <span class="dashboard-tile-content">
            <strong>Students Tests</strong>
            <small>Track scores and progress</small>
         </span>
         <i class="material-icons dashboard-tile-arrow" aria-hidden="true">arrow_forward</i>
      </a>

      <a class="dashboard-tile tile-settings" href="{{ route('settings.index') }}">
         <span class="dashboard-tile-icon"><i class="material-icons" aria-hidden="true">settings</i></span>
         <span class="dashboard-tile-content">
            <strong>Settings</strong>
            <small>Adjust account options</small>
         </span>
         <i class="material-icons dashboard-tile-arrow" aria-hidden="true">arrow_forward</i>
      </a>
   </section>

   <section class="stats-grid" aria-label="Center statistics">
      <div class="stat-card stat-primary">
         <span class="stat-icon"><i class="material-icons" aria-hidden="true">assignment_ind</i></span>
         <span class="stat-label">Assigned tests</span>
         <strong>{{ $totalStudentTests }}</strong>
         <small>{{ $todayTests }} today</small>
      </div>

      <div class="stat-card">
         <span class="stat-icon"><i class="material-icons" aria-hidden="true">check_circle</i></span>
         <span class="stat-label">Completed</span>
         <strong>{{ $finishedTests }}</strong>
         <small>{{ $completionRate }}% completion rate</small>
      </div>

      <div class="stat-card">
         <span class="stat-icon"><i class="material-icons" aria-hidden="true">trending_up</i></span>
         <span class="stat-label">Average score</span>
         <strong>{{ $averageScore }}%</strong>
         <small>Finished tests only</small>
      </div>

      <div class="stat-card">
         <span class="stat-icon"><i class="material-icons" aria-hidden="true">inventory_2</i></span>
         <span class="stat-label">Content bank</span>
         <strong>{{ $totalQuestions }}</strong>
         <small>{{ $totalTests }} tests, {{ $totalCategories }} categories</small>
      </div>
   </section>

   <section class="dashboard-panels">
      <div class="dashboard-panel">
         <div class="panel-heading">
            <div>
               <h2>Test status</h2>
               <p>Current activity across your center</p>
            </div>
         </div>

         <div class="status-list">
            <div class="status-row">
               <span class="status-dot status-finished"></span>
               <span>Finished</span>
               <strong>{{ $finishedTests }}</strong>
            </div>
            <div class="status-row">
               <span class="status-dot status-progress"></span>
               <span>In progress</span>
               <strong>{{ $inProgressTests }}</strong>
            </div>
            <div class="status-row">
               <span class="status-dot status-waiting"></span>
               <span>Not started</span>
               <strong>{{ $notStartedTests }}</strong>
            </div>
         </div>

         @if(!is_null($daysLeft))
            <div class="subscription-card {{ $daysLeft < 0 ? 'is-expired' : ($daysLeft <= 15 ? 'is-warning' : '') }}">
               <span class="stat-icon"><i class="material-icons" aria-hidden="true">event_available</i></span>
               <div>
                  <span>Subscription</span>
                  @if($daysLeft < 0)
                     <strong>Expired {{ abs($daysLeft) }} days ago</strong>
                  @else
                     <strong>{{ $daysLeft }} days left</strong>
                  @endif
               </div>
            </div>
         @endif
      </div>

      <div class="dashboard-panel panel-wide">
         <div class="panel-heading">
            <div>
               <h2>Performance by test</h2>
               <p>Compare usage, completion, and average results</p>
            </div>
            <a href="{{ route('quizs.index') }}" class="panel-link">Manage tests</a>
         </div>

         <div class="performance-list">
            @forelse($testsPerformance as $test)
               <div class="performance-row">
                  <div class="performance-name">
                     <strong>{{ $test['name'] }}</strong>
                     <small>{{ $test['questions'] }} questions, {{ $test['assigned'] }} assigned</small>
                  </div>
                  <div class="performance-meter" aria-hidden="true">
                     <span style="width: {{ $test['average'] }}%"></span>
                  </div>
                  <div class="performance-numbers">
                     <strong>{{ $test['average'] }}%</strong>
                     <small>{{ $test['finished'] }} finished</small>
                  </div>
               </div>
            @empty
               <div class="empty-state">
                  <i class="material-icons" aria-hidden="true">quiz</i>
                  <strong>No tests yet</strong>
                  <span>Create a test to start tracking center performance.</span>
               </div>
            @endforelse
         </div>
      </div>
   </section>

   <section class="dashboard-panel">
      <div class="panel-heading">
         <div>
            <h2>Recent activity</h2>
            <p>Latest student tests created or updated in this center</p>
         </div>
         <a href="{{ route('students_tests.index') }}" class="panel-link">Open students tests</a>
      </div>

      <div class="recent-list">
         @forelse($recentStudentTests as $studentTest)
            <div class="recent-row">
               <span class="recent-avatar">{{ strtoupper(substr(trim($studentTest->firstname . ' ' . $studentTest->lastname) ?: 'S', 0, 1)) }}</span>
               <div class="recent-main">
                  <strong>{{ trim($studentTest->firstname . ' ' . $studentTest->lastname) ?: 'Unnamed student' }}</strong>
                  <small>{{ optional($studentTest->test)->name }} &middot; {{ $studentTest->access_code ?: 'No code' }}</small>
               </div>
               <span class="status-badge {{ $studentTest->expired ? 'badge-finished' : ($studentTest->consumed_time > 0 ? 'badge-progress' : 'badge-waiting') }}">
                  @if($studentTest->expired)
                     Finished
                  @elseif($studentTest->consumed_time > 0)
                     In progress
                  @else
                     Not started
                  @endif
               </span>
               <small class="recent-date">
                  {{ $studentTest->date ? \Carbon\Carbon::parse($studentTest->date)->format('d/m/Y H:i') : '' }}
               </small>
            </div>
         @empty
            <div class="empty-state">
               <i class="material-icons" aria-hidden="true">groups</i>
               <strong>No student activity yet</strong>
               <span>Create student tests to see recent center activity here.</span>
            </div>
         @endforelse
      </div>
   </section>
</div>

@if($expirationNotice['show'])
   <div class="modal fade" id="expireModal" tabindex="-1" role="dialog" aria-labelledby="expireModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
         <div class="modal-content">
            <div class="modal-header">
               <h4 class="modal-title" id="expireModalLabel">Subscription renewal</h4>
               <button type="button" class="close" data-dismiss="modal" data-bs-dismiss="modal" data-expire-modal-close aria-label="Close">
                  <span aria-hidden="true">&times;</span>
               </button>
            </div>
            <div class="modal-body">
               <div class="renewal-modal-icon">
                  <i class="material-icons" aria-hidden="true">warning</i>
               </div>
               <div class="renewal-message">
                  {!! $expirationNotice['message'] !!}
               </div>
            </div>
            <div class="modal-footer">
               <button type="button" class="btn btn-primary" data-dismiss="modal" data-bs-dismiss="modal" data-expire-modal-close>OK</button>
            </div>
         </div>
      </div>
   </div>
@endif
@endsection
