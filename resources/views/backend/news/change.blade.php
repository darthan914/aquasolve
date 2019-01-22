@extends('backend.layout.master')

@section('title')
<title>
	{{ $name->title }} | Change {{ $News->name }} | News
</title>
@endsection

@section('headscript')
<script src="{{asset('backend/vendors/ckeditor/ckeditor.js')}}">
</script>
<script src="{{asset('backend/vendors/ckfinder/ckfinder.js')}}">
</script>
@endsection

@section('content')
<div class="row">
	<div class="col-md-12 col-sm-12 col-xs-12">
		<div class="x_panel">
			<div class="x_title">
				<h2>
					Change {{ $News->name }} News
					<small>
					</small>
				</h2>
				<ul class="nav panel_toolbox">
					<a class="btn btn-primary btn-sm" href="{{ route('backend.news') }}">
						Back
					</a>
				</ul>
				<div class="clearfix">
				</div>
			</div>
			<div class="x_content">
				<form action="{{ route('backend.news.store.changeStore', ['id'=>$News->id]) }}" class="form-horizontal form-label-left" enctype="multipart/form-data" method="POST" novalidate="">
					{{ csrf_field() }}
					<div class="item form-group {{ $errors->has('name') ? 'has-error' : ''}}">
						<label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">
							Name
							<span class="required">
								*
							</span>
						</label>
						<div class="col-md-6 col-sm-6 col-xs-12">
							<input class="form-control col-md-7 col-xs-12" id="name" name="name" placeholder="Name" required="required" type="text" value="{{ old('name',$News->name) }}">
								@if($errors->has('name'))
								<code>
									<span style="color:red; font-size:12px;">
										{{ $errors->first('name')}}
									</span>
								</code>
								@endif
							</input>
						</div>
					</div>
					<div class="item form-group {{ $errors->has('descript') ? 'has-error' : ''}}">
						<label class="control-label col-md-3 col-sm-3 col-xs-12" for="descript">
							Description
							<span class="required">
								*
							</span>
						</label>
						<div class="col-md-6 col-sm-6 col-xs-12">
							<textarea id="descript" name="descript" required="required">
								{{ old('descript',$News->descript) }}
							</textarea>
							@if($errors->has('descript'))
							<code>
								<span style="color:red; font-size:12px;">
									{{ $errors->first('descript')}}
								</span>
							</code>
							@endif
						</div>
					</div>
					<div class="item form-group {{ $errors->has('picture') ? 'has-error' : ''}}">
						<label class="control-label col-md-3 col-sm-3 col-xs-12">
							Picture
							<span class="required">
								*
							</span>
						</label>
						<div class="col-md-6 col-sm-6 col-xs-12">
							<input accept=".jpg,.png" class="form-control" id="picture" name="picture" type="file">
								@if($errors->has('picture'))
								<code>
									<span style="color:red; font-size:12px;">
										{{ $errors->first('picture')}}
									</span>
								</code>
								@endif
								<a href="{{ asset('amadeo/images/'.$News->picture) }}" target="_blank">
									<img src="{{ asset('amadeo/images/'.$News->picture) }}" style="height: 120px;">
									</img>
								</a>
							</input>
						</div>
					</div>
					<div class="ln_solid">
					</div>

					<div class="item form-group {{ $errors->has('meta_title') ? 'has-error' : ''}}">
						<label class="control-label col-md-3 col-sm-3 col-xs-12" for="meta_title">
							Meta Title
						</label>
						<div class="col-md-6 col-sm-6 col-xs-12">
							<input class="form-control col-md-7 col-xs-12" id="meta_title" name="meta_title" placeholder="Meta Title" required="required" type="text" value="{{ old('meta_title',$News->meta_title) }}">
								@if($errors->has('meta_title'))
								<code>
									<span style="color:red; font-size:12px;">
										{{ $errors->first('meta_title')}}
									</span>
								</code>
								@endif
							</input>
						</div>
					</div>
					<div class="item form-group {{ $errors->has('meta_url') ? 'has-error' : ''}}">
						<label class="control-label col-md-3 col-sm-3 col-xs-12" for="meta_url">
							Meta URL
						</label>
						<div class="col-md-6 col-sm-6 col-xs-12">
							<input class="form-control col-md-7 col-xs-12" id="meta_url" name="meta_url" placeholder="Meta URL" required="required" type="text" value="{{ old('meta_url',$News->meta_url) }}">
								@if($errors->has('meta_url'))
								<code>
									<span style="color:red; font-size:12px;">
										{{ $errors->first('meta_url')}}
									</span>
								</code>
								@endif
							</input>
						</div>
					</div>
					<div class="item form-group {{ $errors->has('meta_keywords') ? 'has-error' : ''}}">
						<label class="control-label col-md-3 col-sm-3 col-xs-12" for="meta_keywords">
							Meta Keyword

						</label>
						<div class="col-md-6 col-sm-6 col-xs-12">
							<input class="form-control col-md-7 col-xs-12" id="meta_keywords" name="meta_keywords" placeholder="Meta Keyword" required="required" type="text" value="{{ old('meta_keywords',$News->meta_keywords) }}">
								@if($errors->has('meta_keywords'))
								<code>
									<span style="color:red; font-size:12px;">
										{{ $errors->first('meta_keywords')}}
									</span>
								</code>
								@endif
							</input>
						</div>
					</div>
					<div class="item form-group {{ $errors->has('meta_description') ? 'has-error' : ''}}">
						<label class="control-label col-md-3 col-sm-3 col-xs-12" for="meta_description">
							Meta Description

						</label>
						<div class="col-md-6 col-sm-6 col-xs-12">
							<input class="form-control col-md-7 col-xs-12" id="meta_description" name="meta_description" placeholder="Meta Description" required="required" type="text" value="{{ old('meta_description',$News->meta_description) }}">
								@if($errors->has('meta_description'))
								<code>
									<span style="color:red; font-size:12px;">
										{{ $errors->first('meta_description')}}
									</span>
								</code>
								@endif
							</input>
						</div>
					</div>
					<div class="item form-group {{ $errors->has('meta_image') ? 'has-error' : ''}}">
						<label class="control-label col-md-3 col-sm-3 col-xs-12">
							Meta Image
						</label>
						<div class="col-md-6 col-sm-6 col-xs-12">
							<input accept=".jpg,.png" class="form-control" id="meta_image" name="meta_image" type="file">
								@if($errors->has('meta_image'))
								<code>
									<span style="color:red; font-size:12px;">
										{{ $errors->first('meta_image')}}
									</span>
								</code>
								@endif
							</input>
							<label for="remove_meta_image">Remove Image:</label>
							<input type="checkbox" name="remove_meta_image" id="remove_meta_image">
						</div>
					</div>
					<div class="form-group">
						<div class="col-md-6 col-md-offset-3">
							<a class="btn btn-primary" href="{{ route('backend.product') }}">
								Cancel
							</a>
							<button class="btn btn-success" id="send" type="submit">
								Submit
							</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
@endsection



@section('script')
<script language="javascript">
	CKEDITOR.replace('descript', {
	toolbar: [
	  { name: 'document', groups: [ 'mode', 'document', 'doctools' ], items: [ 'Source', '-', 'Save', 'NewPage', 'Preview', 'Print', '-', 'Templates' ] },
	  { name: 'clipboard', groups: [ 'clipboard', 'undo' ], items: [ 'Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo' ] },
	  { name: 'editing', groups: [ 'find', 'selection' ] },
	  { name: 'forms', items: [ 'Form', 'Checkbox', 'Radio', 'TextField', 'Textarea', 'Select', 'Button', 'ImageButton', 'HiddenField' ] },
	  { name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ], items: [ 'Bold', 'Italic', 'Underline', 'Strike', 'Subscript', 'Superscript', '-', 'RemoveFormat' ] },
	  { name: 'paragraph', groups: [ 'list', 'indent', 'blocks', 'align', 'bidi' ], items: [ 'NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote', 'CreateDiv', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock', '-', 'BidiLtr', 'BidiRtl', 'Language' ] },
	  { name: 'links', items: [ 'Link', 'Unlink', 'Anchor' ] },
	  { name: 'styles', items: [ 'Styles', 'Format', 'Font', 'FontSize' ] },
	  { name: 'colors', items: [ 'TextColor', 'BGColor' ] },
	  { name: 'tools', items: [ 'Maximize', 'ShowBlocks' ] },
	  { name: 'others', items: [ '-' ] },
	  { name: 'about', items: [ 'About' ] }
	]
  });
</script>
@endsection
