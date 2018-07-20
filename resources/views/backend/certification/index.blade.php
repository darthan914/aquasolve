@extends('backend.layout.master')

@section('title')
  <title>{{ $name->title }} | Certification</title>
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
        <form action="{{ route('backend.certification.store') }}" method="POST" class="form-horizontal form-label-left" enctype="multipart/form-data">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            <h4 class="modal-title" id="myModalLabel2">Add Certification</h4>
          </div>
          <div class="modal-body">
            {{ csrf_field() }}
            <div class="item form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12">Title</label>
              <div class="col-md-9 col-sm-9 col-xs-12">
                <input id="title" class="form-control col-md-7 col-xs-12" name="title" type="text" value="{{ old('title') }}">
                @if($errors->has('title'))
                  <code><span style="color:red; font-size:12px;">{{ $errors->first('title')}}</span></code>
                @endif
              </div>
            </div>
            <div class="item form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12">Gambar Max 700x700</label>
              <div class="col-md-9 col-sm-9 col-xs-12">
                <input class="form-control col-md-7 col-xs-12" name="picture" type="file" accept=".jpg,.png">
                @if($errors->has('picture'))
                  <code><span style="color:red; font-size:12px;">{{ $errors->first('picture')}}</span></code>
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
        <form action="{{ route('backend.certification.store.change') }}" method="POST" class="form-horizontal form-label-left" enctype="multipart/form-data">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            <h4 class="modal-title" id="myModalLabel2">Change Certification</h4>
          </div>
          <div class="modal-body">
            {{ csrf_field() }}
            <div class="item form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12">Title</label>
              <div class="col-md-9 col-sm-9 col-xs-12">
                <input id="id" name="id" type="hidden" value="">
                <input id="title" class="form-control col-md-7 col-xs-12" name="title" type="text" value="{{ old('title') }}">
                @if($errors->has('title'))
                  <code><span style="color:red; font-size:12px;">{{ $errors->first('title')}}</span></code>
                @endif
              </div>
            </div>
            <div class="item form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12">Gambar Max 700x700</label>
              <div class="col-md-9 col-sm-9 col-xs-12">
                <input class="form-control col-md-7 col-xs-12" name="picture" type="file" accept=".jpg,.png">
                @if($errors->has('picture'))
                  <code><span style="color:red; font-size:12px;">{{ $errors->first('picture')}}</span></code>
                @endif
              </div>
              <a href="" id="picture-link" target="_blank">
                <img src="" style="height: 90px;" id="picture-show">
              </a>
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
          <h2>Certification </h2>
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
                <th>Name</th>
                <th>Picture</th>
                <th>Tools</th>
              </tr>
            </thead>
            <tbody>
            @php
              $no = 1;
            @endphp
            @foreach ($Certification as $key)
              <tr>
                <td>{{ $no++ }}</td>
                <td>{{ $key->title }} </td>
                <td>
                  <a href="{{ asset('amadeo/images/'.$key->picture) }}" target="_blank">
                    <img src="{{ asset('amadeo/images/'.$key->picture) }}" style="height: 90px;">
                  </a>
                </td>
                <td>
                  @if(Auth::user()->can('edit-page'))
                  <a href="{{ route('backend.certification.FP', ['id'=> $key->id]) }}">
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
                    data-title='{{ $key->title }}'
                    data-picture="{{ asset('amadeo/images/'.$key->picture) }}"
                  >
                    <span class="label label-success" data-toggle="tooltip" data-placement="left" title="Click to Change This Data">
                      <i class="fa fa-pencil-square-o "></i> Change
                    </span>
                  </a>
                  @endif

                  @if(Auth::user()->can('delete-page'))
                  <br>
                  <a href="{{ route('backend.certification.delete', ['id'=> $key->id]) }}">
                    <span class="label label-danger" data-toggle="tooltip" data-placement="left" title="Click to Delete This Data">
                      <i class="fa fa-trash "></i> Delete
                    </span>
                  </a>
                  @endif

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
      $('.modal-form-change input#title').val($(this).data('title'));
      $('.modal-form-change a#picture-link').attr('href', $(this).data('picture'));
      $('.modal-form-change img#picture-show').attr('src', $(this).data('picture'));
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
