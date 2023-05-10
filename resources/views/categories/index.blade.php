@extends('layouts.app')

@section('content')
<div class="container">
   	<div class="row justify-content-center">

		@push('scripts')
			<script src="{{ asset('js/categories.js') }}"></script>
		@endpush	

		<div name="header">
			<h2 class="font-semibold text-xl text-gray-800 leading-tight">
				{{ __('Categories Management') }}
			</h2>
		</div>

		<div class="table-responsive">
			<div class="table-wrapper">
				<div class="table-title">
					<div class="" style="margin-bottom: 10px">
						<div class="col-sm-12">
							<a href="#add" class="btn btn-success" data-toggle="modal"><i class="fa fa-plus"></i> <span>New Category</span></a>
						</div>
					</div>
				</div>

				<table class="table table-striped table-hover">
					<thead>
						<tr>
							<th>Name</th>
							<th style="width: 100px">Actions</th>
						</tr>
					</thead>
					<tbody>
						@foreach($categories as $category)
						<tr>
							<td>{{$category->name}}</td>
							<td>
								<a style="color: green;" href="#edit" data-target="#edit" data-id="{{$category->id}}" data-action-get="{{ route('categories.show', $category->id) }}" data-action="{{ route('categories.update', $category->id) }}" class="edit" data-toggle="modal"><i class="material-icons" data-toggle="tooltip" title="Edit">&#xE254;</i></a>
								<a style="color: red;" href="#delete" data-target="#delete" data-action="{{ route('categories.destroy', $category->id) }}"  class="delete" data-toggle="modal"><i class="material-icons" data-toggle="tooltip" title="Delete">&#xE872;</i></a>
							</td>
						</tr>
						@endforeach
					</tbody>
				</table>

				<div class="clearfix">
					<ul class="pagination">
					{{ $categories->links() }}
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
				<form action="{{route('categories.store')}}" method="post">
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
							<input type="text" class="form-control" name="name" id="name">
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
