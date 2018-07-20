@extends('backend.layout.master')

@section('title')
  <title>{{ $name->title }} | Add | Product</title>
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
        <h2>Add Product<small></small></h2>
        <ul class="nav panel_toolbox">
          <a href="{{ route('backend.product') }}" class="btn btn-primary btn-sm">Back</a>
        </ul>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
        <form action="{{ route('backend.product.add.store') }}" method="POST" class="form-horizontal form-label-left" enctype="multipart/form-data" novalidate>
          {{ csrf_field() }}

          <div class="item form-group {{ $errors->has('name') ? 'has-error' : ''}}">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Name <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input id="name" class="form-control col-md-7 col-xs-12" name="name" placeholder="Name" required="required" type="text" value="{{ old('name') }}">
              @if($errors->has('name'))
                <code><span style="color:red; font-size:12px;">{{ $errors->first('name')}}</span></code>
              @endif
            </div>
          </div>

          <div class="item form-group {{ $errors->has('website') ? 'has-error' : ''}}">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="website">Website</label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input id="website" class="form-control col-md-7 col-xs-12" name="website" placeholder="Website" required="required" type="text" value="{{ old('website') }}">
              @if($errors->has('website'))
                <code><span style="color:red; font-size:12px;">{{ $errors->first('website')}}</span></code>
              @endif
            </div>
          </div>

          <div class="item form-group {{ $errors->has('descript') ? 'has-error' : ''}}">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="textarea">Descript <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input id="descript" class="form-control col-md-7 col-xs-12" name="descript" placeholder="Descript" required="required" type="text" value="{{ old('descript') }}">
              @if($errors->has('descript'))
                <code><span style="color:red; font-size:12px;">{{ $errors->first('descript')}}</span></code>
              @endif
            </div>
          </div>

          <div class="item form-group {{ $errors->has('category') ? 'has-error' : ''}}">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="textarea">Category <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <select id="category" class="form-control col-md-7 col-xs-12" name="category" required="required">
                @foreach($ProdukCategory as $list)
                  <option value="{{$list->id}}" {{ old('category') == $list->id ? 'selected' : '' }}>{{$list->name}}</option>
                @endforeach
              </select>
              @if($errors->has('category'))
                <code><span style="color:red; font-size:12px;">{{ $errors->first('category')}}</span></code>
              @endif
            </div>
          </div>
          
          <div class="item form-group {{ $errors->has('title_picture') ? 'has-error' : ''}}">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Title Picture <span class="required">*</span></label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input id="title_picture" class="form-control" name="title_picture" type="file" accept=".jpg,.png">
              @if($errors->has('title_picture'))
                <code><span style="color:red; font-size:12px;">{{ $errors->first('title_picture')}}</span></code>
              @endif
            </div>
          </div>

          <div class="item form-group {{ $errors->has('picture') ? 'has-error' : ''}}">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Picture <span class="required">*</span></label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input id="picture" class="form-control" name="picture" type="file" accept=".jpg,.png">
              @if($errors->has('picture'))
                <code><span style="color:red; font-size:12px;">{{ $errors->first('picture')}}</span></code>
              @endif
            </div>
          </div>
          
          <div class="item form-group {{ $errors->has('background_picture') ? 'has-error' : ''}}">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Background Picture <span class="required">*</span></label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input id="background_picture" class="form-control" name="background_picture" type="file" accept=".jpg,.png">
              @if($errors->has('background_picture'))
                <code><span style="color:red; font-size:12px;">{{ $errors->first('background_picture')}}</span></code>
              @endif
            </div>
          </div>

          <div class="ln_solid"></div>
          <div class="form-group">
            <div class="col-md-6 col-md-offset-3">
              <a href="{{ route('backend.product') }}" class="btn btn-primary">Cancel</a>
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
@endsection
