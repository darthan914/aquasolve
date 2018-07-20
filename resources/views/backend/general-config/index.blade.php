@extends('backend.layout.master')

@section('title')
  <title>{{ $name->title }} | General Config</title>
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
          <h2>Inbox </h2>
          <div class="clearfix"></div>
        </div>
        <div class="x_content table-responsive">
          <table id="table-data" class="table table-striped table-bordered no-footer" width="100%">
            <thead>
              <tr role="row">
                <th>No</th>
                <th>Name</th>
                <th>Title</th>
                <th>Content</th>
                <th>Picture</th>
                <th>Tools</th>
              </tr>
            </thead>
            <tbody>
            @php
              $no = 1;
            @endphp
            @foreach ($GeneralConfig as $key)
              <tr>
                <td rowspan="2">{{ $no++ }}</td>
                <td>{{ $key->name }} </td>
                <td>{{ $key->title }}</td>
                <td>{!! $key->content !!}</td>
                <td>
                    <img src="{{ asset('amadeo/images/'.$key->picture) }}" style="height: 90px;">
                </td>
                <td>
                  @if(Auth::user()->can('edit-page'))
                  <a href="{{ route('backend.general-config.update', ['id'=> $key->id]) }}">
                    <span class="label label-success" data-toggle="tooltip" data-placement="left" title="Click to Change This Data">
                      <i class="fa fa-pencil-square-o "></i> Change
                    </span>
                  </a>
                  @endif
                </td>
              </tr>
              <tr>
                <td colspan="5">
                  {!! $key->description !!}
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
  $('#table-data').DataTable();
</script>


@endsection
