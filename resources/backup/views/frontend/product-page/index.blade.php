@extends('frontend._layout.basic')

@section('title')
	<title>{{ $name->title }} | Product</title>
@endsection

@section('meta')
@endsection

@section('style')
	<link rel="stylesheet" type="text/css" href="{{ asset('amadeo/css/bootstrap-grid.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('amadeo/css/product.css') }}">
@endsection

@section('body')
	<div id="product">
		<div id="list-wrapper">
			<h1>PRODUCTS</h1>
				<img id="left" class="scrolingSlide" src="{{ asset('amadeo/images-base/chevron-left.png') }}">
				<img id="right" class="scrolingSlide" src="{{ asset('amadeo/images-base/chevron-right.png') }}">
			<div id="list">
				@php ($countQue = 0)
				@foreach($product as $key)
				@if(isset($slug))
						@if($key->category == $slugId->id)
						<div class="product-select midle" data-name="{{ $key->name }}" data-img="{{ asset('amadeo/images/'.$key->picture) }}" data-bg="{{ asset('amadeo/images/'.$key->background_picture) }}" data-desc="{{ $key->descript }}" data-website="{{ $key->website }}" data-slug="{{ $key->slug }}" data-category="{{ $key->category }}" data-que="{{ $countQue++ }}" data-titleimg="{{ $key->title_picture != '' ? asset('amadeo/images/'.$key->title_picture) : '' }}" >
							<div id="">
								<img src="{{ asset('amadeo/images/'.$key->picture) }}" style="position:relative;height: 70px;left: 0px;">
								<p>{{ $key->name }}</p>
							</div>
						</div>
						@endif
				@else
						<div class="product-select midle" data-name="{{ $key->name }}" data-img="{{ asset('amadeo/images/'.$key->picture) }}" data-bg="{{ asset('amadeo/images/'.$key->background_picture) }}" data-desc="{{ $key->descript }}" data-website="{{ $key->website }}" data-slug="{{ $key->slug }}" data-category="{{ $key->category }}" data-que="{{ $countQue++ }}" data-titleimg="{{ $key->title_picture != '' ? asset('amadeo/images/'.$key->title_picture) : '' }}" >
							<div id="">
								<img src="{{ asset('amadeo/images/'.$key->picture) }}" style="position:relative;height: 70px;left: 0px;">
								<p>{{ $key->name }}</p>
							</div>
						</div>
				@endif
				@endforeach
			</div>
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
@endsection

@section('script')
	<script type="text/javascript" src="{{ asset('amadeo/js/product-select.js') }}"></script>
	@if(isset($subslug))
		<script type="text/javascript">
			$(".product-select.midle[data-slug='{{ $subslug }}']").addClass("active");
			var Name = $(".product-select.midle[data-slug='{{ $subslug }}']").data('name');
		    var Desc = $(".product-select.midle[data-slug='{{ $subslug }}']").data('desc');
		    var Img  = $(".product-select.midle[data-slug='{{ $subslug }}']").data('img');
		    var Website  = $(".product-select.midle[data-slug='{{ $subslug }}']").data('website');
		    var Background  = $(".product-select.midle[data-slug='{{ $subslug }}']").data('bg');
		    var TitleImg  = $(".product-select.midle[data-slug='{{ $subslug }}']").data('titleimg');


			var lastQue = $( ".product-select.midle:last-child" ).data("que")-4;
		    var Que  = $(".product-select.midle[data-slug='{{ $subslug }}']").data('que');
			var scroll = 0;
			var animateScroll = 0;

		    if (Que >= lastQue) {
		    	Que = lastQue;
		    }

		    if($(window).width() > 960){
				animateScroll += 220;
			}
			else{
				animateScroll += 220;
			}
			scroll = animateScroll * Que;
		    $('#product #list-wrapper #list').animate({scrollLeft: scroll}, 200);

		    if(TitleImg == ""){
				$('h1#product-name').text(Name);
			}
			else{
				$('h1#product-name').html('<img style="position:relative;height: 70px;" src="'+TitleImg+'"/>');
			}
			
			$('p#product-desc').text(Desc);
			$('img#product-img').attr('src', Img);
			$('div#discrip-wrapper.product-background-picture').css('background-image', 'url(' + Background + ')');
			if(Website == ""){
				$('div#website-link.product-website-link').addClass('load-data');
			}
			else{
				$('div#website-link.product-website-link a.buton-style').attr('href', Website);
			}
		</script>
	@else
		<script type="text/javascript">
			$(".product-select.midle:first").addClass("active");
			var Name = $(".product-select.midle:first").data('name');
		    var Desc = $(".product-select.midle:first").data('desc');
		    var Img  = $(".product-select.midle:first").data('img');
		    var Website  = $(".product-select.midle:first").data('website');
		    var Background  = $(".product-select.midle:first").data('bg');
		    var TitleImg  = $(".product-select.midle:first").data('titleimg');


		    if(TitleImg == ""){
				$('h1#product-name').text(Name);
			}
			else{
				$('h1#product-name').html('<img style="position:relative;height: 70px;left: 0px;" src="'+TitleImg+'"/>');
			}

			$('p#product-desc').text(Desc);
			$('img#product-img').attr('src', Img);
			$('div#discrip-wrapper.product-background-picture').css('background-image', 'url(' + Background + ')');
			if(Website == ""){
				$('div#website-link.product-website-link').addClass('load-data');
			}
			else{
				$('div#website-link.product-website-link a.buton-style').attr('href', Website);
			}
		</script>
	@endif
	<script type="text/javascript">
		window.setTimeout(function() {
			if(typeof(Que) != "undefined" && Que !== null){
				var clickQue = Que;
			}
			else{
				var clickQue = 0;	
			}
			var lastQue = $( ".product-select.midle:last-child" ).data("que") - 4;
			var animateScroll = 0;
			var scroll = 0;
			
			if($(window).width() > 960){
				animateScroll += 220;
			}
			else{
				animateScroll += 220;
			}

			$('img#left.scrolingSlide').click(function() {
				clickQue -= 1;
				if (clickQue <= 0) {
					clickQue = 0;
				}
				scroll = animateScroll * clickQue;
				$('#product #list-wrapper #list').animate({scrollLeft: scroll}, 200);
			});
			$('img#right.scrolingSlide').click(function() {
				clickQue += 1;
				if (clickQue >= lastQue) {
					clickQue = lastQue;
				}
				scroll = animateScroll * clickQue;
				$('#product #list-wrapper #list').animate({scrollLeft: scroll}, 200);
			});

		}, 100);
	</script>
@endsection
