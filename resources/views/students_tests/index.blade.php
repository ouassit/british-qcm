@extends('layouts.app')

@section('content')
<div class="container">
   	<div class="row justify-content-center">

	@push('scripts')
		<script src="{{ asset('js/students_tests.js') }}"></script>
	@endpush

    <div name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Students Tests Management') }}
        </h2>
    </div>

	<div class="row">
		<div class="filter-container">
			<div class="card">
				<div class="card-header">
					Filter
				</div>
				<div class="card-body">
					<form class="form-inline" action="">
						<div class="form-group mx-sm-3 mb-2">
							<label for="filter_fullname" class="sr-only">Name : </label>
							<input class="form-control" type="text" name="filter_fullname" id="filter_fullname" />
						</div>
						<a style="margin-right: 10px" href="{{route('students_tests.index')}}" class="btn btn-warning  mb-2" value="Effacer">Effacer</a>
						<input type="submit" class="btn btn-primary mb-2" value="Filtrer"/>
					</form>
				</div>
			</div>
		</div>
	</div>

    <div class="table-responsive">
		<div class="table-wrapper">
			<div class="table-title">
				<div class="btn-group" style="margin-bottom: 10px">
						<a href="#add" class="btn btn-success" data-toggle="modal"><i class="fa fa-plus"></i> <span>New Student Test</span></a>
						<a href="#addmultiple" class="btn btn-primary" data-toggle="modal"><i class="fa fa-plus"></i> <span>Multiple Students Tests</span></a>
				</div>
			</div>

			<table class="table table-striped table-hover">
				<thead>
					<tr>
						<th>Code</th>
						<th>Test</th>
						<th>Full Name</th>
						<th style="width: 140px">Birthday</th>
						<th>Email</th>
						<th>Phone</th>
						<th>Date</th>
						<th>Status</th>
						<th>Result</th>
						<th>Actions</th>
					</tr>
				</thead>
				<tbody>
					@foreach($students_tests as $student_test)
					<tr>
						<td>{{$student_test->access_code}}</td>
						<td>{!!$student_test->test->name!!}</td>
						<td>{{$student_test->firstname}} {{$student_test->lastname}}</td>
						<td>{{$student_test->birthday}}</td>
						<td>{{$student_test->email}}</td>
						<td>{{$student_test->phone}}</td>
						<td>{{$student_test->date}}</td>
						<td>
							@if ($student_test->expired)
								<span style="font-weight: bold; color : blue">FINISHED</span>
							@elseif($student_test->consumed_time > 0)
								<span style="font-weight: bold; color : orange">IN PROGRESS ...</span>		
							@else
								<span style="font-weight: bold; color : green">NOT STARTED</span>
							@endif
						</td>
						<td>
							@if($student_test->access_code!='')
							{{$student_test->result}} / {{$student_test->test->total_questions}}
							@else
							{{$student_test->tmp_result}}
							@endif
						</td>
						<td>
							<a target="_blank" style="color: darkmagenta;" href="{{ route('students_tests.print', ['student_test_id'=> $student_test->id, 'correction' => 0]) }}"><i class="material-icons local_print_shop" data-toggle="tooltip" title="Print Result">&#xe555;</i></a>
							<a target="_blank" style="color: blue;" href="{{ route('students_tests.print', ['student_test_id'=> $student_test->id, 'correction' => 1]) }}"><i class="material-icons local_print_shop" data-toggle="tooltip" title="Print Answers">&#xe555;</i></a>

							<a name='edit' style="color: green;" href="#edit" data-target="#edit" data-id="{{$student_test->id}}" data-action="{{ route('students_tests.update', $student_test->id) }}" data-action-get="{{ route('students_tests.show', $student_test->id) }}" class="edit" data-toggle="modal"><i class="material-icons" data-toggle="tooltip" title="Edit">&#xE254;</i></a>
							<a style="color: red;" href="#delete" data-target="#delete" data-action="{{ route('students_tests.destroy', $student_test->id) }}"  class="delete" data-toggle="modal"><i class="material-icons" data-toggle="tooltip" title="Delete">&#xE872;</i></a>
						</td>
					</tr>
					@endforeach
				</tbody>
			</table>

			<div class="clearfix">
				<ul class="pagination">
				{{ $students_tests->links() }}
				</ul>
			</div>

		</div>
	</div>

	<!-- Modal Delete-->
	<div class="modal modal-danger fade" id="delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabelDelete">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title text-center" id="myModalLabel">Confirmation</h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				</div>
				<form action="" method="delete">
					<div id="delete-error" class="alert alert-danger" style="margin: 10px; display:none">  
						<strong>Erreur!</strong> Error when deleting.
					</div>
					<div id="delete-success" class="alert alert-success" style="margin: 10px; display:none">  
						<strong>Info!</strong> Deleted successfully!.
					</div>

					{{method_field('delete')}}
					{{csrf_field()}}

					<div class="modal-body">
						<p class="">
							Do you want continue deleting ?
						</p>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-success" data-dismiss="modal">Cancel</button>
						<button type="submit" class="btn btn-warning">Delete</button>
					</div>
				</form>
			</div>
		</div>
	</div>

	<!-- Modal Add-->
	<div class="modal fade" id="add" tabindex="-1" role="dialog" aria-labelledby="myModalLabelAdd">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="myModalLabel">Add</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			</div>
			<form action="{{route('students_tests.store')}}" method="post">

				{{csrf_field()}}

				<div id="add-error" class="alert alert-danger" style="margin: 10px; display:none">  
				</div>
				<div id="add-success" class="alert alert-success" style="margin: 10px; display:none">  
					<strong>Info!</strong> Added successfully.
				</div>

				<div class="modal-body">
					<div class="form-group">
						<label for="test_id">Test</label>
						<select required class="form-control" name="test_id" id="test_id">
							@foreach($tests as $test)
							<option value="{{$test->id}}">{{$test->name}}</option>
							@endforeach
						</select>
						<span class="text-danger" id="test_id-error"></span>
					</div>
					<div class="form-group">
						<label for="firstname">First name</label>
						<input type="text" required class="form-control" name="firstname" id="firstname" />
						<span class="text-danger" id="firstname-error"></span>
					</div>
					<div class="form-group">
						<label for="lastname">Last name</label>
						<input type="text" required class="form-control" name="lastname" id="lastname" />
						<span class="text-danger" id="lastname-error"></span>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-primary">Save</button>
				</div>
			</form>
			</div>
		</div>
	</div>

	<!-- Modal Edit-->
	<div class="modal fade" id="edit" tabindex="-1" role="dialog" aria-labelledby="myModalLabelEdit">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="myModalLabel">Edit</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			</div>
			<form action="" method="put">

				{{csrf_field()}}

				<input type="hidden" class="form-control" name="id" id="id" value="">

				<div id="edit-error" class="alert alert-danger" style="margin: 10px; display:none">  
				</div>
				<div id="edit-success" class="alert alert-success" style="margin: 10px; display:none">  
					<strong>Info!</strong> Edited successfully.
				</div>

				<div class="modal-body">
					<div class="form-group">
						<label for="test_id">Test</label>
						<select required class="form-control" name="test_id" id="test_id">
							@foreach($tests as $test)
							<option value="{{$test->id}}">{{$test->name}}</option>
							@endforeach
						</select>
						<span class="text-danger" id="test_id-error"></span>
					</div>
					<div class="form-group">
						<label for="firstname">First name</label>
						<input type="text" required class="form-control" name="firstname" id="firstname" />
						<span class="text-danger" id="firstname-error"></span>
					</div>
					<div class="form-group">
						<label for="lastname">Last name</label>
						<input type="text" required class="form-control" name="lastname" id="lastname" />
						<span class="text-danger" id="lastname-error"></span>
					</div>
					<div class="form-group">
						<label for="consumed_time">Consumed Time</label>
						<input type="number" required class="form-control" name="consumed_time" id="consumed_time" />
						<span class="text-danger" id="consumed_time-error"></span>
					</div>
					<div class="form-check mb-3">
						<input class="form-check-input" id="expired" type="checkbox" name="expired">
						<label class="form-check-label" for="expired">
							Expired
						</label>
						<span class="text-danger" id="expired-error"></span>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-primary">Save</button>
				</div>
			</form>
			</div>
		</div>
	</div>

	<!-- Modal Add Multiple-->
	<div class="modal fade" id="addmultiple" tabindex="-1" role="dialog" aria-labelledby="myModalLabelAdd">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="myModalLabel">Add Multiple</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			</div>
			<form action="{{route('students_tests.storemultiple')}}" method="post">

				{{csrf_field()}}

				<div id="addmultiple-error" class="alert alert-danger" style="margin: 10px; display:none">  
				</div>
				<div id="addmultiple-success" class="alert alert-success" style="margin: 10px; display:none">  
					<strong>Info!</strong> Added successfully.
				</div>

				<div class="modal-body">
					<div class="form-group">
						<label for="test_id">Test</label>
						<select required class="form-control" name="test_id" id="test_id">
							@foreach($tests as $test)
							<option value="{{$test->id}}">{{$test->name}}</option>
							@endforeach
						</select>
						<span class="text-danger" id="test_id-error"></span>
					</div>
					<div class="form-group">
						<label for="count">Number of tests</label>
						<input type="number" required class="form-control" name="count" id="count" />
						<span class="text-danger" id="count-error"></span>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-primary">Create</button>
				</div>
			</form>
			</div>
		</div>
	</div>


	</div>
</div>
@endsection
