@extends('frontend._layout.basic')

@section('title')
	<title>{{ $name->title }}</title>
@endsection

@section('meta')
@endsection

@section('style')
	<link rel="stylesheet" type="text/css" href="{{ asset('amadeo/css/bootstrap-grid.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('amadeo/plugin/owl-carousel/owl.carousel.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('amadeo/plugin/owl-carousel/owl.theme.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('amadeo/plugin/owl-carousel/owl.transitions.css') }}">

	<link rel="stylesheet" type="text/css" href="{{ asset('amadeo/css/home.css') }}">
@endsection

@section('body')
	<div id="banner-slider">
		@foreach($Banner as $list)
		<div class="item">
			<div id="bg-banner" style="background-image: url('{{ asset('amadeo/images/'.$list->picture) }}');">
				<div id="descript-wrapper">
					<div id="contain">
						<h1>{{ $list->title }}</h1>
						<p>{{ $list->descript }}</p>

						<a href="#about">
							<img src="{{ asset('amadeo/images-base/chevron-downs.png') }}">
						</a>
					</div>
				</div>
			</div>
		</div>
		@endforeach
	</div>

	<div id="about">
		<div id="img" class="bar">
			<div id="bg-img" style="background-image: url('{{ asset('amadeo/images/'.$about->picture) }}');"></div>
		</div>
		<div id="contain" class="bar">
			<div id="wrapper">
				<h1>ABOUT US</h1>
				<p>
					{{ Illuminate\Support\Str::words(strip_tags($about->content), 50, '...') }}
				</p>
				<br>
				<br>
				<a href="{{ route('frontend.about') }}" class="buton-style">Learn More</a>
			</div>
		</div>
		<div class="clearfix"></div>
	</div>

	<div id="hot-area">
		<div class="item" style="background-image: url('{{ asset('amadeo/images/'.$facility->picture) }}');">
			<div id="midle">
				<div id="contain">
					<h1>{{$facility->title}}</h1>
					<p>
						{{ Illuminate\Support\Str::words(strip_tags($facility->content), 50, '...') }}
					</p>
					<br>
					<a href="{{ route('frontend.about') }}#facility" class="buton-style">Take a Look</a>
				</div>
			</div>
		</div>
		<div class="item" style="background-image: url('{{ asset('amadeo/images/'.$solutions->picture) }}');">
			<div id="midle">
				<div id="contain">
					<h1>{{ $solutions->title }}</h1>
					<p>
						{{ Illuminate\Support\Str::words(strip_tags($solutions->content), 50, '...') }}
					</p>
					<br>
					<a href="{{ route('frontend.solutions') }}" class="buton-style">Take a Look</a>
				</div>
			</div>
		</div>
	</div>

	<div id="product">
		<div id="list-wrapper">
			<div id="name" class="bar">
				<div class="midle">
					<h1>PRODUCTS</h1>
					<hr>
				</div>
			</div>
			<div id="list" class="bar">
				@php ($countForBreak = 0)
				
				@foreach($ProdukCategory as $keys)

				@foreach($product as $key)
				@if($key->flug_home == 'Y' and $key->category == $keys->id)
				<div class="product-select midle" 
					data-name="{{ $key->name }}" 
					data-img="{{ asset('amadeo/images/'.$key->picture) }}" 
					data-titleimg="{{ $key->title_picture != '' ? asset('amadeo/images/'.$key->title_picture) : '' }}" 
					data-bg="{{ asset('amadeo/images/'.$key->background_picture) }}"
					data-desc="{{ $key->descript }}" data-website="{{ $key->website }}"
					data-slug="{{ $key->slug }}">
					<img src="{{ asset('amadeo/images/'.$key->picture) }}" style="position:relative;height: 70px;left: 0px;">
					<p>{{ $key->name }}</p>
				</div>
				@php ($countForBreak++)
				@endif
				@if($countForBreak == 4)
				@break
				@endif
				@endforeach

				@endforeach
			</div>
			<div class="clearfix"></div>
		</div>
		<div id="discrip-wrapper" class="product-background-picture">
			<div id="contain">
				<h1 id="product-name"></h1>
				<p id="product-desc" class="hidden-sm hidden-xs"></p>
				<div id="website-link" class="product-website-link">
					<a class="buton-style" href="">Learn More</a>
				</div>
			</div>
			<img id="product-img" src="">
		</div>
	</div>

	<div id="news">
		<div id="wrapper">
			<div id="title">
				<h1>LATEST NEWS</h1>
				<hr>
			</div>

			@foreach($News as $list)
			<div class="item">
				<div id="contain">
					<a href="{{ route('frontend.news.view', ['slug'=>$list->slug]) }}">
						<div id="img" style="background-image: url('{{ asset('amadeo/images/'.$list->picture) }}');"></div>
					</a>
					<h3>{{ $list->name }}</h3>
					<p>{{ date("d F Y", strtotime($list->created_at) ) }}</p>
				</div>

			</div>
			@endforeach
			
			<div class="clearfix"></div>
		</div>
	</div>

@endsection

@section('script')
	<script type="text/javascript" src="{{ asset('amadeo/plugin/owl-carousel/owl.carousel.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('amadeo/js/product-select.js') }}"></script>
	<script type="text/javascript">
		$("#banner-slider").owlCarousel({
			navigation : false,
			items: 1,
			singleItem:true,
			pagination:true,
			autoPlay: 5000,
		    stopOnHover:true
		});
	</script>
	<script type="text/javascript">
		$(".product-select.midle:first").addClass("active");
		var Name = $(".product-select.midle:first").data('name');
	    var Desc = $(".product-select.midle:first").data('desc');
	    var Img  = $(".product-select.midle:first").data('img');
	    var TitleImg  = $(".product-select.midle:first").data('titleimg');
	    var Website  = $(".product-select.midle:first").data('website');
	    var Background  = $(".product-select.midle:first").data('bg');
	    
		$('p#product-desc').text(Desc);
		$('img#product-img').attr('src', Img);
		$('div#discrip-wrapper.product-background-picture').css('background-image', 'url(' + Background + ')');

		if(TitleImg == ""){
			$('h1#product-name').text(Name);
		}
		else{
			$('h1#product-name').html('<img style="position:relative;height: 70px;left: 0px;" src="'+TitleImg+'"/>');
		}
		
		if(Website == ""){
			$('div#website-link.product-website-link').addClass('load-data');
		}
		else{
			$('div#website-link.product-website-link a.buton-style').attr('href', Website);
		}
	</script>
@endsection
