<div id="footer">
	<div id="wrapper">
		<div id="main" class="bar">
			<div id="contain">
				<img src="{{ asset('amadeo/images/'.$logo->picture) }}">
				<h2>{{ $name->title }}</h2>
				{!! $address->content !!}
				<p>{{ $phone->title }} {{ $phone->content }}</p>
				<p>{{ $fax->title }} {{ $fax->content }}</p>
				<p>{{ $email->title }} {{ $email->content }}</p>
			</div>
		</div>
		<div id="sub-main" class="bar">
			<div id="contain">
				<h2>NAVIGATION</h2>
				<p>
					<a href="{{ route('frontend.home') }}">
						Home
					</a>
				</p>
				<p>
					<a href="{{ route('frontend.about') }}">
						About
					</a>
				</p>
				<p>
					<a href="{{ route('frontend.product') }}">
						Products
					</a>
				</p>
				<p>
					<a href="{{ route('frontend.solutions') }}">
						Solutions
					</a>
				</p>
				<p>
					<a href="{{ route('frontend.news') }}">
						News
					</a>
				</p>
				<p>
					<a href="{{ route('frontend.distribution') }}">
						Distribution
					</a>
					{{--
					<a href="{{ route('frontend.careers') }}">
						Career
					</a>
					--}}
				</p>
				<p>
					<a href="{{ route('frontend.contact') }}">
						Contact
					</a>
				</p>
			</div>
		</div>
		<div id="sub-main" class="bar">
			<div id="contain">
				<h2>PRODUCTS</h2>
				@foreach($ProdukCategory as $keys)
				@foreach($product as $key)
				@if($key->category == $keys->id)
				<p>
					<a href="{{ route('frontend.product.select', ['slug'=>$keys->slug,'subslug'=>$key->slug]) }}">{{ $key->name }}</a>
				</p>
				@endif
				@endforeach
				@endforeach
			</div>
		</div>
		<div id="sub-main" class="bar">
			<div id="contain">
				<h2>SOLUTIONS</h2>
				<p>
					<a href="{{ route('frontend.solutions') }}">
						{{ $solutions->title }}
					</a>
				</p>
			</div>
		</div>
		<div class="clearfix"></div>
		<div id="copyright">
			<label>© 2018 {{ $name->title }}</label>
			{{--
			<br>
			<label>Web Development By <a href="http://amadeo.id/"><img src="{{ asset('amadeo/images-base/logo-amadeo.png') }}"></a></label>
			--}}
		</div>
	</div>
</div>