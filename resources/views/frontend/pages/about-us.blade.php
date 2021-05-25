@extends('frontend.layouts.master')

@section('title','EDM-Medical || A propos de nous')

@section('main-content')

	<!-- Breadcrumbs -->
	<div class="breadcrumbs">
		<div class="container">
			<div class="row">
				<div class="col-12">
					<div class="bread-inner">
						<ul class="bread-list">
							<li><a href="index1.html">Accueil<i class="ti-arrow-right"></i></a></li>
							<li class="active"><a href="blog-single.html">A propos de nous</a></li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- End Breadcrumbs -->
	
	<!-- A propos de nous -->
	<section class="about-us section">
			<div class="container">
				<div class="row">
					<div class="col-lg-6 col-12">
						<div class="about-content">
							@php
								$settings=DB::table('settings')->get();
							@endphp
							<h3>Welcome To <span>EDM Medical</span></h3>
							<p>@foreach($settings as $data) {{$data->description}} @endforeach</p>
							<div class="button">
								<a href="{{route('blog')}}" class="btn">Notre blog</a>
								<a href="{{route('contact')}}" class="btn primary">Nous contacter</a>
							</div>
						</div>
					</div>
					<div class="col-lg-6 col-12">
						<div class="about-img overlay">
						
							<img src="frontend\img\logo.png">
						</div>
					</div>
				</div>
			</div>
	</section>
	<!-- End A propos de nous -->
	

	
	<!-- Start Shop Services Area -->
	<section class="shop-services section">
		<div class="container">
			<div class="row">
				<div class="col-lg-3 col-md-6 col-12">
					<!-- Start Single Service -->
					<div class="single-service">
						<i class="ti-rocket"></i>
						<h4>LIVRAISON RAPIDE</h4>
						<p>100%</p>
					</div>
					<!-- End Single Service -->
				</div>
				<div class="col-lg-3 col-md-6 col-12">
					<!-- Start Single Service -->
					<div class="single-service">
						<i class="ti-reload"></i>
						<h4>RETOUR GRATUIT</h4>
						<p>Retour dans les 30 jours</p>
					</div>
					<!-- End Single Service -->
				</div>
				<div class="col-lg-3 col-md-6 col-12">
					<!-- Start Single Service -->
					<div class="single-service">
						<i class="ti-lock"></i>
						<h4>PAIEMENT SÉCURISÉ</h4>
						<p>Paiement 100% sécurisé</p>
					</div>
					<!-- End Single Service -->
				</div>
				<div class="col-lg-3 col-md-6 col-12">
					<!-- Start Single Service -->
					<div class="single-service">
						<i class="ti-tag"></i>
						<h4>MEILLEUR PRIX</h4>
						<p>Prix garanti</p>
					</div>
					<!-- End Single Service -->
				</div>
			</div>
		</div>
	</section>
	<!-- End Shop Services Area -->
	
	@include('frontend.layouts.newsletter')
@endsection