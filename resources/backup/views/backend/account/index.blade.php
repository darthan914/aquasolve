@extends('backend.layout.master')

@section('title')
  <title>{{ $name->title }} | Manage Account</title>
@endsection

@section('headscript')
<link href="{{ asset('backend/vendors/datatables.net-bs/css/dataTables.bootstrap.min.css') }}" rel="stylesheet">
<link href="{{ asset('backend/vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css') }}" rel="stylesheet">
<link href="{{ asset('backend/vendors/pnotify/dist/pnotify.css') }}" rel="stylesheet">
<link href="{{ asset('backend/vendors/pnotify/dist/pnotify.nonblock.css') }}" rel="stylesheet">
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
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
        </button>
        <strong>{{ Session::get('berhasil') }}</strong>
      </div>
    </div>
  </div>
@endif

<div class="row">
  <div class="col-md-4 col-sm-4 col-xs-12">
    <div class="x_panel">
      <div class="x_title">
        <h2>Create Akun </h2>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
        <form class="form-horizontal form-label-left" action="{{ route('backend.user.store') }}" method="post">
          {{ csrf_field() }}
          <div class="item form-group {{ $errors->has('new_name') ? 'has-error' : ''}}">
            <label class="control-label col-md-2 col-sm-2 col-xs-12">Nama</label>
            <div class="col-md-8 col-sm-8 col-xs-12">
              <input id="new_name" type="text" name="new_name" value="{{ old('new_name') }}" class="form-control col-md-7 col-xs-12">
              @if($errors->has('new_name'))
                <code><span style="color:red; font-size:12px;">{{ $errors->first('new_name')}}</span></code>
              @endif
            </div>
          </div>
          <div class="item form-group  {{ $errors->has('new_email') ? 'has-error' : ''}}">
            <label class="control-label col-md-2 col-sm-2 col-xs-12">Email</label>
            <div class="col-md-8 col-sm-8 col-xs-12">
              <input id="new_email" type="email" name="new_email" value="{{ old('new_email') }}" class="form-control col-md-7 col-xs-12">
              @if($errors->has('new_email'))
                <code><span style="color:red; font-size:12px;">{{ $errors->first('new_email')}}</span></code>
              @endif
            </div>
          </div>
          <div class="ln_solid"></div>
          <div class="box-footer">
            <button id="send" type="submit" class="btn btn-success">Submit</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <div class="col-md-8 col-sm-8 col-xs-12">
    <div class="x_panel">
      <div class="x_title">
        <h2>Your Account </h2>
        <div class="clearfix"></div>
      </div>
      <div class="x_content table-responsive">
        <div class="x_content">
          <form class="form-horizontal form-label-left" action="{{ route('backend.user.update') }}" method="post">
            {{ csrf_field() }}
            <div class="item form-group col-md-6 col-sm-12 col-xs-12 {{ $errors->has('name') ? 'has-error' : ''}}">
              <label class="control-label col-md-4 col-sm-4 col-xs-12">Nama</label>
              <div class="col-md-8 col-sm-8 col-xs-12">
                <input id="name" type="text" name="name" value="{{ old('name',$me->name) }}" class="form-control col-md-7 col-xs-12">
                @if($errors->has('name'))
                  <code><span style="color:red; font-size:12px;">{{ $errors->first('name')}}</span></code>
                @endif
              </div>
            </div>
            <div class="item form-group col-md-6 col-sm-12 col-xs-12  {{ $errors->has('email') ? 'has-error' : ''}}">
              <label class="control-label col-md-4 col-sm-4 col-xs-12">Email</label>
              <div class="col-md-8 col-sm-8 col-xs-12">
                <input id="email" type="email" name="email" value="{{ old('email',$me->email) }}" class="form-control col-md-7 col-xs-12">
                @if($errors->has('email'))
                  <code><span style="color:red; font-size:12px;">{{ $errors->first('email')}}</span></code>
                @endif
              </div>
            </div>
            <div class="item form-group col-md-6 col-sm-12 col-xs-12  {{ $errors->has('old_password') ? 'has-error' : ''}}">
              <label class="control-label col-md-4 col-sm-4 col-xs-12">Old Password</label>
              <div class="col-md-8 col-sm-8 col-xs-12">
                <input id="old_password" type="password" name="old_password" value="{{ old('old_password') }}" class="form-control col-md-7 col-xs-12">
                @if($errors->has('old_password') || Session::has('errors_oldpass'))
                  <code><span style="color:red; font-size:12px;">{{ $errors->first('old_password')}}{{ Session::get('errors_oldpass') }}</span></code>
                @endif
              </div>
            </div>
            <div class="item form-group col-md-6 col-sm-12 col-xs-12  {{ $errors->has('new_password') ? 'has-error' : ''}}">
              <label class="control-label col-md-4 col-sm-4 col-xs-12">New Password</label>
              <div class="col-md-8 col-sm-8 col-xs-12">
                <input id="new_password" type="password" name="new_password" value="{{ old('new_password') }}" class="form-control col-md-7 col-xs-12">
                @if($errors->has('new_password'))
                  <code><span style="color:red; font-size:12px;">{{ $errors->first('new_password')}}</span></code>
                @endif
              </div>
            </div>
            <div class="clearfix"></div>
            <div class="ln_solid"></div>
            <div class="box-footer">
              <button id="send" type="submit" class="btn btn-success">Submit</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_title">
        <h2>Account List </h2>
        <div class="clearfix"></div>
      </div>
      <div class="x_content table-responsive">
        <table id="usertabel" class="table table-striped table-bordered no-footer">
          <thead>
            <tr role="row">
              <th>No</th>
              <th>Nama</th>
              <th>Email</th>
              <th>Login Count</th>
              <th>Tools</th>
            </tr>
          </thead>
          <tbody>
            @php
              $no = 1;
            @endphp
            @foreach ($getUsers as $key)
            <tr>
              <td>{{ $no++ }}</td>
              <td>{{ $key->name }}</td>
              <td>{{ $key->email }}</td>
              <td>{{ $key->login_count }}</td>
              <td>
                @if($key->id != Auth::user()->id)
                  <a href="{{ route('backend.user.status', ['id'=> $key->id]) }}">
                    <span class="label {{ $key->status == 'N' ? 'label-danger' : 'label-success'}}" data-toggle="tooltip" data-placement="left" title="Click to {{ $key->status == 'N' ? 'Publish' : 'Unpublish'}}">
                      <i class="fa {{ $key->status == 'N' ? 'fa-thumbs-o-down' : 'fa-thumbs-o-up'}} "></i> {{ $key->status == 'N' ? 'Unpublish' : 'Publish'}}
                    </span>
                  </a>
                  <br>
                  <a href="{{ route('backend.user.resetpassword', ['id'=> $key->id]) }}">
                    <span class="label label-danger" data-toggle="tooltip" data-placement="left" title="Click to Reset Password For This Data">
                      <i class="fa fa-recycle "></i> Reset Password
                    </span>
                  </a>
                  <br>
                  <a href="{{ route('backend.user.delete', ['id'=> $key->id]) }}">
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
  $('#usertabel').DataTable();
  </script>
@endsection
