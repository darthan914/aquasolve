@extends('frontend._layout.basic')

@section('title')
	<title>{{ $name->title }} | Distribution</title>
@endsection

@section('meta')
@endsection

@section('style')
	<link rel="stylesheet" type="text/css" href="{{ asset('amadeo/plugin/owl-carousel/owl.carousel.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('amadeo/plugin/owl-carousel/owl.theme.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('amadeo/plugin/owl-carousel/owl.transitions.css') }}">

	<style type="text/css">
		#navbar{
			background-color: rgb(101,100,106);
		}
		#distribution{
			position: relative;
			width: 100%;
			padding-top: 120px;
			padding-bottom: 40px;

			text-align: center;
		}
		#distribution #wrapper #maps-wrapper{
			position: relative;
		}

		/*for map*/
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
		    opacity: 0;
		    visibility: hidden;
		    box-shadow: 5px 5px #0000002e;
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
		/*end of for map*/

		#overseas{
			background-color: rgb(69,69,71);
			position: relative;

			width: 100%;
		}

		#overseas #wrapper ul{
			margin: 0;
			padding: 0;
		}
		#overseas #wrapper ul li{
			float: left;
			width: 20%;
			margin-bottom: 10px;
			list-style: none;

			text-align: center;
			font-family: 'Quicksand Regular';
			color: white;
		}

		#partner #wrapper{
			text-align: center;
		}
		#partner #wrapper img{
			height: 55px;
		}

		#overseas #wrapper,
		#partner #wrapper{
			position: relative;
			width: 80%;

			margin: 0 auto;
			padding-top: 30px;
			padding-bottom: 30px;
		}

		#wrapper h1{
			font-family: 'Slabo27px-Regular';
			font-size: 42px;
			text-align: center;
			margin: 0 auto;
			margin-bottom: 30px;
		}
		div:nth-child(even) #wrapper h1{
			color: rgb(69,69,71);
		}
		div:nth-child(odd) #wrapper h1{
			color: rgb(255,255,255);
		}

		@media (max-width: 480px) {
			#overseas #wrapper ul li{
				width: 50%;
			}
			#partner #wrapper img{
				height: auto;
				width: 75%;
				margin: 0 auto;
			}
		}
	</style>
@endsection

@section('body')
	<div id="distribution">
		<div id="wrapper">
			<h1>DISRIBUTION</h1>
			<div id="maps-wrapper">
				<div id="map" class="map-relative">
					<img src="{{ asset('amadeo/images/'.$distribution->picture) }}">
					@foreach($Overseas as $list)
					<div class="pin-marker" style="left: {{$list->css_left}}%; bottom: {{$list->css_bottom}}%;">
						<img src="{{ asset('amadeo/images-base/pin-loc.png') }}">
						<div class="pin-description @if($list->css_left > 50) right @endif @if($list->css_bottom < 50) bottom @endif">
							<p>{{$list->name}}</p>
						</div>
					</div>
					@endforeach
				</div>
			</div>
		</div>

	</div>

	<div id="overseas">
		<div id="wrapper">
			<h1>OVERSEAS</h1>
			<ul>
				@foreach($Overseas as $list)
				<li>{{$list->name}}</li>
				@endforeach
				<div class="clearfix"></div>
			</ul>
		</div>
	</div>

	<div id="partner">
		<div id="wrapper">
			<h1>OUR PARTNER</h1>
			<div id="owl">
				@foreach($Partner as $list)
				<div class="item">
					<a href="{{ $list->link_url }}" target="_blank">
						<img src="{{ asset('amadeo/images/partner/'.$list->img_url) }}" alt="{{ $list->img_alt }}">
					</a>
				</div>
				@endforeach
			</div>
		</div>
	</div>


@endsection

@section('script')
	<script type="text/javascript" src="{{ asset('amadeo/plugin/owl-carousel/owl.carousel.min.js') }}"></script>
	<script type="text/javascript">
		$("#owl").owlCarousel({
			navigation : false,
			items: 4,
			singleItem:false,
			pagination:false,
			autoPlay: 5000,
		    stopOnHover:true
		});
	</script>
@endsection
