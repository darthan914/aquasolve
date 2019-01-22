@extends('backend.layout.master')

@section('title')
  <title>{{ $name->title }} | Partner</title>
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

<div class="modal fade modal-unpublish" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content alert-danger">

      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
        </button>
        <h4 class="modal-title" id="myModalLabel2">Unpublish Partner</h4>
      </div>
      <div class="modal-body">
        <h4>Are you sure ?</h4>
        <p>Partner will not publish in website</p>
      </div>
      <div class="modal-footer">
        <a class="btn btn-primary" id="setUnpublish">Ya</a>
      </div>

    </div>
  </div>
</div>

<div class="modal fade modal-publish" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">

      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
        </button>
        <h4 class="modal-title" id="myModalLabel2">Publish Partner</h4>
      </div>
      <div class="modal-body">
        <h4>Are you sure ?</h4>
      </div>
      <div class="modal-footer">
        <a class="btn btn-primary" id="setPublish">Yes</a>
      </div>

    </div>
  </div>
</div>


<div class="modal fade modal-hapus" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content alert-danger">

      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
        </button>
        <h4 class="modal-title" id="myModalLabel2">Delete Partner</h4>
      </div>
      <div class="modal-body">
        <h4>Are you sure?</h4>
      </div>
      <div class="modal-footer">
        <a class="btn btn-primary" id="setHapus">Delete</a>
      </div>

    </div>
  </div>
</div>


<div class="page-title">
  <div class="title_left">
    <h3>Partner <small></small></h3>
  </div>
</div>

<div class="clearfix"></div>
<div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_title">
        <h2>Partner </h2>
        <ul class="nav panel_toolbox">
          @if(Auth::user()->can('create-page'))
          <a href="{{ route('backend.partner.tambah') }}" class="btn btn-success btn-sm"><i class="fa fa-plus"></i> Add</a>
          @endif
        </ul>
        <div class="clearfix"></div>
      </div>
      <div class="x_content table-responsive">
        <table id="Partnertabel" class="table table-striped table-bordered no-footer" width="100%">
          <thead>
            <tr role="row">
              <th>No</th>
              <th>Partner</th>
              <th>Image</th>
              <th>Url</th>
              {{--
              <th>Buy Now!!</th>
              --}}
              <th>Publish</th>
              <th>Tools</th>
            </tr>
          </thead>
          <tbody>
            @php
              $no = 1;
            @endphp
            @foreach ($getPartner as $key)
            <tr>
              <td>{{ $no }}</td>
              <td>{{ $key->name }}</td>
              <td class="text-center"><img src="{{ asset('amadeo/images/partner').'/'.$key->img_url}}"></td>
              <td>{{ $key->link_url or '-' }}</td>
              {{--
              <td>@if ($key->flag_buynow == 1)
                    <a href=""><span class="label label-success"><i class="fa fa-thumbs-o-up"></i></span></a>
                  @else
                    <a href=""><span class="label label-danger"><i class="fa fa-thumbs-o-down"></i></span></a>
                  @endif
              </td>
              --}}
              <td>
                @if(Auth::user()->can('edit-page'))
                @if ($key->flag_publish == 1)
                    <a href="" class="unpublish" data-value="{{ $key->id }}" data-toggle="modal" data-target=".modal-unpublish"><span class="label label-success" data-toggle="tooltip" data-placement="top" title="Publish"><i class="fa fa-thumbs-o-up"></i></span></a>
                  @else
                    <a href="" class="publish" data-value="{{ $key->id }}" data-toggle="modal" data-target=".modal-publish"><span class="label label-danger" data-toggle="tooltip" data-placement="top" title="Unpublish"><i class="fa fa-thumbs-o-down"></i></span></a>
                  @endif
                @endif
              </td>
              <td>
                @if(Auth::user()->can('edit-page'))
                <a href="{{ route('backend.partner.update', $key->id) }}" class="btn btn-xs btn-warning btn-sm" data-toggle="tooltip" data-placement="top" title="Update"><i class="fa fa-pencil"></i> </a>
                @endif
                @if(Auth::user()->can('delete-page'))
                <a href="" class="hapus" data-value="{{ $key->id }}" data-toggle="modal" data-target=".modal-hapus"><span class="btn btn-xs btn-danger delete" data-toggle="tooltip" data-placement="top" title="Delete"><i class="fa fa-close"></i> </span></a>
                @endif
              </td>
            </tr>
            @php
              $no++;
            @endphp
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
<script src="{{ asset('backend/vendors/pnotify/dist/pnotify.js') }}"></script>
<script src="{{ asset('backend/vendors/pnotify/dist/pnotify.nonblock.js') }}"></script>

<script type="text/javascript">
  $('#Partnertabel').DataTable();

  $(function(){
    $('#Partnertabel').on('click', 'a.unpublish', function(){
      var a = $(this).data('value');
      $('#setUnpublish').attr('href', "{{ url('/') }}/admin/partner/flag-publish/"+a);
    });
  });

  $(function(){
    $('#Partnertabel').on('click', 'a.publish', function(){
      var a = $(this).data('value');
      $('#setPublish').attr('href', "{{ url('/') }}/admin/partner/flag-publish/"+a);
    });
  });

  $(function(){
    $('#Partnertabel').on('click', 'a.hapus', function(){
      var a = $(this).data('value');
      $('#setHapus').attr('href', "{{ url('/') }}/admin/partner/delete/"+a);
    });
  });
</script>
@endsection
