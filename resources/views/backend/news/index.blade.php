@extends('backend.layout.master')

@section('title')
  <title>{{ $name->title }} | News</title>
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
          <h2>News </h2>
          <ul class="nav panel_toolbox">
            @if(Auth::user()->can('create-news'))
            <a href="{{ route('backend.news.add') }}" class="btn btn-success btn-sm"><i class="fa fa-plus"></i> Add</a>
            @endif
          </ul>
          <div class="clearfix"></div>
        </div>
        <div class="x_content table-responsive">
          <table id="data-table" class="table table-striped table-bordered no-footer" width="100%">
            <thead>
              <tr role="row">
                <th>No</th>
                <th>Name</th>
                <th>Description</th>
                <th>Picture</th>
                <th>Tools</th>
              </tr>
            </thead>
            <tbody>
            @php
              $no = 1;
            @endphp
            @foreach ($News as $key)
              <tr>
                <td>{{ $no++ }}</td>
                <td>{{ $key->name }} </td>
                <td>
                  <div style="width: 300px; height: 150px; overflow-x: hidden; overflow-y: auto;">
                    {!! $key->descript !!}
                  </div>
                </td>
                <td>
                  <a href="{{ asset('amadeo/images/'.$key->picture) }}" target="_blank">
                    <img src="{{ asset('amadeo/images/'.$key->picture) }}" style="height: 90px;">
                  </a>
                </td>
                <td>
                  @if(Auth::user()->can('edit-news'))
                  <a href="{{ route('backend.news.FP', ['id'=> $key->id]) }}">
                    <span class="label {{ $key->flug_publish == 'N' ? 'label-danger' : 'label-success'}}" data-toggle="tooltip" data-placement="left" title="Click to {{ $key->flug_publish == 'N' ? 'Publish' : 'Unpublish'}}">
                      <i class="fa {{ $key->flug_publish == 'N' ? 'fa-thumbs-o-down' : 'fa-thumbs-o-up'}} "></i> {{ $key->flug_publish == 'N' ? 'Unpublish' : 'Publish'}}
                    </span>
                  </a>
                  <br>
                  <a 
                    href="{{ route('backend.news.store.change', ['id'=> $key->id]) }}" 
                    class="triger-change-data" 
                  >
                    <span class="label label-success" data-toggle="tooltip" data-placement="left" title="Click to Change This Data">
                      <i class="fa fa-pencil-square-o "></i> Change
                    </span>
                  </a>
                  @endif

                  
                  <br>
                  <a 
                    href="{{ route('backend.news.preview', ['id'=> $key->id]) }}" target="_new" 
                  >
                    <span class="label label-warning" data-toggle="tooltip" data-placement="left" title="Click to Preview">
                      <i class="fa fa-eye "></i> Preview
                    </span>
                  </a>

                  @if(Auth::user()->can('delete-news'))
                  <br>
                  <a href="{{ route('backend.news.delete', ['id'=> $key->id]) }}"  onclick="return confirm('Delete this data?');">
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
</script>

@endsection
