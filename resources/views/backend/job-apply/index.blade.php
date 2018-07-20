@extends('backend.layout.master')

@section('title')
<title>
    {{ $name->title }} | Inbox
</title>
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
                    <button aria-label="Close" class="close" data-dismiss="alert" type="button">
                        <span aria-hidden="true">
                            ×
                        </span>
                    </button>
                    <strong>
                        {{ Session::get('berhasil') }}
                    </strong>
                </div>
            </div>
        </div>
        @endif
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>
                            Inbox
                        </h2>
                        <div class="clearfix">
                        </div>
                    </div>
                    <div class="x_content table-responsive">
                        <table class="table table-striped table-bordered no-footer" id="job-table" width="100%">
                            <thead>
                                <tr role="row">
                                    <th>
                                        No
                                    </th>
                                    <th>
                                        Name
                                    </th>
                                    <th>
                                        Email
                                    </th>
                                    <th>
                                        Phone
                                    </th>
                                    <th>
                                        Position
                                    </th>
                                    <th>
                                        Message
                                    </th>
                                    <th>
                                        File Attachment
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
              $no = 1;
            @endphp
            @foreach ($inbox as $key)
                                <tr>
                                    <td>
                                        {{ $no++ }}
                                    </td>
                                    <td>
                                        {{ $key->name }}
                                    </td>
                                    <td>
                                        {{ $key->email }}
                                    </td>
                                    <td>
                                        {{ $key->telp }}
                                    </td>
                                    <td>
                                        {{ $key->position }}
                                    </td>
                                    <td>
                                        {{ $key->message }}
                                    </td>
                                    <td>
                                        <a href="{{ asset($key->file) }}"><i class="fa fa-download"></i></a>
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
<script src="{{ asset('backend/vendors/datatables.net/js/jquery.dataTables.min.js') }}">
</script>
<script src="{{ asset('backend/vendors/datatables.net-bs/js/dataTables.bootstrap.min.js') }}">
</script>
<script src="{{ asset('backend/vendors/datatables.net-responsive/js/dataTables.responsive.min.js') }}">
</script>
<script src="{{ asset('backend/vendors/datatables.net-scroller/js/datatables.scroller.min.js') }}">
</script>
<script type="text/javascript">
    $('#job-table').DataTable();
</script>
@endsection
