@extends('layouts.app')

@section('content')
<div class="container">
   	<div class="row justify-content-center">

		@push('scripts')
			<script src="{{ asset('js/tests.js') }}"></script>
		@endpush

		<div name="header">
			<h2 class="font-semibold text-xl text-gray-800 leading-tight">
				{{ __('Tests Management') }}
			</h2>
		</div>

		<div class="table-responsive">
			<div class="table-wrapper">
				<div class="table-title">
					<div class="" style="margin-bottom: 10px">
						<div class="col-sm-12">
							<a href="#add" class="btn btn-success" data-toggle="modal"><i class="fa fa-plus"></i> <span>New Test</span></a>
						</div>
					</div>
				</div>

				<table class="table table-striped table-hover">
					<thead>
						<tr>
							<th>Name</th>
							<th>Duration</th>
							<th>Actions</th>
						</tr>
					</thead>
					<tbody>
						@foreach($tests as $test)
						<tr>
							<td>{{$test->name}}</td>
							<td>{{$test->duration}}</td>
							<td>
								<a style="color: green;" href="#edit" data-target="#edit" data-id="{{$test->id}}" data-action-get="{{ route('quizs.show', $test->id) }}" data-action="{{ route('quizs.update', $test->id) }}" class="edit" data-toggle="modal"><i class="material-icons" data-toggle="tooltip" title="Edit">&#xE254;</i></a>
								<a style="color: red;" href="#delete" data-target="#delete" data-action="{{ route('quizs.destroy', $test->id) }}"  class="delete" data-toggle="modal"><i class="material-icons" data-toggle="tooltip" title="Delete">&#xE872;</i></a>
							</td>
						</tr>
						@endforeach
					</tbody>
				</table>

				<div class="clearfix">
					<ul class="pagination">
					{{ $tests->links() }}
					</ul>
				</div>

			</div>
		</div>

		<!-- Modal Delete-->
		<div class="modal modal-danger fade" id="delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h4 class="modal-title text-center" id="myModalLabel">Confirmation</h4>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					</div>
					<form action="" method="post">
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
		<div class="modal fade" id="add" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title" id="myModalLabel">Add</h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				</div>
				<form action="{{route('quizs.store')}}" method="post">
					<div id="add-error" class="alert alert-danger" style="margin: 10px; display:none">  
					</div>
					<div id="add-success" class="alert alert-success" style="margin: 10px; display:none">  
						<strong>Info!</strong> Added successfully.
					</div>
					{{method_field('post')}}
					{{csrf_field()}}
					<div class="modal-body">
						<div class="form-group">
							<label for="name">Nom</label>
							<input required type="text" class="form-control" name="name" id="name">
							<span class="text-danger" id="name-error"></span>
						</div>
					</div>
					<div class="modal-body">
						<div class="form-group">
							<label for="duration">Duration</label>
							<input required type="number" class="form-control" name="duration" id="duration">
							<span class="text-danger" id="name-error"></span>
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
		<div class="modal fade" id="edit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title" id="myModalLabel">Modification</h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				</div>
				<form action="" method="post">
					<div id="edit-error" class="alert alert-danger" style="margin: 10px; display:none">  
					</div>
					<div id="edit-success" class="alert alert-success" style="margin: 10px; display:none">  
						<strong>Info!</strong> Modification saved successfully.
					</div>
					{{method_field('post')}}
					{{csrf_field()}}
					<div class="modal-body">
						
						<input type="hidden" class="form-control" name="id" id="id">

						<div class="form-group">
							<label for="name">Name</label>
							<input type="text" class="form-control" name="name" id="name">
							<span class="text-danger" id="name-error"></span>
						</div>

						<div class="form-group">
							<label for="duration">Duration</label>
							<input required type="number" class="form-control" name="duration" id="duration">
							<span class="text-danger" id="name-error"></span>
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

	</div>
</div>
@endsection

