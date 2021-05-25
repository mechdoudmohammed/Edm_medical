@extends('frontend.layouts.master')
@section('title','panier Page')
@section('main-content')
	<!-- Breadcrumbs -->
	<div class="breadcrumbs">
		<div class="container">
			<div class="row">
				<div class="col-12">
					<div class="bread-inner">
						<ul class="bread-list">
							<li><a href="{{('home')}}">Acceuil<i class="ti-arrow-right"></i></a></li>
							<li class="active"><a href="">Panier</a></li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- End Breadcrumbs -->

	<!-- Shopping Cart -->
	<div class="shopping-cart section">
		<div class="container">
			<div class="row">
				<div class="col-12">
					<!-- Shopping Summery -->
					<table class="table shopping-summery">
						<thead>
							<tr class="main-hading">
								<th>Matériel</th>
								<th>Nom</th>
								<th class="text-center">Prix unitaire</th>
								<th class="text-center">Quantité</th>
								<th class="text-center">Totale</th>
								<th class="text-center"><i class="ti-trash remove-icon"></i></th>
							</tr>
						</thead>
						<tbody id="cart_item_list">
							<form action="{{route('cart.update')}}" method="POST">
								@csrf
								@if(Helper::getAllMaterielFromCart())
									@foreach(Helper::getAllMaterielFromCart() as $key=>$cart)
										<tr>
											@php
											$photo=explode(',',$cart->materiel['photo']);
											@endphp
											<td class="image" data-title="No"><img src="backend\img\materiels\{{$photo[0]}}" alt="{{$photo[0]}}"></td>
											<td class="materiel-des" data-title="Description">
												<p class="materiel-name"><a href="{{route('materiel-detail',$cart->materiel['slug'])}}" target="_blank">{{$cart->materiel['title']}}</a></p>
												<p class="materiel-des">{!!($cart['summary']) !!}</p>
											</td>
											<td class="price" data-title="Price"><span>{{number_format($cart['price'],2)}} Dhs </span></td>
											<td class="qty" data-title="Qty"><!-- Input Order -->
												<div class="input-group">
													<div class="button minus">
														<button type="button" class="btn btn-primary btn-number" disabled="disabled" data-type="minus" data-field="quant[{{$key}}]">
															<i class="ti-minus"></i>
														</button>
													</div>
													<input type="text" name="quant[{{$key}}]" class="input-number"  data-min="1" data-max="100" value="{{$cart->quantity}}">
													<input type="hidden" name="qty_id[]" value="{{$cart->id}}">
													<div class="button plus">
														<button type="button" class="btn btn-primary btn-number" data-type="plus" data-field="quant[{{$key}}]">
															<i class="ti-plus"></i>
														</button>
													</div>
												</div>
												<!--/ End Input Order -->
											</td>
											<td class="total-amount cart_single_price" data-title="Total"><span class="money">{{$cart['amount']}} Dhs</span></td>

											<td class="action" data-title="Remove"><a href="{{route('cart-delete',$cart->id)}}"><i class="ti-trash remove-icon"></i></a></td>
										</tr>
									@endforeach
									<track>
										<td></td>
										<td></td>
										<td></td>
										<td></td>
										<td></td>
										<td class="float-right">
											<button class="btn float-right" type="submit">Modifier</button>
										</td>
									</track>
								@else
										<tr>
											<td class="text-center">
												panier non disponible <a href="{{route('materiel-grids')}}" style="color:blue;">Continuer l'achat</a>

											</td>
										</tr>
								@endif

							</form>
						</tbody>
					</table>
					<!--/ End Shopping Summery -->
				</div>
			</div>
			<div class="row">
				<div class="col-12">
					<!-- Total Amount -->
					<div class="total-amount">
						<div class="row">
							<div class="col-lg-8 col-md-5 col-12">
								<div class="left">
									<div class="coupon">
									<form action="{{route('coupon-store')}}" method="POST">
											@csrf
											<input name="code" placeholder="Enter Your Coupon">
											<button class="btn">valider</button>
										</form>
									</div>
									{{-- <div class="checkbox">`
										@php
											$livraison=DB::table('livraisons')->where('status','active')->limit(1)->get();
										@endphp
										<label class="checkbox-inline" for="2"><input name="news" id="2" type="checkbox" onchange="showMe('livraison');"> Livraison</label>
									</div> --}}
								</div>
							</div>
							<div class="col-lg-4 col-md-7 col-12">
								<div class="right">
									<ul>
										<li class="order_subtotal" data-price="{{Helper::totalCartPrice()}}">prix initial<span>{{number_format(Helper::totalCartPrice(),2)}} Dhs </span></li>
										{{-- <div id="livraison" style="display:none;">
											<li class="livraison">
												Livraison {{session('livraison_price')}}
												@if(count(Helper::livraison())>0 && Helper::cartCount()>0)
													<div class="form-select">
														<select name="livraison" class="nice-select">
															<option value="">Select</option>
															@foreach(Helper::livraison() as $livraison)
															<option value="{{$livraison->id}}" class="livraisonOption" data-price="{{$livraison->price}}">{{$livraison->type}}: {{$livraison->price}} Dhs</option>
															@endforeach
														</select>
													</div>
												@else
													<div class="form-select">
														<span>Free</span>
													</div>
												@endif
											</li>
										</div>
										 --}}
										 {{-- {{dd(Session::get('coupon')['value'])}} --}}
										@if(session()->has('coupon'))
										<li class="coupon_price" data-price="{{Session::get('coupon')['value']}}">vous avez Économisez<span>{{number_format(Session::get('coupon')['value'],2)}} Dhs </span></li>
										@endif
										@php
											$total_amount=Helper::totalCartPrice();
											if(session()->has('coupon')){
												$total_amount=$total_amount-Session::get('coupon')['value'];
											}
										@endphp
										@if(session()->has('coupon'))
											<li class="last" id="order_total_price">vous payez<span>{{number_format($total_amount,2)}} Dhs</span></li>
										@else
											<li class="last" id="order_total_price">vous payez<span>{{number_format($total_amount,2)}} Dhs</span></li>
										@endif
									</ul>
									<div class="button5">
										<a href="{{route('checkout')}}" class="btn">Vérifier</a>
										<a href="{{route('materiel-grids')}}" class="btn">Continuer l'achat </a>
									</div>
								</div>
							</div>
						</div>
					</div>
					<!--/ End Total Amount -->
				</div>
			</div>
		</div>
	</div>
	<!--/ End Shopping Cart -->

	<!-- Start Shop Services Area  -->
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
	<!-- End Shop Newsletter -->

	<!-- Start Shop Newsletter  -->
	@include('frontend.layouts.newsletter')
	<!-- End Shop Newsletter -->




@endsection
@push('styles')
	<style>
		li.livraison{
			display: inline-flex;
			width: 100%;
			font-size: 14px;
		}
		li.livraison .input-group-icon {
			width: 100%;
			margin-left: 10px;
		}
		.input-group-icon .icon {
			position: absolute;
			left: 20px;
			top: 0;
			line-height: 40px;
			z-index: 3;
		}
		.form-select {
			height: 30px;
			width: 100%;
		}
		.form-select .nice-select {
			border: none;
			border-radius: 0px;
			height: 40px;
			background: #f6f6f6 !important;
			padding-left: 45px;
			padding-right: 40px;
			width: 100%;
		}
		.list li{
			margin-bottom:0 !important;
		}
		.list li:hover{
			background:#4caf50 !important;
			color:white !important;
		}
		.form-select .nice-select::after {
			top: 14px;
		}
	</style>
@endpush
@push('scripts')
	<script src="{{asset('frontend/js/nice-select/js/jquery.nice-select.min.js')}}"></script>
	<script src="{{ asset('frontend/js/select2/js/select2.min.js') }}"></script>
	<script>
		$(document).ready(function() { $("select.select2").select2(); });
  		$('select.nice-select').niceSelect();
	</script>
	<script>
		$(document).ready(function(){
			$('.livraison select[name=livraison]').change(function(){
				let cost = parseFloat( $(this).find('option:selected').data('price') ) || 0;
				let subtotal = parseFloat( $('.order_subtotal').data('price') );
				let coupon = parseFloat( $('.coupon_price').data('price') ) || 0;
				// alert(coupon);
				$('#order_total_price span').text('$'+(subtotal + cost-coupon).toFixed(2));
			});

		});

	</script>

@endpush
