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
            <form method="post" action="{{route('settings.store')}}" enctype="multipart/form-data">
				@csrf
                <div class="card-body">

					<div class="alert alert-success" role="alert" style="display: none;">
						<div class="alert-body">
							Saved.
						</div>
					</div>

					<div class="w-md-75">
						<div class="mb-4">
							<label class="form-label" for="placement_link">Placement test link</label>
							<div class="input-group" style="max-width: 640px;">
								<input id="placement_link" type="text" class="form-control" value="{{ url('/test/'.$user->id) }}" readonly>
								<a class="btn btn-outline-primary" href="{{ url('/test/'.$user->id) }}" target="_blank">Open</a>
							</div>
							<small class="text-muted">Share this link with students for in-place or distance placement tests.</small>
						</div>

						<div class="mb-4">
							<label class="form-label" for="logo">Center logo</label>
							<div class="d-flex flex-wrap align-items-center gap-3">
								<img src="{{ $user->logo_url }}?v={{ time() }}" alt="Center logo" style="max-width: 180px; max-height: 90px; object-fit: contain; border: 1px solid #dbe5f1; border-radius: 8px; padding: 10px; background: #fff;">
								<div style="min-width: 260px; max-width: 420px;">
									<input class="form-control @error('logo') is-invalid @enderror" id="logo" type="file" name="logo" accept="image/png">
									<small class="text-muted">PNG only. If no logo is uploaded, the default logo is used.</small>
									@error('logo')
										<span class="invalid-feedback d-block" role="alert">
											<strong>{{ $message }}</strong>
										</span>
									@enderror
								</div>
							</div>
						</div>

						<div class="form-check mb-3">
							<input @if(auth()->user()->auto_step==1) checked @endif class="form-check-input" id="auto_step" type="checkbox" name="auto_step">
							<label class="form-check-label" for="auto_step">
								Auto step
							</label>
						</div>
						<div class="form-check mb-3">
							<input @if(auth()->user()->show_result==1) checked @endif class="form-check-input" id="show_result" type="checkbox" name="show_result">
							<label class="form-check-label" for="show_result">
								Show result once finished
							</label>
						</div>
						<div class="form-check mb-3">
							<input @if(auth()->user()->print_category==1) checked @endif class="form-check-input" id="print_category" type="checkbox" name="print_category">
							<label class="form-check-label" for="print_category">
								Print categories
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
