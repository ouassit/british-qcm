
@push('scripts')
	<script src="{{ asset('js/questions.js') }}"></script>
@endpush

<x-app-layout>
	

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Categories Management') }}
        </h2>
    </x-slot>

	<div class="row">
		<div class="filter-container">
			<div class="card">
				<div class="card-header">
					Filter
				</div>
				<div class="card-body">
					<form class="form-inline" action="">
						<div class="col-lg col-sm-12">
							<label for="">&nbsp;</label>
							<select placeholder="Select test"  class="form-select mx-sm-3" id ='filter_test_id' name="filter_test_id">
								<option value="">Select test</option>
								@foreach($tests as $test)
									<option @if(app('request')->input('filter_test_id')==$test->id) selected @endif value="{{$test->id}}" >{{Str::upper($test->name)}}</option>
								@endforeach
							</select>
						</div>
						<div class="col-lg col-sm-12">
							<label for="reset">&nbsp;</label>
							<div>
								<a href="{{route('questions.index')}}" class="btn btn-warning" value="Effacer">Effacer</a>
								<input type="submit" class="btn btn-primary" value="Filtrer"/>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>

    <div class="table-responsive">
		<div class="table-wrapper">
			<div class="table-title">
				<div class="" style="margin-bottom: 10px">
					<div class="col-sm-12">
						<a href="#add" class="btn btn-success" data-toggle="modal"><i class="fa fa-plus"></i> <span>New Question</span></a>
					</div>
				</div>
			</div>

			<table class="table table-striped table-hover">
				<thead>
					<tr>
						<th>Question</th>
						<th>Question</th>
						<th>Choices</th>
						<th>Actions</th>
					</tr>
				</thead>
				<tbody>
					@foreach($questions as $question)
					<tr>
						<td>{{$question->categorie->name}}</td>
						<td>{!!$question->question!!}</td>
						<td>{{$question->choices->count()}}</td>
						<td>
							<a name='edit' style="color: green;" href="#edit" data-target="#edit" data-id="{{$question->id}}" data-action-get="{{ route('questions.show', $question->id) }}" data-action="{{ route('questions.update', $question->id) }}" class="edit" data-toggle="modal"><i class="material-icons" data-toggle="tooltip" title="Edit">&#xE254;</i></a>
							<a style="color: red;" href="#delete" data-target="#delete" data-action="{{ route('questions.destroy', $question->id) }}"  class="delete" data-toggle="modal"><i class="material-icons" data-toggle="tooltip" title="Delete">&#xE872;</i></a>
						</td>
					</tr>
					@endforeach
				</tbody>
			</table>

			<div class="clearfix">
				<ul class="pagination">
				{{ $questions->links() }}
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
			<form action="{{route('questions.store')}}" method="post">

				<input type="hidden" class="form-control" name="id" id="id" value="">

				<div id="add-error" class="alert alert-danger" style="margin: 10px; display:none">  
				</div>
				<div id="add-success" class="alert alert-success" style="margin: 10px; display:none">  
					<strong>Info!</strong> Added successfully.
				</div>
				{{method_field('post')}}
				{{csrf_field()}}
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
						<label for="categorie_id">Category</label>
						<select required class="form-control" name="categorie_id" id="categorie_id">
							@foreach($categories as $categorie)
							<option value="{{$categorie->id}}">{{$categorie->name}}</option>
							@endforeach
						</select>
						<span class="text-danger" id="categorie_id-error"></span>
					</div>
					<div class="form-group">
						<label for="question">Question</label>
						<textarea required class="form-control" name="question" id="question"></textarea>
						<span class="text-danger" id="question-error"></span>
					</div>
					<div style="margin-bottom: 10px">
						<button id="add-choice" class="btn btn-success" >Add Choice</button>
					</div>
					<table id="choices" class="table">
						<thead>
							<th>Answer</th>
							<th>Correct</th>
							<th></th>
						</thead>
						<tbody>
							
						</tbody>
					</table>

				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-primary">Save</button>
				</div>
			</form>
			</div>
		</div>
	</div>

	<table id="choice-item" class="choice-item" style="display: none">
		<tr>
			<td>
				<input class="form-control" size="10" type="text" name="answer[]" />
			</td>
			<td>
				<input size="6" required type="radio" name="correct[]" />
			</td>
			<td>
				<a name='delete-row' href="#"><i class="material-icons" data-toggle="tooltip" title="Delete">&#xE872;</i></a>
			</td>
		</tr>
	</table>


</x-app-layout>
