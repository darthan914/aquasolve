@extends('backend.layout.master')

@section('title')
  <title>{{ $name->title }} | Add | Careers</title>
@endsection

@section('headscript')
<script src="{{asset('backend/vendors/ckeditor/ckeditor.js')}}"></script>
<script src="{{asset('backend/vendors/ckfinder/ckfinder.js')}}"></script>
@endsection

@section('content')
<div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_title">
        <h2>Add Careers<small></small></h2>
        <ul class="nav panel_toolbox">
          <a href="{{ route('backend.careers') }}" class="btn btn-primary btn-sm">Back</a>
        </ul>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
        <form action="{{ route('backend.careers.add.store') }}" method="POST" class="form-horizontal form-label-left" enctype="multipart/form-data" novalidate>
          {{ csrf_field() }}

          <div class="item form-group {{ $errors->has('name') ? 'has-error' : ''}}">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Job Title <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input id="name" class="form-control col-md-7 col-xs-12" name="name" placeholder="Name" required="required" type="text" value="{{ old('name') }}">
              @if($errors->has('name'))
                <code><span style="color:red; font-size:12px;">{{ $errors->first('name')}}</span></code>
              @endif
            </div>
          </div>

          <div class="item form-group {{ $errors->has('job_type') ? 'has-error' : ''}}">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="job_type">Department <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input id="job_type" class="form-control col-md-7 col-xs-12" name="job_type" placeholder="Job Type" required="required" type="text" value="{{ old('job_type') }}">
              @if($errors->has('job_type'))
                <code><span style="color:red; font-size:12px;">{{ $errors->first('job_type')}}</span></code>
              @endif
            </div>
          </div>

          <div class="item form-group {{ $errors->has('location') ? 'has-error' : ''}}">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="location">Location <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input id="location" class="form-control col-md-7 col-xs-12" name="location" placeholder="Location" required="required" type="text" value="{{ old('location') }}">
              @if($errors->has('location'))
                <code><span style="color:red; font-size:12px;">{{ $errors->first('location')}}</span></code>
              @endif
            </div>
          </div>

          <div class="item form-group {{ $errors->has('contract') ? 'has-error' : ''}}">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="contract">Contract <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input id="contract" class="form-control col-md-7 col-xs-12" name="contract" placeholder="Contract" required="required" type="text" value="{{ old('contract') }}">
              @if($errors->has('contract'))
                <code><span style="color:red; font-size:12px;">{{ $errors->first('contract')}}</span></code>
              @endif
            </div>
          </div>

          <div class="item form-group {{ $errors->has('vacancy') ? 'has-error' : ''}}">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="vacancy">Vacancy <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input id="vacancy" class="form-control col-md-7 col-xs-12" name="vacancy" placeholder="Vacancy" required="required" type="text" value="{{ old('vacancy') }}">
              @if($errors->has('vacancy'))
                <code><span style="color:red; font-size:12px;">{{ $errors->first('vacancy')}}</span></code>
              @endif
            </div>
          </div>

          <div class="ln_solid"></div>

          <div class="item form-group {{ $errors->has('job_description') ? 'has-error' : ''}}">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="textarea">Job Description <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <textarea id="job_description" required="required" name="job_description">{{ old('job_description') }}</textarea>
              @if($errors->has('job_description'))
                <code><span style="color:red; font-size:12px;">{{ $errors->first('job_description')}}</span></code>
              @endif
            </div>
          </div>

          <div class="item form-group {{ $errors->has('responsibilities') ? 'has-error' : ''}}">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="textarea">Responsibilities <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <textarea id="responsibilities" required="required" name="responsibilities">{{ old('responsibilities') }}</textarea>
              @if($errors->has('responsibilities'))
                <code><span style="color:red; font-size:12px;">{{ $errors->first('responsibilities')}}</span></code>
              @endif
            </div>
          </div>

          <div class="item form-group {{ $errors->has('qualifications') ? 'has-error' : ''}}">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="textarea">Qualifications <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <textarea id="qualifications" required="required" name="qualifications">{{ old('qualifications') }}</textarea>
              @if($errors->has('qualifications'))
                <code><span style="color:red; font-size:12px;">{{ $errors->first('qualifications')}}</span></code>
              @endif
            </div>
          </div>
          
          <div class="ln_solid"></div>
          <div class="form-group">
            <div class="col-md-6 col-md-offset-3">
              <a href="{{ route('backend.careers') }}" class="btn btn-primary">Cancel</a>
              <button id="send" type="submit" class="btn btn-success">Submit</button>
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
    CKEDITOR.replace('job_description', {
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

    CKEDITOR.replace('responsibilities', {
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

    CKEDITOR.replace('qualifications', {
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
