<div id="navbar">
	<div id="container">
		<div id="logo" class="bar">
			<div class="valign-midle">
				<img src="{{ asset('amadeo/images/'.$logo->picture) }}">
				<div id="burger-icon">
					<div></div>
					<div></div>
					<div></div>
				</div>
			</div>
		</div>
		<div id="list" class="bar">
			<div class="valign-midle {{ Route::is('frontend.home') ? 'active' : '' }}">
				<a href="{{ route('frontend.home') }}">HOME</a>
			</div>
			<div class="valign-midle {{ Route::is('frontend.about*') ? 'active' : '' }} dropdown">
				<a href="{{ route('frontend.about') }}">ABOUT</a>
				<div id="dropdown-container">
					<div class="list">
						<a href="{{ route('frontend.about') }}#about">About Us</a>
					</div>
					<div class="list">
						<a href="{{ route('frontend.about') }}#facility">Facility</a>
					</div>
					<div class="list">
						<a href="{{ route('frontend.about') }}#vedio">Video</a>
					</div>
				</div>
			</div>
			<div class="valign-midle {{ Route::is('frontend.product*') ? 'active' : '' }} dropdown">
				<a href="{{ route('frontend.product') }}">PRODUCTS</a>
				<div id="dropdown-container">
					{{--
					@foreach($product as $key)
					<div class="list">
						<a href="{{ route('frontend.product.select', ['slug'=>'fress-strip','subslug'=>$key->slug]) }}">{{ $key->name }}</a>
					</div>
					@endforeach
					--}}
					@foreach($ProdukCategory as $keys)
					<div class="list dropright">
						<a href="{{ route('frontend.product.category', ['slug'=>$keys->slug]) }}">
							{{ $keys->name }}
						</a>
						<div id="dropright-container">
							@foreach($product as $key)
							@if($key->category == $keys->id)
							<div class="item">
								<a href="{{ route('frontend.product.select', ['slug'=>$keys->slug,'subslug'=>$key->slug]) }}">{{ $key->name }}</a>
							</div>
							@endif
							@endforeach
						</div>
					</div>
					@endforeach
				</div>
			</div>
			<div class="valign-midle {{ Route::is('frontend.solutions*') ? 'active' : '' }}">
				<a href="{{ route('frontend.solutions') }}">SOLUTIONS</a>
			</div>
			<div class="valign-midle {{ Route::is('frontend.news*') ? 'active' : '' }}">
				<a href="{{ route('frontend.news') }}">NEWS</a>
			</div>
			<div class="valign-midle {{ Route::is('frontend.distribution*') ? 'active' : '' }}">
				<a href="{{ route('frontend.distribution') }}">DISTRIBUTION</a>
			</div>
			<div class="valign-midle {{ Route::is('frontend.contact') ? 'active' : '' }}">
				<a href="{{ route('frontend.contact') }}">CONTACTS</a>
			</div>
			<div class="valign-midle {{ Route::is('frontend.careers') ? 'active' : '' }}">
				<a href="{{ route('frontend.careers') }}">CAREERS</a>
			</div>
		</div>
		<div class="clearfix"></div>
	</div>
</div>