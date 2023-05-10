@extends('layouts.app')

@section('content')
<div class="container">
   	<div class="row justify-content-center">
	

    <div name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Settings') }}
        </h2>
    </div>

	<div class="col-md-12">
        <div class="card shadow-sm">
            <form method="post" action="{{route('settings.store')}}">
				@csrf
                <div class="card-body">

					<div class="alert alert-success" role="alert" style="display: none;">
						<div class="alert-body">
							Saved.
						</div>
					</div>

					<div class="w-md-75">
						<div class="form-check mb-3">
							<input @if(auth()->user()->auto_step==1) checked @endif class="form-check-input" id="auto_step" type="checkbox" name="auto_step">
							<label class="form-check-label" for="auto_step">
								Auto step
							</label>
						</div>
						<div class="form-check mb-3">
							<input @if(auth()->user()->show_result==1) checked @endif class="form-check-input" id="show_result" type="checkbox" name="show_result">
							<label class="form-check-label" for="show_result">
								Show result in final step
							</label>
						</div>

						<button class="btn btn-primary">Save</button>
					</div>
				</div>
            </form>
        </div>
    </div>

</div>
</div>
@endsection
