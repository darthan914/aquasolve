@extends('backend.layout.master')

@section('title')
	<title>{{ $name->title }} | Manage Permision</title>
@endsection

@section('headscript')
<link href="{{ asset('backend/vendors/datatables.net-bs/css/dataTables.bootstrap.min.css') }}" rel="stylesheet">
<link href="{{ asset('backend/vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css') }}" rel="stylesheet">
<link href="{{ asset('backend/vendors/pnotify/dist/pnotify.css') }}" rel="stylesheet">
<link href="{{ asset('backend/vendors/pnotify/dist/pnotify.nonblock.css') }}" rel="stylesheet">
@endsection

@section('content')
	<h1>Permission</h1>
	<div class="x_panel">
	<form class="form-horizontal form-label-left" action="{{ route('backend.user.permissionUpdate', ['id' => $index->id]) }}" method="post" enctype="multipart/form-data">

		@foreach($key as $list)
			<div class="form-group">
				<label class="control-label checkbox-inline col-md-3 col-sm-3 col-xs-12">
					<input type="checkbox" data-target="permission-{{ $list['id'] }}" class="check-all"> Grant {{ $list['name'] }}
				</label>
				<div class="col-md-9 col-sm-9 col-xs-12">
					@foreach($list['data'] as $list2)
					@if($list2['value'] == 'level-user' && !Auth::user()->can('level-user')) @continue @endif
					<label class="checkbox-inline"><input type="checkbox" name="permission[]" class="permission-{{ $list['id'] }}" value="{{ $list2['value'] }}" @if(in_array($list2['value'], old('permission', explode(', ', $index->permission)))) checked @endif>{{ $list2['name'] }}</label>
					@endforeach
					<ul class="parsley-errors-list filled">
						<li class="parsley-required">{{ $errors->first('permission') }}</li>
					</ul>
				</div>
			</div>
		@endforeach

		@can('level-user')
		<div class="form-group">
			<label for="level" class="control-label col-md-3 col-sm-3 col-xs-12">Level<span class="required">*</span>
			</label>
			<div class="col-md-9 col-sm-9 col-xs-12">
				<input type="text" id="level" name="level" class="form-control {{$errors->first('level') != '' ? 'parsley-error' : ''}}" value="{{ old('level', $index->level) }}">
				<ul class="parsley-errors-list filled">
					<li class="parsley-required">{{ $errors->first('level') }}</li>
				</ul>
			</div>
		</div>
		@endcan

		<div class="form-group">
			<label for="password" class="control-label col-md-3 col-sm-3 col-xs-12">Password User<span class="required">*</span>
			</label>
			<div class="col-md-9 col-sm-9 col-xs-12">
				<input type="password" id="password" name="password" class="form-control {{$errors->first('password') != '' ? 'parsley-error' : ''}}">
				<ul class="parsley-errors-list filled">
					<li class="parsley-required">{{ $errors->first('password') }}</li>
				</ul>
			</div>
		</div>

		<div class="ln_solid"></div>
		<div class="form-group">
			<div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
				{{ csrf_field() }}
				<a class="btn btn-primary" href="{{ route('backend.user') }}">Cancel</a>
				<button type="submit" class="btn btn-success">Submit</button>
			</div>
		</div>

	</form>
	</div>

@endsection

@section('script')
<script src="{{ asset('backend/vendors/datatables.net/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('backend/vendors/datatables.net-bs/js/dataTables.bootstrap.min.js') }}"></script>
<script src="{{ asset('backend/vendors/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('backend/vendors/datatables.net-scroller/js/datatables.scroller.min.js') }}"></script>
<script type="text/javascript">
	$('#usertabel').DataTable();

	$(function() {
		$(".check-all").click(function(){
			if ($(this).is(':checked'))
			{
				$('.' + $(this).attr('data-target')).prop('checked', true);
			}
			else
			{
				$('.' + $(this).attr('data-target')).prop('checked', false);
			}
		});
	});
</script>
@endsection
