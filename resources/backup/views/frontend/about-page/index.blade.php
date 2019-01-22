@extends('frontend._layout.basic')

@section('title')
	<title>{{ $name->title }} | About Us</title>
@endsection

@section('meta')
@endsection

@section('style')
	<link rel="stylesheet" type="text/css" href="{{ asset('amadeo/css/bootstrap-grid.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('amadeo/plugin/owl-carousel/owl.carousel.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('amadeo/plugin/owl-carousel/owl.theme.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('amadeo/plugin/owl-carousel/owl.transitions.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('amadeo/css/about.css') }}">
@endsection

@section('body')
	<div id="about">
		<div id="wrapper">
			<h1>{{$about->title}}</h1>
			@php
				$count=0;
				$sump = substr_count($about->content, '</p>');
			@endphp
			@if($sump%2 != 0)
				@php
					$sump++;
				@endphp
			@endif
			@foreach(explode('</p>', $about->content) as $info)
				@php
					$count++;
				@endphp
				@if($count == 1)
					<div class="bar">
				@endif
						{!! $info !!}
				@if($count == $sump)
					</div>
				@endif
				@if($count == $sump/2)
					</div>
					<div class="bar">
				@endif
			@endforeach
			<div class="clearfix"></div>
		</div>
	</div>

	<div id="facility" style="background-image: url('{{ asset('amadeo/images-base/abou-facility.jpg') }}');">
		<div id="wrapper">
			<h1>{{$facility->title}}</h1>
			{!! $facility->content !!}
		</div>
	</div>

	<div id="certification" class="bootstrap">
		<div id="wrapper">
			<h1>CERTIFICATION</h1>
			
			<div class="container hidden-xs hidden-sm certification-logo">
    		    @foreach($Certification as $list)
					<img src="{{ asset('amadeo/images/'.$list->picture) }}" align="bottom">
    			@endforeach
        	</div>

			<div id="certification-sliders" class="hidden-md hidden-lg">
				@foreach($Certification as $list)
				<div class="item">
					<div id="contain">
						<p>{{ $list->title }}</p>
						<div class="certification-center">
							<div class="certification-midle">
								<a href="{{ asset('amadeo/images/'.$list->picture) }}" target="_blank">
									<img src="{{ asset('amadeo/images/'.$list->picture) }}">
								</a>
							</div>
						</div>
					</div>
				</div>
				@endforeach
			</div>
		</div>
	</div>

	<div id="vedio">
		@php
			$url 			= $vidio->content;
			$step1			= explode('v=', $url);
			$step2 			= explode('&',$step1[1]);
			$vedio_id 		= $step2[0];
			
			$thumbnail 		= 'http://img.youtube.com/vi/'.$vedio_id.'/0.jpg';
			$vedio_embed 	= 'http://www.youtube.com/embed/'.$vedio_id;
		@endphp
		<iframe width="100%" height="575px" src="{{$vedio_embed}}" frameborder="0" allowfullscreen></iframe>
	</div>
@endsection

@section('script')
	<script type="text/javascript" src="{{ asset('amadeo/plugin/owl-carousel/owl.carousel.min.js') }}"></script>
	<script type="text/javascript">
		$("#certification-sliders").owlCarousel({
			navigation : false,
			items: 3,
			singleItem:false,
			pagination:false,
			autoPlay: 2500,
		    stopOnHover:true
		});
	</script>
@endsection

