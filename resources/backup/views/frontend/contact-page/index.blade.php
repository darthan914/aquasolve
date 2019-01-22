@extends('frontend._layout.basic')

@section('title')
	<title>{{ $name->title }} | Contact</title>
@endsection

@section('meta')
@endsection

@section('style')
	<link rel="stylesheet" type="text/css" href="{{ asset('amadeo/css/bootstrap-grid.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('amadeo/css/contact.css') }}">
@endsection

@section('body')
	<div id="maps">
		<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3965.4499759798864!2d106.6807423143141!3d-6.335711195414965!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69e504a69b23ab%3A0x3a02d749206e7d74!2sPT+Aquasolve+Sanaria!5e0!3m2!1sid!2sid!4v1509421865830" width="100%" height="575" frameborder="0" style="border:0" allowfullscreen></iframe>
	</div>
	<div id="send-message" class="bootstrap">
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
					<h1>Send a Message</h1>
					<form class="form-style" method="post" action="{{ route('frontend.contact.store') }}">
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

						@if($errors->has('subject'))
						<span>{{ $errors->first('subject')}}</span>
						@endif
						<input 
							type="text" 
							name="subject"
							placeholder="Subject"
							value="{{ old('subject') }}"
						>
						
						@if($errors->has('message'))
						<span>{{ $errors->first('message')}}</span>
						@endif
						<textarea 
							name="message" 
							placeholder="Type your message here*"
							rows="2" 
						>{{ old('message') }}</textarea>
						<button id="submit" type="submit">SUBMIT</button>

				    </form>
				</div>
			</div>
		</div>
	</div>
@endsection

@section('script')
	
@endsection
