@extends('frontend._layout.basic')

@section('title')
	<title>{{ $name->title }} | News</title>
@endsection

@section('meta')
@endsection

@section('style')
	<style type="text/css">
		#navbar{
			background-color: rgb(101,100,106);
		}
		#news{
			position: relative;
			width: 100%;
			padding-top: 120px;
			padding-bottom: 40px;
		    min-height: 400px;
		}
		#news #wrapper{
			position: relative;
			width: 80%;
			margin: 0 auto;
		}
		#news #wrapper .bar{
			position: relative;
			float: left;
			width: 50%;
			padding-top: 10px;
			padding-bottom: 10px;
		}
		#news #wrapper .bar #contain{
			position: relative;
			width: 90%;
			margin: 0 auto;
			color: rgb(48,48,48);
		}
		#news #wrapper .bar #contain #bg-img{
			width: 100%;
			height: 280px;
			background-repeat: no-repeat;
			background-position: center;
			background-size: cover;
		}
		#news #wrapper .bar #contain h3{
	        font-family: 'Slabo27px-Regular';
			margin: 10px 0;
		}
		#news #wrapper .bar #contain p{
	        font-family: 'Quicksand Light';
			margin: 0;
		}
		#news #wrapper .bar #contain label{
	        font-family: 'Quicksand Regular';
			display: block;
			margin: 10px 0;
		}
		#news #wrapper .bar #contain label a{
	        font-family: 'Quicksand Bold';
			color: rgb(238,129,13);
			text-decoration: none;
		}
		/* mobile */
			@media (max-width: 480px) {
				#news #wrapper .bar{
					width: 100%;
				}
				#news #wrapper .bar #contain #bg-img{
					height: 160px;
				}
				#news #wrapper .bar #contain label{
					word-wrap: break-word;
				}
			}
		/* mobile */
	</style>
	<style type="text/css">
		/* pagination */
		ul.pagination-custom{
			position: relative;
			margin: 0 auto;
			text-align: center;
		}
		ul.pagination-custom li,
		ul.pagination-custom li.pagination-control{
			margin: 0 5px;
			display: inline;
		}
		ul.pagination-custom li #midle{
			display: table-cell;
			vertical-align: middle;
			height: 60px;
			width: 40px;
			font-size: 1.17em;
	        font-family: 'Quicksand Bold';
	        color: rgb(48,48,48);
	        transition: all .51s;
		}
		ul.pagination-custom li #midle a{
			font-family: 'Quicksand Bold';
	        color: rgb(48,48,48);
	        text-decoration: none;
		}
		ul.pagination-custom li.active #midle,
		ul.pagination-custom li #midle a:hover{
			color: rgb(238,129,13);
		}
		ul.pagination-custom li.pagination-control #midle img{
			position: relative;
			top: 10px;
			width: auto;
			height: 30px;
		}
		/* mobile */
			@media (max-width: 480px) {
				ul.pagination-custom{
					padding: 0;
					margin: 0;
				}
				ul.pagination-custom li #midle{
					width: 20px;
				}
				ul.pagination-custom li.pagination-control #midle img{
					height: 20px;
					top: 5px;
				}
				ul.pagination-custom li.disabled.three-dots,
				ul.pagination-custom li.disabled.three-dots #midle{
					display: block;
					text-align: center;
					height: auto;
					width: 100%;
				}
			}
		/* mobile */
	</style>
@endsection

@section('body')
	<div id="news">
		<div id="wrapper">
			@forelse($News as $list)
			<div class="bar">
				<div id="contain">
					<div id="bg-img" style="background-image: url('{{ asset('amadeo/images/'.$list->picture) }}');"></div>
					<h3>{{ $list->name }}</h3>
					<p>{{ date("d F Y", strtotime($list->created_at) ) }}</p>
					<label>
						{{ Illuminate\Support\Str::words(strip_tags($list->descript), 20, '...') }} <a href="{{ route('frontend.news.view', ['slug'=>$list->slug]) }}">(Read More)</a>
					</label>
				</div>
			</div>
			@empty
				<p style="font-family: 'Quicksand Light';">No News Available</p>
			@endforelse
			<div class="clearfix"></div>

			{{ $News->links('frontend.news-page.paginate') }}

		</div>
	</div>
@endsection

@section('script')
	
@endsection
