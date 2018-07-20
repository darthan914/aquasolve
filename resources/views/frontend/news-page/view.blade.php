@extends('frontend._layout.basic')

@section('title')
	<title>{{ $name->title }} | {{$News->name}} | News</title>
@endsection

@section('meta')
	<meta name="title" content="{{ $name->title }} | {{$News->name}}">

	<meta name="description" content="{{ $name->title }} | {{ strip_tags(Illuminate\Support\Str::words($News->descript, 35)) }}">
	
	<meta itemprop="thumbnailUrl" content="{{ asset('amadeo/images/'.$News->picture) }}"/>
	<meta itemprop="image" content="{{ asset('amadeo/images/'.$News->picture) }}" />

	<meta property="og:type" content="News" />
	<meta property="og:site_name" content="aquasolve.co.id">
	<meta property="og:title" content="{{ $News->name }}">
	<meta property="og:url" content="{{ route('frontend.news.view', ['slug'=>$News->slug]) }}">
	<meta property="og:description" content="{{ strip_tags(Illuminate\Support\Str::words($News->descript, 35)) }}">
	<meta property="og:image" content="{{ asset('amadeo/images/'.$News->picture) }}">
@endsection

@section('style')
	<style type="text/css">
		#navbar{
			background-color: rgb(101,100,106);
		}
		#news{
			position: relative;
			width: 100%;
			padding-top: 100px;
			padding-bottom: 40px;
		}
		#news #wrapper{
			position: relative;
			width: 80%;
			margin: 0 auto;
			color: rgb(48,48,48);
		}
		#news #wrapper #top{
			text-align: center;
		}
		#news #wrapper #top h1{
	        font-family: 'Slabo27px-Regular';
			font-size: 48px;
			margin: 10px 0;
		}
		#news #wrapper #top p{
	        font-family: 'Quicksand Light';
	        margin-top: 0;
	        margin-bottom: 20px;

		}
		#news #wrapper #top #bg-img{
			width: 100%;
			height: 440px;
			margin-bottom: 20px;
			background-repeat: no-repeat;
			background-position: center;
			background-size: cover;
		}
		#news #wrapper #descript{
			position: relative;
			width: 60%;
			margin: 0 auto;
	        font-family: 'Quicksand Regular';
		}
		#news #wrapper #descript p#shareon a{
			text-decoration: none;
		}
		#news #wrapper h2{
			margin-top: 40px;
	        font-size: 32px;
	        font-family: 'Slabo27px-Regular';
	        text-decoration: underline;
	        text-align: center;
		}
		#news #wrapper .item{
			position: relative;
			float: left;
			width: 33.33%;
		}
		#news #wrapper .item #contain{
			padding: 0 20px;
		}
		#news #wrapper .item #contain #img{
			width: 100%;
			height: 200px;
			background-repeat: no-repeat;
			background-position: center;
			background-size: cover;
		}
		#news #wrapper .item #contain h3{
	        font-family: 'Slabo27px-Regular';
		}
		#news #wrapper .item #contain p{
	        font-family: 'Quicksand Regular';
		}
		#news #wrapper .item #contain h3,
		#news #wrapper .item #contain p{
			margin: 5px 0;
			color: rgb(48,48,48);
		}
		/* mobile */
			@media (max-width: 480px) {
				#news #wrapper{
					width: 90%;
				}
				#news #wrapper #top #bg-img{
					height: 300px;
				}
				#news #wrapper #descript{
					width: 90%;
					text-align: justify;
				}
				#news #wrapper .item{
					width: 100%;
				}
			}
		/* mobile */
	</style>
@endsection

@section('body')
	<div id="news">
		<div id="wrapper">
			<div id="top">
				<h1>{{ $News->name }}</h1>
				<p>{{ date("d F Y", strtotime($News->created_at) ) }}</p>
				<div id="bg-img" style="background-image: url('{{ asset('amadeo/images/'.$News->picture) }}');"></div>
			</div>
			<div id="descript">
				{!! $News->descript !!}
				<p>Share On:</p>
				<p id="shareon">
					<a href="{{ Share::load(Request::fullUrl())->facebook() }}" target="_blank">
						<img src="{{ asset('amadeo/images-base/facebook.png') }}">
					</a>
					<a href="{{ Share::load(Request::fullUrl())->twitter() }}" target="_blank">
						<img src="{{ asset('amadeo/images-base/twitter.png') }}">
					</a>
				</p>
			</div>

			<h2>Related News</h2>
			@php($contNews=0)
			@foreach($NewsHot as $list)
			@if($list->slug != $News->slug)
			@php($contNews++)
			<div class="item">
				<div id="contain">
					<a href="{{ route('frontend.news.view', ['slug'=>$list->slug]) }}">
						<div id="img" style="background-image: url('{{ asset('amadeo/images/'.$list->picture) }}');"></div>
					</a>
					<h3>{{ $list->name }}</h3>
					<p>{{ date("d F Y", strtotime($list->created_at) ) }}</p>
				</div>
			</div>
			@endif
			@if($contNews == 6)
				@break
			@endif
			@endforeach
			<div class="clearfix"></div>
		</div>
	</div>
@endsection

@section('script')
	
@endsection
