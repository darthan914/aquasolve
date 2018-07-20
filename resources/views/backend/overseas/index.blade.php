@extends('backend.layout.master')

@section('title')
  <title>{{ $name->title }} | Overseas</title>
@endsection

@section('headscript')
  <link href="{{ asset('backend/vendors/datatables.net-bs/css/dataTables.bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{ asset('backend/vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css') }}" rel="stylesheet">
@endsection

@section('style')
<style type="text/css">
  .map-relative{
    position: relative;
    width: 100%;
  }

  .map-relative > img{
    width: 100%;
  }

  .map-relative .pin-marker{
    position: absolute;
  }

  .pin-marker > img{
    position: absolute;
    bottom: 100%;
  }

  .pin-marker > .pin-description{
    position: absolute;
      background-color: white;
      border-radius: 5px;
      bottom: -60px;
      box-shadow: 5px 5px #0000002e;
      opacity: 0;
      visibility: hidden;
      -webkit-transition: opacity 1s; /* Chrome, Safari */
      -moz-transition: opacity 1s; /* Mozilla */
      -o-transition: opacity 1s; /* Opera */
      transition: opacity 1s;
  }

  @media(min-width: 992px)
  {
    .pin-marker > img{
      width: 30px;
      left: -15px;
    }

    .pin-marker > .pin-description{
        width: 100px;
        padding: 10px;
        margin: 0px 30px;
        bottom: -60px;
    }

    .pin-marker:hover > .pin-description{
      visibility: visible;
        opacity: 1;
        
    }

    .pin-marker > .pin-description.bottom{
      bottom: 0%;
    }
    .pin-marker > .pin-description.right{
      right: 0%;
    }
  }

  @media(max-width: 991px)
  {
    .pin-marker > img{
      width: 20px;
      left: -10px;
    }

    .pin-marker > .pin-description{
        width: 100px;
        padding: 10px;
        margin: 0px 15px;
        bottom: -75px;
    }
  }

  @media(max-width: 767px)
  {
    .pin-marker > img{
      width: 10px;
      left: -5px;
    }

    .pin-marker > .pin-description{
        width: 100px;
        padding: 5px;
        margin: 0px 10px;
        bottom: -80px;
    }
  }
</style>
@endsection

@section('script')
<script type="text/javascript">
  $(document).ready(function(e) {
        $('.map-relative:not(.ignore)').click(function(e) {
            var posX = $(this).offset().left;
            var posY = $(this).offset().top;
            var width = $(this).width();
            var height = $(this).height();

            var percentLeft = ((e.pageX - posX) / width) * 100; 
            var percentBottom = 100 - (((e.pageY - posY) / height) * 100); 

            $(".pin-marker:not(.ignore)").css({
              left: percentLeft + '%',
              bottom: percentBottom + '%'
            });

            $("input[name=css_left]").val(percentLeft);
            $("input[name=css_bottom]").val(percentBottom);
        });

        $('.triger-change-data').click(function(e) {

            $("input[name=name]:not(.ignore)").val($(this).data('name'));
            $("input[name=id]:not(.ignore)").val($(this).data('id'));
            $("input[name=css_left]:not(.ignore)").val($(this).data('css_left'));
            $("input[name=css_bottom]:not(.ignore)").val($(this).data('css_bottom'));

            $(".pin-marker:not(.ignore)").css({
              left: $(this).data('css_left') + '%',
              bottom: $(this).data('css_bottom') + '%'
            });
        });
    });
</script>
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
        <form action="{{ route('backend.overseas.store') }}" method="POST" class="form-horizontal form-label-left" enctype="multipart/form-data">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            <h4 class="modal-title" id="myModalLabel2">Add Overseas</h4>
          </div>
          <div class="modal-body">
            {{ csrf_field() }}
            <div id="map" class="map-relative">
              <img src="{{ asset('amadeo/images/'.$distribution->picture) }}">
              <div class="pin-marker">
                <img src="{{ asset('amadeo/images-base/pin-loc.png') }}">
              </div>
            </div>
            <div><p>Klik peta untuk menentukan posisi</p></div>

            <div class="item form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12">Name</label>
              <div class="col-md-9 col-sm-9 col-xs-12">
                <input id="name" class="form-control col-md-7 col-xs-12 ignore" name="name" type="text" value="{{ old('name') }}">
                @if($errors->has('name'))
                  <code><span style="color:red; font-size:12px;">{{ $errors->first('name')}}</span></code>
                @endif
              </div>
            </div>

            <div class="item form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12">CSS Left</label>
              <div class="col-md-9 col-sm-9 col-xs-12">
                <input id="css_left" class="form-control col-md-7 col-xs-12 ignore" name="css_left" type="text" value="{{ old('css_left') }}" readonly>
                @if($errors->has('css_left'))
                  <code><span style="color:red; font-size:12px;">{{ $errors->first('css_left')}}</span></code>
                @endif
              </div>
            </div>

            <div class="item form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12">CSS Bottom</label>
              <div class="col-md-9 col-sm-9 col-xs-12">
                <input id="css_bottom" class="form-control col-md-7 col-xs-12 ignore" name="css_bottom" type="text" value="{{ old('css_bottom') }}" readonly>
                @if($errors->has('css_bottom'))
                  <code><span style="color:red; font-size:12px;">{{ $errors->first('css_bottom')}}</span></code>
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
        <form action="{{ route('backend.overseas.store.change') }}" method="POST" class="form-horizontal form-label-left" enctype="multipart/form-data">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            <h4 class="modal-title" id="myModalLabel2">Change Overseas</h4>
          </div>
          <div class="modal-body">
            {{ csrf_field() }}
            <div id="map" class="map-relative">
              <img src="{{ asset('amadeo/images/'.$distribution->picture) }}">
              <div class="pin-marker">
                <img src="{{ asset('amadeo/images-base/pin-loc.png') }}">
              </div>
            </div>
            <div><p>Klik peta untuk menentukan posisi</p></div>

            <div class="item form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12">Name</label>
              <div class="col-md-9 col-sm-9 col-xs-12">
                <input id="id" name="id" type="hidden" value="">
                <input id="name" class="form-control col-md-7 col-xs-12" name="name" type="text" value="{{ old('name') }}">
                @if($errors->has('name'))
                  <code><span style="color:red; font-size:12px;">{{ $errors->first('name')}}</span></code>
                @endif
              </div>
            </div>

            <div class="item form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12">CSS Left</label>
              <div class="col-md-9 col-sm-9 col-xs-12">
                <input id="css_left" class="form-control col-md-7 col-xs-12" name="css_left" type="text" value="{{ old('css_left') }}" readonly>
                @if($errors->has('css_left'))
                  <code><span style="color:red; font-size:12px;">{{ $errors->first('css_left')}}</span></code>
                @endif
              </div>
            </div>

            <div class="item form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12">CSS Bottom</label>
              <div class="col-md-9 col-sm-9 col-xs-12">
                <input id="css_bottom" class="form-control col-md-7 col-xs-12" name="css_bottom" type="text" value="{{ old('css_bottom') }}" readonly>
                @if($errors->has('css_bottom'))
                  <code><span style="color:red; font-size:12px;">{{ $errors->first('css_bottom')}}</span></code>
                @endif
              </div>
            </div>

          </div>
          <div class="modal-footer">
            <button id="send" type="submit" class="btn btn-success">Submit</button>
            <input type="hidden" name="id" value="{{ old('id') }}">
          </div>
        </form>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
      <div class="x_panel">
        <div class="x_title">
          <h2>Overseas </h2>
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
            @foreach ($Overseas as $key)
              <tr>
                <td>{{ $no++ }}</td>
                <td>{{ $key->name }} </td>
                <td>
                    <div id="map" class="map-relative ignore" style="width: 200px">
                      <img src="{{ asset('amadeo/images/'.$distribution->picture) }}">
                      <div class="pin-marker ignore" style="left: {{$key->css_left}}%; bottom: {{$key->css_bottom}}%">
                        <img src="{{ asset('amadeo/images-base/pin-loc.png') }}">
                      </div>
                    </div>
                </td>
                <td>
                  @if(Auth::user()->can('edit-page'))
                  <a href="{{ route('backend.overseas.FP', ['id'=> $key->id]) }}">
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
                    data-name='{{ $key->name }}'
                    data-css_left='{{ $key->css_left }}'
                    data-css_bottom='{{ $key->css_bottom }}'
                    data-picture="{{ asset('amadeo/images/overseas/'.$key->img_url) }}"
                  >
                    <span class="label label-success" data-toggle="tooltip" data-placement="left" title="Click to Change This Data">
                      <i class="fa fa-pencil-square-o "></i> Change
                    </span>
                  </a>
                  @endif
                  
                  @if(Auth::user()->can('delete-page'))
                  <br>
                  <a href="{{ route('backend.overseas.delete', ['id'=> $key->id]) }}">
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
      $('.modal-form-change input#name').val($(this).data('name'));
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
