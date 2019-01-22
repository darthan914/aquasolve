@extends('backend.layout.master')

@section('title')
  <title>{{ $name->title }} | Solutions</title>
@endsection

@section('headscript')
<link href="{{ asset('backend/vendors/datatables.net-bs/css/dataTables.bootstrap.min.css') }}" rel="stylesheet">
<link href="{{ asset('backend/vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css') }}" rel="stylesheet">
@endsection

@section('content')
  @if(Session::has('berhasil'))
  <script>
    window.setTimeout(function() {
      $(".alert-success").fadeTo(700, 0).slideUp(700, function(){
          $(this).remove();
      });
    }, 5000);
  </script>
  <div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
      <div class="alert alert-success alert-dismissible fade in" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
        <strong>{{ Session::get('berhasil') }}</strong>
      </div>
    </div>
  </div>
  @endif

  <div class="modal fade modal-form-add" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <form action="{{ route('backend.solutions.store') }}" method="POST" class="form-horizontal form-label-left" enctype="multipart/form-data">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            <h4 class="modal-title" id="myModalLabel2">Add Solutions</h4>
          </div>
          <div class="modal-body">
            {{ csrf_field() }}
            <div class="item form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12">Gambar Max 700x700</label>
              <div class="col-md-9 col-sm-9 col-xs-12">
                <input class="form-control col-md-7 col-xs-12" name="picture" type="file" accept=".jpg,.png">
                @if($errors->has('picture'))
                  <code><span style="color:red; font-size:12px;">{{ $errors->first('picture')}}</span></code>
                @endif
              </div>
            </div>
            <div class="item form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12">Category</label>
              <div class="col-md-9 col-sm-9 col-xs-12">
                <select id="category" class="form-control col-md-7 col-xs-12" name="category" required="required">
                  @foreach($SolutionsCategory as $list)
                    <option value="{{$list->id}}" {{ old('category') == $list->id ? 'selected' : '' }}>{{$list->name}}</option>
                  @endforeach
                </select>
                @if($errors->has('category'))
                  <code><span style="color:red; font-size:12px;">{{ $errors->first('category')}}</span></code>
                @endif
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button id="send" type="submit" class="btn btn-success">Submit</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <div class="modal fade modal-form-change" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <form action="{{ route('backend.solutions.store.change') }}" method="POST" class="form-horizontal form-label-left" enctype="multipart/form-data">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            <h4 class="modal-title" id="myModalLabel2">Change Solutions Category</h4>
          </div>
          <div class="modal-body">
            {{ csrf_field() }}
            <img id="picture" src="" style="width: 100%;">
            <div class="item form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12">Gambar Max 700x700</label>
              <div class="col-md-9 col-sm-9 col-xs-12">
                <input id="id" name="id" type="hidden" value="">
                <input class="form-control col-md-7 col-xs-12" name="picture" type="file" accept=".jpg,.png">
                @if($errors->has('picture'))
                  <code><span style="color:red; font-size:12px;">{{ $errors->first('picture')}}</span></code>
                @endif
              </div>
            </div>
            <div class="item form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12">Category</label>
              <div class="col-md-9 col-sm-9 col-xs-12">
                <select id="category" class="form-control col-md-7 col-xs-12" name="category" required="required">
                  @foreach($SolutionsCategory as $list)
                    <option value="{{$list->id}}">{{$list->name}}</option>
                  @endforeach
                </select>
                @if($errors->has('category'))
                  <code><span style="color:red; font-size:12px;">{{ $errors->first('category')}}</span></code>
                @endif
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button id="send" type="submit" class="btn btn-success">Submit</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
      <div class="x_panel">
        <div class="x_title">
          <h2>Solutions </h2>
          <ul class="nav panel_toolbox">
            <a class="btn btn-success btn-sm" data-toggle='modal' data-target='.modal-form-add'><i class="fa fa-plus"></i> Add</a>
          </ul>
          <div class="clearfix"></div>
        </div>
        <div class="x_content table-responsive">
          <table id="data-table" class="table table-striped table-bordered no-footer" width="100%">
            <thead>
              <tr role="row">
                <th>No</th>
                <th>Picture</th>
                <th>Category</th>
                <th>Tools</th>
              </tr>
            </thead>
            <tbody>
            @php
              $no = 1;
            @endphp
            @foreach ($SolutionsImg as $key)
              <tr>
                <td>{{ $no++ }}</td>
                <td>
                  <a href="{{ asset('amadeo/images/'.$key->picture) }}" target="_blank">
                    <img src="{{ asset('amadeo/images/'.$key->picture) }}" style="height: 90px;">
                  </a>
                </td>
                <td>
                  {{ $key->solutionsCategory->name }}
                </td>
                <td>
                  <a href="{{ route('backend.solutions.FP', ['id'=> $key->id]) }}">
                    <span class="label {{ $key->flug_publish == 'N' ? 'label-danger' : 'label-success'}}" data-toggle="tooltip" data-placement="left" title="Click to {{ $key->flug_publish == 'N' ? 'Publish' : 'Unpublish'}}">
                      <i class="fa {{ $key->flug_publish == 'N' ? 'fa-thumbs-o-down' : 'fa-thumbs-o-up'}} "></i> {{ $key->flug_publish == 'N' ? 'Unpublish' : 'Publish'}}
                    </span>
                  </a>
                  <br>
                  <a 
                    href="" 
                    class="triger-change-data" 
                    data-toggle='modal' 
                    data-target='.modal-form-change'
                    data-id='{{ $key->id }}'
                    data-picture="{{ asset('amadeo/images/'.$key->picture) }}"
                  >
                    <span class="label label-success" data-toggle="tooltip" data-placement="left" title="Click to Change This Data">
                      <i class="fa fa-pencil-square-o "></i> Change
                    </span>
                  </a>
                  <br>
                  <a href="{{ route('backend.solutions.delete', ['id'=> $key->id]) }}">
                    <span class="label label-danger" data-toggle="tooltip" data-placement="left" title="Click to Delete This Data">
                      <i class="fa fa-trash "></i> Delete
                    </span>
                  </a>
                </td>
              </tr>
            @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>



@endsection

@section('script')
<script src="{{ asset('backend/vendors/datatables.net/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('backend/vendors/datatables.net-bs/js/dataTables.bootstrap.min.js') }}"></script>
<script src="{{ asset('backend/vendors/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('backend/vendors/datatables.net-scroller/js/datatables.scroller.min.js') }}"></script>
<script type="text/javascript">
  $('#data-table').DataTable();

  $('.triger-change-data').click(function(){
      $('.modal-form-change input#id').val($(this).data('id'));
      $('.modal-form-change img#picture').attr("src",$(this).data('picture'));
  });
</script>

@if(Session::has('info-form-add'))
<script>
$('.modal-form-add').modal('show');
</script>
@endif

@if(Session::has('info-form-change'))
<script>
$('.modal-form-change').modal('show');
</script>
@endif

@endsection