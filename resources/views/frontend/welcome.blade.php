@extends('layouts.default')

@section('title', 'Welcome')

@section('content')
<div class="container-fluid home-feature">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<h1>{{ config('custome.name') }}</h1>
				<p>{{ config('custome.subtitle') }}</p>
				<a href="#{{ config('custome.name') }}" class="btn btn-default btn-cta">{{ config('custome.name') }}</a>
			</div>
		</div>
	</div>
</div>

	<div class="container-fluid home-categories">
		<div class="col-md-4 home-box">
			<img src="" alt="">
			<div class="home-box-content">
				<h2>Track Health</h2>
				<p>All the fitness trackers</p>
				<a href="/category/#1" class="btn btn-default">Shop #1</a>
			</div>
		</div>
		<div class="col-md-4 home-box">
			<img src="" alt="">
			<div class="home-box-content">
				<h2>Save Time</h2>
				<p>Tech for the fast-paced life</p>
				<a href="/category/#2" class="btn btn-default">Shop #2</a>
			</div>
		</div>
		<div class="col-md-4 home-box">
			<img src="" alt="">
			<div class="home-box-content">
				<h2>Home Care</h2>
				<p>Comfort your life at home</p>
				<a href="/category/#3" class="btn btn-default">Shop #3</a>
			</div>
		</div>
	</div>

<div class="container-fluid home-features">
	<div class="container">
		<h2 class="text-center">Latest Products</h2>
		
			@foreach($products as $p)
				<div class="col-md-3 col-xs-12 grid-item text-center">
					<a href="/product/{{ $p->slug }}">
					@php
					$images = json_decode($p->images,true);
					@endphp
						<img src="{{ $images[0] }}" alt="">
						<h1>{{ $p->name }}</h1>
						<p>{{ $p->price }}
							@if($p->is_discount)
							| <span class="full-price">{{ $p->price }}
							</span>
							@endif</p>
					</a>
					<div class="product-button">
						<a href="/product/{{ $p->slug }}" class="btn btn-default">
							View
						</a>
					</div>
				</div>
			@endforeach

	</div>
</div>

<div class="container-fluid home-features">
	<div class="container">
		<h2 class="text-center">Monthly Features</h2>
		@foreach($products as $p)
       			<div class="col-md-3 col-xs-12 grid-item text-center">
					<a href="/product/{{ $p->slug }}">
					@php
					$images = json_decode($p->images,true);
					@endphp
						<img src="{{ $images[0] }}" alt="{{ $p->name }}">
						<h1>{{ $p->name }}</h1>
						<p>{{ $p->price }}
							@if($p->is_discount)
							| <span class="full-price">{{ $p->price }}
							</span>
							@endif</p>
					</a>
					<div class="product-button">
						<a href="/product/{{ $p->slug }}" class="btn btn-default">
							View
						</a>
					</div>
				</div>
  		@endforeach
	</div>
</div>
@endsection