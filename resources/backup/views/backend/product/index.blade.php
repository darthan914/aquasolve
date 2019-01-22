@extends('backend.layout.master')

@section('title')
  <title>{{ $name->title }} | Product</title>
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

  <div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
      <div class="x_panel">
        <div class="x_title">
          <h2>Product </h2>
          <ul class="nav panel_toolbox">
            <a href="{{ route('backend.product.add') }}" class="btn btn-success btn-sm"><i class="fa fa-plus"></i> Add</a>
          </ul>
          <div class="clearfix"></div>
        </div>
        <div class="x_content table-responsive">
          <table id="data-table" class="table table-striped table-bordered no-footer" width="100%">
            <thead>
              <tr role="row">
                <th>No</th>
                <th>Name</th>
                <th>Descript</th>
                <th>Category</th>
                <th>Picture</th>
                <th>Tools</th>
              </tr>
            </thead>
            <tbody>
            @php
              $no = 1;
            @endphp
            @foreach ($Product as $key)
              <tr>
                <td>{{ $no++ }}</td>
                <td>
                  {{ $key->name }}
                </td>
                <td>
                  {{ $key->descript }}
                </td>
                <td>
                  {{ $key->produkCategory->name }}
                </td>
                <td>
                    <p>Title :</p>
                    <a href="{{ asset('amadeo/images/'.$key->title_picture) }}" target="_blank">
                      <img src="{{ asset('amadeo/images/'.$key->title_picture) }}" style="max-height: 120px; max-width: 120px;" alt="{{$key->name}}">
                    </a>
                     <p>Picture :</p>
                    <a href="{{ asset('amadeo/images/'.$key->picture) }}" target="_blank">
                      <img src="{{ asset('amadeo/images/'.$key->picture) }}" style="max-height: 120px; max-width: 120px;">
                    </a>
                    <p>Background :</p>
                    <a href="{{ asset('amadeo/images/'.$key->background_picture) }}" target="_blank">
                      <img src="{{ asset('amadeo/images/'.$key->background_picture) }}" style="max-height: 120px; max-width: 120px;">
                    </a>
                </td>
                <td>
                  @if($key->website)
                  <a href="{{ $key->website }}">
                    <span class="label label-success" data-toggle="tooltip" data-placement="left" title="Click to Visit Website">
                      <i class="fa fa-globe"></i> Website
                    </span>
                  </a>
                  @endif
                  <a href="{{ route('backend.product.FP', ['id'=> $key->id]) }}">
                    <span class="label {{ $key->flug_publish == 'N' ? 'label-danger' : 'label-success'}}" data-toggle="tooltip" data-placement="left" title="Click to {{ $key->flug_publish == 'N' ? 'Publish' : 'Unpublish'}}">
                      <i class="fa {{ $key->flug_publish == 'N' ? 'fa-thumbs-o-down' : 'fa-thumbs-o-up'}} "></i> {{ $key->flug_publish == 'N' ? 'Unpublish' : 'Publish'}}
                    </span>
                  </a>
                  <br>
                  <a href="{{ route('backend.product.FH', ['id'=> $key->id]) }}">
                    <span class="label {{ $key->flug_home == 'N' ? 'label-danger' : 'label-success'}}" data-toggle="tooltip" data-placement="left" title="Click to {{ $key->flug_home == 'N' ? 'Show On Home' : 'Hide On Home'}}">
                      <i class="fa {{ $key->flug_home == 'N' ? 'fa-thumbs-o-down' : 'fa-thumbs-o-up'}} "></i> {{ $key->flug_home == 'N' ? 'Hide On Home' : 'Show On Home'}}
                    </span>
                  </a>
                  <br>
                  <a href="{{ route('backend.product.change', ['id'=> $key->id]) }}">
                    <span class="label label-success" data-toggle="tooltip" data-placement="left" title="Click to Change This Data">
                      <i class="fa fa-pencil-square-o "></i> Change
                    </span>
                  </a>
                  <br>
                  <a href="{{ route('backend.product.delete', ['id'=> $key->id]) }}">
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
</script>

@endsection
