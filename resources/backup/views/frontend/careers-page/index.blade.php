@extends('frontend._layout.basic')

@section('title')
	<title>{{ $name->title }} | Careers</title>
@endsection

@section('meta')
@endsection

@section('style')
	<link rel="stylesheet" type="text/css" href="{{ asset('amadeo/css/bootstrap-grid.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('amadeo/css/careers.css') }}">
@endsection

@section('body')
	<div id="careers">
		<div id="wrapper">
			<div id="top">
				<h1>{{$careers->title}}</h1>
				{!! $careers->content !!}
			</div>
			@foreach($Careers as $list)
			<div id="careers-slug-{{ $list->id }}" class="list un-active">
				<div id="head">
					<div id="name">
						<h2>{{ $list->name }}</h2>
						<label>{{ $list->contract }}</label>
					</div>
					<div id="triger-togle-wrapper">
						<div class="triger-togle" data-togle="careers-slug-{{ $list->id }}">
							MORE INFORMATION & APPLY <img src="{{ asset('amadeo/images-base/chevron-downs.png') }}">
						</div>
					</div>
					<div class="clearfix"></div>
				</div>
				<div class="body">
					<div id="content" class="bar">
						<h3>JOB DESCRIPTION</h3>
						{!! $list->job_description !!}
						<h3>RESPONSIBILITIES</h3>
						{!! $list->responsibilities !!}
						<h3>QUALIFICATIONS</h3>
						{!! $list->qualifications !!}
					</div>
					<div id="description" class="bar">
						<p>
							<label>Job Type :</label> {{ $list->job_type }}
						</p>
						<p>
							<label>Location :</label> {{ $list->location }}
						</p>
						<p>
							<label>Contract :</label> {{ $list->contract }}
						</p>
						<p>
							<label>Vacancy :</label> {{ $list->vacancy }}
						</p>
						<p>
							<label>Posting Date :</label> {{ date("d F Y", strtotime($list->created_at) ) }}
						</p>
						<br>
						<br>
						<div style="text-align: center;">
							<a href="">APPLY NOW</a>
						</div>
					</div>
					<div class="clearfix"></div>
				</div>
			</div>
			@endforeach

			<div id="apply-now" class="bootstrap">
				<div class="container">
					<div class="row">
						<div class="col-md-5">
							<h1>Contacts</h1>
							<img src="{{ asset('amadeo/images/'.$logoPutih->picture) }}">
							<h2>{{ $name->title }}</h2>
							{!! $address->content !!}
							<p>{{ $phone->title }} {{ $phone->content }}</p>
							<p>{{ $fax->title }} {{ $fax->content }}</p>
							<p>{{ $email->title }} {{ $email->content }}</p>
						</div>
						<div class="col-md-7">
							<h1>Job Application Form</h1>
							<form class="form-style" method="post" action="{{ route('frontend.careers.store') }}" enctype="multipart/form-data">
								@if(Session::has('alert'))
									<script>
									  window.setTimeout(function() {
									    $("#alret-form-kontak").fadeTo(700, 0).slideUp(700, function(){
									        $(this).remove();
									    });
									  }, 5000);
									</script>
							        <div id="alret-form-kontak" class="alert {{ Session::get('alert') }}">
							        	<strong>{{ Session::get('info') }}</strong>
							        </div>
								@endif
						        {{ csrf_field() }}

						        @if($errors->has('name'))
								<span>{{ $errors->first('name')}}</span>
								@endif
								<input 
									type="text" 
									name="name"
									placeholder="Full Name*"
									value="{{ old('name') }}"
									{{ Session::has('autofocus') ? 'autofocus' : ''}}
								>
								
								@if($errors->has('email'))
								<span>{{ $errors->first('email')}}</span>
								@endif
								<input 
									type="text" 
									name="email"
									placeholder="Email Address*"
									value="{{ old('email') }}"
								>

								@if($errors->has('telp'))
								<span>{{ $errors->first('telp')}}</span>
								@endif
								<input 
									type="text" 
									name="telp"
									placeholder="Telp*"
									value="{{ old('telp') }}"
								>

								@if($errors->has('position'))
								<span>{{ $errors->first('position')}}</span>
								@endif
								<input 
									type="text" 
									name="position"
									placeholder="Position*"
									value="{{ old('position') }}"
								>
								
								@if($errors->has('message'))
								<span>{{ $errors->first('message')}}</span>
								@endif
								<textarea 
									name="message" 
									placeholder="Type your message here*"
									rows="2" 
								>{{ old('message') }}</textarea>

								@if($errors->has('file'))
								<span>{{ $errors->first('file')}}</span>
								@endif
								<input 
									type="file" 
									name="file"
								>
								<button id="submit" type="submit">SUBMIT</button>

						    </form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection

@section('script')
	<script type="text/javascript">
		$(".triger-togle").click(function(){
			var triger = $(this).data("togle");
		    $("#"+triger).toggleClass("un-active");
		});
	</script>
@endsection
