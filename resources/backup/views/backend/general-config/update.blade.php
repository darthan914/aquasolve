@extends('backend.layout.master')

@section('title')
  <title>{{ $name->title }} | General Config - Update {{ $GeneralConfig->name }}</title>
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
          <h2>General Config - Update {{ $GeneralConfig->name }}<small></small></h2>
          <ul class="nav panel_toolbox">
            <a href="{{ route('backend.general-config') }}" class="btn btn-primary btn-sm">Back</a>
          </ul>
          <div class="clearfix"></div>
        </div>

        <div class="x_content">
          <form action="{{ route('backend.general-config.update.store', ['id'=>$GeneralConfig->id]) }}" method="POST" class="form-horizontal form-label-left" enctype="multipart/form-data">
            {{ csrf_field() }}

            <input type="hidden" name="id" value="{{$GeneralConfig->id}}">
            
            <div class="item form-group {{ $errors->has('title') ? 'has-error' : ''}}">
              <label class="control-label col-md-3 col-sm-3 col-xs-12">Title</label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <textarea id="title" class="form-control" name="title">{{ old('title', $GeneralConfig->title) }}</textarea>
                @if($errors->has('title'))
                  <code><span style="color:red; font-size:12px;">{{ $errors->first('title')}}</span></code>
                @endif
              </div>
            </div>

            <div class="item form-group {{ $errors->has('content') ? 'has-error' : ''}}">
              <label class="control-label col-md-3 col-sm-3 col-xs-12">Content</label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <textarea id="content" class="form-control" name="content">{{ old('content', $GeneralConfig->content) }}</textarea>
                @if($errors->has('content'))
                  <code><span style="color:red; font-size:12px;">{{ $errors->first('content')}}</span></code>
                @endif
              </div>
            </div>

            <div class="item form-group {{ $errors->has('picture') ? 'has-error' : ''}}">
              <label class="control-label col-md-3 col-sm-3 col-xs-12">Picture</label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <input id="picture" class="form-control" name="picture" type="file" accept=".jpg,.png">
                @if($errors->has('picture'))
                  <code><span style="color:red; font-size:12px;">{{ $errors->first('picture')}}</span></code>
                @endif
              </div>
            </div>

            <div class="item form-group {{ $errors->has('type') ? 'has-error' : ''}}">
              <label class="control-label col-md-3 col-sm-3 col-xs-12"> &nbsp; </label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <img width="20%" src="{{ asset('amadeo/images/'.$GeneralConfig->picture) }}" alt="">
                {!! $GeneralConfig->description !!}
              </div>
            </div>

            <div class="ln_solid"></div>

            <div class="form-group">
              <div class="col-md-6 col-md-offset-3">
                <a href="{{ route('backend.general-config') }}" class="btn btn-primary">Batal</a>
                <button id="send" type="submit" class="btn btn-success">Ubah</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>


@endsection

@section('script')
<script type="text/javascript">

  CKEDITOR.replace('content', {
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
