@extends('frontend._layout.basic')

@section('title')
	<title>{{ $name->title }} | Solutions</title>
@endsection

@section('meta')
@endsection

@section('style')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/baguettebox.js/1.8.1/baguetteBox.min.css">

	<style type="text/css">
		#navbar{
			background-color: rgb(101,100,106);
		}
		#solutions{
			position: relative;
			width: 100%;
			padding-top: 120px;
			padding-bottom: 40px;
		}
		#solutions #wrapper{
			position: relative;
			width: 60%;
			margin: 0 auto;
			color: rgb(48,48,48);
			text-align: center;
		}
		#solutions #wrapper h1,
		#solutions #wrapper h2{
	        font-family: 'Slabo27px-Regular';
			margin: 0;
		}
		#solutions #wrapper p{
			margin-top: 40px;
			margin-bottom: 40px;
	        font-family: 'Quicksand Regular';
			line-height: 1.4;
		}
		#solutions #wrapper a{
			text-decoration: none;
		}
		#solutions #wrapper img{
			padding: 2.5%;
			width: 40%;
			margin: 0 auto;
			display: inline-grid;
		}
		/* mobile */
			@media (max-width: 480px) {
				#solutions #wrapper{
					width: 90%;
				}
			}
		/* mobile */
	</style>
@endsection

@section('body')
	<div id="solutions">
		<div id="wrapper">
			<h1>{{ $solutions->title }}</h1>
			{!! $solutions->content !!}
			@foreach($SolutionsCategory as $listCat)
			<div id="sample-{{str_slug($listCat->name)}}">
				<h2 style="text-transform: uppercase;">SAMPLES {{ $listCat->name }}</h2>
				<div id="list">
					@foreach($SolutionsImg as $list)
					@if($list->category == $listCat->id)
					<a href="#">
						<img src="{{ asset('amadeo/images/'.$list->picture) }}">
					</a>
					@endif
					@endforeach
				</div>
			</div>
			@endforeach
		</div>
	</div>
@endsection

@section('script')
	<script src="https://cdnjs.cloudflare.com/ajax/libs/baguettebox.js/1.8.1/baguetteBox.min.js"></script>
	<script type="text/javascript">
		baguetteBox.run('#list');
	</script>
@endsection
