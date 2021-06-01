@extends('frontend.layouts.master')

@section('meta')
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name='copyright' content=''>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="keywords" content="online shop, purchase, cart, ecommerce site, best online shopping">
	<meta name="description" content="{{$materiel_detail->summary}}">
	<meta property="og:url" content="{{route('materiel-detail',$materiel_detail->slug)}}">
	<meta property="og:type" content="article">
	<meta property="og:title" content="{{$materiel_detail->title}}">
	<meta property="og:image" content="{{$materiel_detail->photo}}">
	<meta property="og:description" content="{{$materiel_detail->description}}">
@endsection
@section('title','EDM-Medical || MATERIEL DETAILS')
@section('main-content')

		<!-- Breadcrumbs -->
		<div class="breadcrumbs">
			<div class="container">
				<div class="row">
					<div class="col-12">
						<div class="bread-inner">
							<ul class="bread-list">
								<li><a href="{{route('home')}}">Accueil<i class="ti-arrow-right"></i></a></li>
								<li class="active"><a href="">MATERIEL DETAILS</a></li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- End Breadcrumbs -->

		<!-- Shop Single -->
		<section class="shop single section">
					<div class="container">
						<div class="row">
							<div class="col-12">
								<div class="row">
									<div class="col-lg-6 col-12">
										<!-- Materiel Slider -->
										<div class="materiel-gallery">
											<!-- Images slider -->
											<div class="flexslider-thumbnails">
												<ul class="slides">
													@php
														$photo=explode(',',$materiel_detail->photo);
													// dd($photo);
													@endphp
													@foreach($photo as $data)
														<li data-thumb="{{$data}}" rel="adjustX:10, adjustY:">
															<img src="..\backend\img\materiels\{{$data}}" alt="..\backend\img\materiels\{{$data}}">
														</li>
													@endforeach
												</ul>
											</div>
											<!-- End Images slider -->
										</div>
										<!-- End Materiel slider -->
									</div>
									<div class="col-lg-6 col-12">
										<div class="materiel-des">
											<!-- Description -->
											<div class="short">
												<h4>{{$materiel_detail->title}}</h4>
												<div class="rating-main">
													<ul class="rating">
														@php
															$rate=ceil($materiel_detail->getReview->avg('rate'))
														@endphp
															@for($i=1; $i<=5; $i++)
																@if($rate>=$i)
																	<li><i class="fa fa-star"></i></li>
																@else
																	<li><i class="fa fa-star-o"></i></li>
																@endif
															@endfor
													</ul>
													<a href="#" class="total-review">({{$materiel_detail['getReview']->count()}}) Review</a>
                                                </div>
                                                @php
                                                    $after_discount=($materiel_detail->price-(($materiel_detail->price*$materiel_detail->discount)/100));
                                                @endphp
												<p class="price"><span class="discount">{{number_format($after_discount,2)}}Dhs </span><s>{{number_format($materiel_detail->price,2)}} Dhs</s> </p>
												<p class="description">{!!($materiel_detail->summary)!!}</p>
											</div>
											<!--/ End Description -->
											<!-- Color -->
										
											<!--/ End Color -->
											<!-- Materiel Buy -->
											<div class="materiel-buy">
												<form action="{{route('single-add-to-cart')}}" method="POST"  name="form1"  >
													@csrf
													<div class="quantity">
														<h6>Quantité :</h6>
														<!-- Input Order -->
														<div class="input-group">
															<div class="button minus">
																<button type="button" class="btn btn-primary btn-number" disabled="disabled" data-type="minus" data-field="quant[1]">
																	<i class="ti-minus"></i>
																</button>
															</div>
															<input type="hidden" name="slug" value="{{$materiel_detail->slug}}">
															<input type="text" name="quant[1]" class="input-number"  data-min="1" data-max="1000" value="1" id="quantity" onblur="document.form2.input.value = this.value;">
															<div class="button plus">
																<button type="button" class="btn btn-primary btn-number" data-type="plus" data-field="quant[1]">
																	<i class="ti-plus"></i>
																</button>
															</div>
														</div>
													<!--/ End Input Order -->
													</div>
													<div class="add-to-cart mt-4">
														<button type="submit"  class="btn">Ajouter au panier</button>
														<a href="{{route('add-to-wishlist',$materiel_detail->slug)}}" class="btn min"><i class="ti-heart"></i></a>
													</div>
												</form>

													@php
														$id =  $materiel_detail->id;
														$test='test';
														@endphp
                                                {{-- start form de location--}}
                                                <form name="form2" action="{{route('location_form',$id)}}" method="POST">
													@csrf <!-- {{ csrf_field() }} -->
                                                        <div class="location mt-4">

														
														@if($materiel_detail->Location == 1)
														<input type="hidden"  name="quant[1]"  onblur="document.form2.input.value = this.value;" >
														<input type="submit"   value="Location" class="btn" style="background: #8bc34a;color: white;">
														@php
														 $prix = $materiel_detail->prix_location ;
														echo "<p class=\"cat\">  Prix de location par jour : ".  $prix  . " DH" ."</p>";
														@endphp
														
														
														@endif
														
												
                                                     </div>
                                                    </form>
													
                                                {{-- end form de location--}}

												<p class="cat">Categorie :<a href="{{route('materiel-cat',$materiel_detail->cat_info['slug'])}}">{{$materiel_detail->cat_info['title']}}</a></p>
												@if($materiel_detail->sub_cat_info)
												<p class="cat mt-1">Sub Categorie :<a href="{{route('materiel-sub-cat',[$materiel_detail->cat_info['slug'],$materiel_detail->sub_cat_info['slug']])}}">{{$materiel_detail->sub_cat_info['title']}}</a></p>
												@endif
												<p class="availability">Stock : @if($materiel_detail->stock>0)<span class="badge badge-success">{{$materiel_detail->stock}}</span>@else <span class="badge badge-danger">{{$materiel_detail->stock}}</span>  @endif</p>
											</div>
											<!--/ End Materiel Buy -->
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-12">
										<div class="materiel-info">
											<div class="nav-main">
												<!-- Tab Nav -->
												<ul class="nav nav-tabs" id="myTab" role="tablist">
													<li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#description" role="tab">Description</a></li>
													<li class="nav-item"><a class="nav-link" data-toggle="tab" href="#reviews" role="tab">Avis</a></li>
												</ul>
												<!--/ End Tab Nav -->
											</div>
											<div class="tab-content" id="myTabContent">
												<!-- Description Tab -->
												<div class="tab-pane fade show active" id="description" role="tabpanel">
													<div class="tab-single">
														<div class="row">
															<div class="col-12">
																<div class="single-des">
																	<p>{!! ($materiel_detail->description) !!}</p>
																</div>
															</div>
														</div>
													</div>
												</div>
												<!--/ End Description Tab -->
												<!-- Reviews Tab -->
												<div class="tab-pane fade" id="reviews" role="tabpanel">
													<div class="tab-single review-panel">
														<div class="row">
															<div class="col-12">

																<!-- Review -->
																<div class="comment-review">
																	<div class="add-review">
																		<h5>Ajouter un commentaire</h5>
																		<p>Votre adresse email ne sera pas publiée. les champs requis sont indiqués</p>
																	</div>
																	<h4>évaluer <span class="text-danger">*</span></h4>
																	<div class="review-inner">
																			<!-- Form -->
																@auth
																<form class="form" method="post" action="{{route('review.store',$materiel_detail->slug)}}">
                                                                    @csrf
                                                                    <div class="row">
                                                                        <div class="col-lg-12 col-12">
                                                                            <div class="rating_box">
                                                                                  <div class="star-rating">
                                                                                    <div class="star-rating__wrap">
                                                                                      <input class="star-rating__input" id="star-rating-5" type="radio" name="rate" value="5">
                                                                                      <label class="star-rating__ico fa fa-star-o" for="star-rating-5" title="5 out of 5 stars"></label>
                                                                                      <input class="star-rating__input" id="star-rating-4" type="radio" name="rate" value="4">
                                                                                      <label class="star-rating__ico fa fa-star-o" for="star-rating-4" title="4 out of 5 stars"></label>
                                                                                      <input class="star-rating__input" id="star-rating-3" type="radio" name="rate" value="3">
                                                                                      <label class="star-rating__ico fa fa-star-o" for="star-rating-3" title="3 out of 5 stars"></label>
                                                                                      <input class="star-rating__input" id="star-rating-2" type="radio" name="rate" value="2">
                                                                                      <label class="star-rating__ico fa fa-star-o" for="star-rating-2" title="2 out of 5 stars"></label>
                                                                                      <input class="star-rating__input" id="star-rating-1" type="radio" name="rate" value="1">
																					  <label class="star-rating__ico fa fa-star-o" for="star-rating-1" title="1 out of 5 stars"></label>
																					  @error('rate')
																						<span class="text-danger">{{$message}}</span>
																					  @enderror
                                                                                    </div>
                                                                                  </div>
                                                                            </div>
                                                                        </div>
																		<div class="col-lg-12 col-12">
																			<div class="form-group">
																				<label>Écrire une critique</label>
																				<textarea name="review" rows="6" placeholder="" ></textarea>
																			</div>
																		</div>
																		<div class="col-lg-12 col-12">
																			<div class="form-group button5">
																				<button type="submit" class="btn">Submit</button>
																			</div>
																		</div>
																	</div>
																</form>
																@else
																<p class="text-center p-5">
																	Vous avez besoin de  <a href="{{route('login.form')}}" style="color:rgb(54, 54, 204)">Login</a> OR <a style="color:blue" href="{{route('register.form')}}">inscription</a>

																</p>
																<!--/ End Form -->
																@endauth
																	</div>
																</div>

																<div class="ratting-main">
																	<div class="avg-ratting">
																		{{-- @php
																			$rate=0;
																			foreach($materiel_detail->rate as $key=>$rate){
																				$rate +=$rate
																			}
																		@endphp --}}
																		<h4>{{ceil($materiel_detail->getReview->avg('rate'))}} <span>(Overall)</span></h4>
																		<span>Based on {{$materiel_detail->getReview->count()}} Comments</span>
																	</div>
																	@foreach($materiel_detail['getReview'] as $data)
																	<!-- Single Rating -->
																	<div class="single-rating">
																		<div class="rating-author">
																			@if($data->user_info['photo'])
																			<img src="{{$data->user_info['photo']}}" alt="{{$data->user_info['photo']}}">
																			@else
																			<img src="{{asset('backend/img/avatar.png')}}" alt="Profile.jpg">
																			@endif
																		</div>
																		<div class="rating-des">
																			<h6>{{$data->user_info['name']}}</h6>
																			<div class="ratings">

																				<ul class="rating">
																					@for($i=1; $i<=5; $i++)
																						@if($data->rate>=$i)
																							<li><i class="fa fa-star"></i></li>
																						@else
																							<li><i class="fa fa-star-o"></i></li>
																						@endif
																					@endfor
																				</ul>
																				<div class="rate-count">(<span>{{$data->rate}}</span>)</div>
																			</div>
																			<p>{{$data->review}}</p>
																		</div>
																	</div>
																	<!--/ End Single Rating -->
																	@endforeach
																</div>

																<!--/ End Review -->

															</div>
														</div>
													</div>
												</div>
												<!--/ End Reviews Tab -->
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
		</section>
		<!--/ End Shop Single -->

		<!-- Start Most Popular -->
	<div class="materiel-area most-popular related-materiel section">
        <div class="container">
            <div class="row">
				<div class="col-12">
					<div class="section-title">
						<h2>materiel recommandé</h2>
					</div>
				</div>
            </div>
            <div class="row">
                {{-- {{$materiel_detail->rel_prods}} --}}
                <div class="col-12">
                    <div class="owl-carousel popular-slider">
                        @foreach($materiel_detail->rel_prods as $data)
						
                            @if($data->id !==$materiel_detail->id)
                                <!-- Start Single Materiel -->
                                <div class="single-materiel">
                                    <div class="materiel-img">
										<a href="{{route('materiel-detail',$data->slug)}}">
											@php
												$photo=explode(',',$data->photo);
											@endphp
                                            <img class="default-img" src="..\backend\img\materiels\{{$photo[0]}}" alt="..\backend\img\materiels\{{$photo[0]}}">
                                            <img class="hover-img" src="..\backend\img\materiels\{{$photo[0]}}" alt="..\backend\img\materiels\{{$photo[0]}}">
                                            <span class="price-dec">{{$data->discount}} % Off</span>
                                                                    {{-- <span class="out-of-stock">Hot</span> --}}
                                        </a>
                                        <div class="button-head">
                                            <div class="materiel-action">
                                                <a data-toggle="modal" data-target="#modelExample" title="Quick View" href="#"><i class=" ti-eye"></i><span>achat rapide</span></a>
                                                <a title="Wishlist" href="#"><i class=" ti-heart "></i><span>Ajouter à la liste de souhaits</span></a>
                                                <a title="Compare" href="#"><i class="ti-bar-chart-alt"></i><span>ajouter pour comparer</span></a>
                                            </div>
                                            <div class="materiel-action-2">
                                                <a title="Add to cart" href="#">Ajouter au panier</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="materiel-content">
                                        <h3><a href="{{route('materiel-detail',$data->slug)}}">{{$data->title}}</a></h3>
                                        <div class="materiel-price">
                                            @php
                                                $after_discount=($data->price-(($data->discount*$data->price)/100));
                                            @endphp
                                            <span class="old"> {{number_format($data->price,2)}} Dhs</span>
                                            <span> {{number_format($after_discount,2)}} Dhs</span>
                                        </div>

                                    </div>
                                </div>
                                <!-- End Single Materiel -->

                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
	<!-- End Most Popular Area -->


  <!-- Modal -->
  <div class="modal fade" id="modelExample" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span class="ti-close" aria-hidden="true"></span></button>
            </div>
            <div class="modal-body">
                <div class="row no-gutters">
                    <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                        <!-- Materiel Slider -->
                            <div class="materiel-gallery">
                                <div class="quickview-slider-active">
                                    <div class="single-slider">
                                        <img src="images/modal1.png" alt="#">
                                    </div>
                                    <div class="single-slider">
                                        <img src="images/modal2.png" alt="#">
                                    </div>
                                    <div class="single-slider">
                                        <img src="images/modal3.png" alt="#">
                                    </div>
                                    <div class="single-slider">
                                        <img src="images/modal4.png" alt="#">
                                    </div>
                                </div>
                            </div>
                        <!-- End Materiel slider -->
                    </div>
                  
                            <div class="quantity">
                                <!-- Input Order -->
                                <div class="input-group">
                                    <div class="button minus">
                                        <button type="button" class="btn btn-primary btn-number" disabled="disabled" data-type="minus" data-field="quant[1]">
                                            <i class="ti-minus"></i>
                                        </button>
									</div>
                                    <input type="text" name="qty" class="input-number"  data-min="1" data-max="1000" value="1">
                                    <div class="button plus">
                                        <button type="button" class="btn btn-primary btn-number" data-type="plus" data-field="quant[1]">
                                            <i class="ti-plus"></i>
                                        </button>
                                    </div>
                                </div>
                                <!--/ End Input Order -->
                            </div>
                            <div class="add-to-cart">
                                <a href="#" class="btn">Ajouter au panier</a>
                                <a href="#" class="btn min"><i class="ti-heart"></i></a>
                                <a href="#" class="btn min"><i class="fa fa-compress"></i></a>
                            </div>
                            <div class="default-social">
                                <h4 class="share-now">partager:</h4>
                                <ul>
                                    <li><a class="facebook" href="#"><i class="fa fa-facebook"></i></a></li>
                                    <li><a class="twitter" href="#"><i class="fa fa-twitter"></i></a></li>
                                    <li><a class="youtube" href="#"><i class="fa fa-pinterest-p"></i></a></li>
                                    <li><a class="dribbble" href="#"><i class="fa fa-google-plus"></i></a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal end -->

@endsection
@push('styles')
	<style>
		/* Rating */
		.rating_box {
		display: inline-flex;
		}

		.star-rating {
		font-size: 0;
		padding-left: 10px;
		padding-right: 10px;
		}

		.star-rating__wrap {
		display: inline-block;
		font-size: 1rem;
		}

		.star-rating__wrap:after {
		content: "";
		display: table;
		clear: both;
		}

		.star-rating__ico {
		float: right;
		padding-left: 2px;
		cursor: pointer;
		color: #4caf50;
		font-size: 16px;
		margin-top: 5px;
		}

		.star-rating__ico:last-child {
		padding-left: 0;
		}

		.star-rating__input {
		display: none;
		}

		.star-rating__ico:hover:before,
		.star-rating__ico:hover ~ .star-rating__ico:before,
		.star-rating__input:checked ~ .star-rating__ico:before {
		content: "\F005";
		}

	</style>
@endpush
@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

    {{-- <script>
        $('.cart').click(function(){
            var quantity=$('#quantity').val();
            var pro_id=$(this).data('id');
            // alert(quantity);
            $.ajax({
                url:"{{route('add-to-cart')}}",
                type:"POST",
                data:{
                    _token:"{{csrf_token()}}",
                    quantity:quantity,
                    pro_id:pro_id
                },
                success:function(response){
                    console.log(response);
					if(typeof(response)!='object'){
						response=$.parseJSON(response);
					}
					if(response.status){
						swal('success',response.msg,'success').then(function(){
							document.location.href=document.location.href;
						});
					}
					else{
                        swal('error',response.msg,'error').then(function(){
							document.location.href=document.location.href;
						});
                    }
                }
            })
        });
    </script> --}}

@endpush
