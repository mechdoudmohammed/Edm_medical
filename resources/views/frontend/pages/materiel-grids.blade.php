@extends('frontend.layouts.master')

@section('title','EDM-Medical || MATERIEL PAGE')

@section('main-content')
	<!-- Breadcrumbs -->
    <div class="breadcrumbs">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="bread-inner">
                        <ul class="bread-list">
                            <li><a href="index1.html">Acceuil<i class="ti-arrow-right"></i></a></li>
                            <li class="active"><a href="blog-single.html">Filtre</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Breadcrumbs -->

    <!-- Materiel Style -->
    <form action="{{route('shop.filter')}}" method="POST">
        @csrf
        <section class="materiel-area shop-sidebar shop section">
            <div class="container">
                <div class="row">
                    <div class="col-lg-3 col-md-4 col-12">
                        <div class="shop-sidebar">
                                <!-- Single Widget -->
                                <div class="single-widget categorie">
                                    <h3 class="title">Categories</h3>
                                    <ul class="categor-list">
										@php
											// $categorie = new Categorie();
											$menu=App\Models\Categorie::getAllParentWithChild();
										@endphp
										@if($menu)
										<li>
											@foreach($menu as $cat_info)
													@if($cat_info->child_cat->count()>0)
														<li><a href="{{route('materiel-cat',$cat_info->slug)}}">{{$cat_info->title}}</a>
															<ul>
																@foreach($cat_info->child_cat as $sub_menu)
																	<li><a href="{{route('materiel-sub-cat',[$cat_info->slug,$sub_menu->slug])}}">{{$sub_menu->title}}</a></li>
																@endforeach
															</ul>
														</li>
													@else
														<li><a href="{{route('materiel-cat',$cat_info->slug)}}">{{$cat_info->title}}</a></li>
													@endif
											@endforeach
										</li>
										@endif
                                        {{-- @foreach(Helper::materielCategoryList('materiels') as $cat)
                                            @if($cat->is_parent==1)
												<li><a href="{{route('materiel-cat',$cat->slug)}}">{{$cat->title}}</a></li>
											@endif
                                        @endforeach --}}
                                    </ul>
                                </div>
                                <!--/ End Single Widget -->
                                <!-- Shop By Price -->
                                    <div class="single-widget range">
                                        <h3 class="title">Acheter par </h3>
                                        <div class="price-filter">
                                            <div class="price-filter-inner">
                                                @php
                                                    $max=DB::table('materiels')->max('price');
                                                    // dd($max);
                                                @endphp
                                                <div id="slider-range" data-min="0" data-max="{{$max}}"></div>
                                                <div class="materiel_filter">
                                                <button type="submit" class="filter_button">Filtrer</button>
                                                <div class="label-input">
                                                    <span>Marge:</span>
                                                    <input style="" type="text" id="amount" readonly/>
                                                    <input type="hidden" name="price_range" id="price_range" value="@if(!empty($_GET['price'])){{$_GET['price']}}@endif"/>
                                                </div>
                                                </div>
                                            </div>
                                        </div>
                                        {{-- <ul class="check-box-list">
                                            <li>
                                                <label class="checkbox-inline" for="1"><input name="news" id="1" type="checkbox">$20 - $50<span class="count">(3)</span></label>
                                            </li>
                                            <li>
                                                <label class="checkbox-inline" for="2"><input name="news" id="2" type="checkbox">$50 - $100<span class="count">(5)</span></label>
                                            </li>
                                            <li>
                                                <label class="checkbox-inline" for="3"><input name="news" id="3" type="checkbox">$100 - $250<span class="count">(8)</span></label>
                                            </li>
                                        </ul> --}}
                                    </div>
                                    <!--/ End Shop By Price -->
                                <!-- Single Widget -->
                                <div class="single-widget recent-post">
                                    <h3 class="title">Nouveau poste</h3>
                                    {{-- {{dd($recent_materiels)}} --}}
                                    @foreach($recent_materiels as $materiel)
                                        <!-- Single Post -->
                                        @php
                                            $photo=explode(',',$materiel->photo);
                                        @endphp
                                        <div class="single-post first">
                                            <div class="image">
                                                <img src="backend\img\materiels\{{$photo[0]}}" alt="backend\img\materiels\{{$photo[0]}}">
                                            </div>
                                            <div class="content">
                                                <h5><a href="{{route('materiel-detail',$materiel->slug)}}">{{$materiel->nom}}</a></h5>
                                                @php
                                                    $org=($materiel->price-($materiel->price*$materiel->discount)/100);
                                                @endphp
                                                <p class="price"><del class="text-muted">{{number_format($materiel->price,2)}} Dhs</del>   {{number_format($org,2)}} Dhs  </p>

                                            </div>
                                        </div>
                                        <!-- End Single Post -->
                                    @endforeach
                                </div>
                                <!--/ End Single Widget -->
                                <!-- Single Widget -->
                                <div class="single-widget categorie">
                                    <h3 class="title">Fournisseurs</h3>
                                    <ul class="categor-list">
                                        @php
                                            $fournisseurs=DB::table('fournisseurs')->orderBy('nom','ASC')->where('status','active')->get();
                                        @endphp
                                        @foreach($fournisseurs as $fournisseur)
                                            <li><a href="{{route('materiel-fournisseur',$fournisseur->nom)}}">{{$fournisseur->nom}}</a></li>
                                        @endforeach
                                    </ul>
                                </div>
                                <!--/ End Single Widget -->
                        </div>
                    </div>
                    <div class="col-lg-9 col-md-8 col-12">
                        <div class="row">
                            <div class="col-12">
                                <!-- Shop Top -->
                                <div class="shop-top">
                                    <div class="shop-shorter">
                                        <div class="single-shorter">
                                            <label>Afficher :</label>
                                            <select class="show" name="show" onchange="this.form.submit();">
                                                <option value="">par defaut</option>
                                                <option value="9" @if(!empty($_GET['show']) && $_GET['show']=='9') selected @endif>09</option>
                                                <option value="15" @if(!empty($_GET['show']) && $_GET['show']=='15') selected @endif>15</option>
                                                <option value="21" @if(!empty($_GET['show']) && $_GET['show']=='21') selected @endif>21</option>
                                                <option value="30" @if(!empty($_GET['show']) && $_GET['show']=='30') selected @endif>30</option>
                                            </select>
                                        </div>
                                        <div class="single-shorter">
                                            <label>Filtrer par :</label>
                                            <select class='sortBy' name='sortBy' onchange="this.form.submit();">
                                                <option value="">par defaut</option>
                                                <option value="title" @if(!empty($_GET['sortBy']) && $_GET['sortBy']=='title') selected @endif>Nom</option>
                                                <option value="price" @if(!empty($_GET['sortBy']) && $_GET['sortBy']=='price') selected @endif>Prix</option>
                                                <option value="categorie" @if(!empty($_GET['sortBy']) && $_GET['sortBy']=='categorie') selected @endif>Categorie</option>
                                                <option value="fournisseur" @if(!empty($_GET['sortBy']) && $_GET['sortBy']=='fournisseur') selected @endif>Fournisseur</option>
                                            </select>
                                        </div>
                                    </div>
                                    <ul class="view-mode">
                                        <li class="active"><a href="javascript:void(0)"><i class="fa fa-th-large"></i></a></li>
                                        <li><a href="{{route('materiel-lists')}}"><i class="fa fa-th-list"></i></a></li>
                                    </ul>
                                </div>
                                <!--/ End Shop Top -->
                            </div>
                        </div>
                        <div class="row">
                            {{-- {{$materiels}} --}}
                            @if(count($materiels)>0)
                                @foreach($materiels as $materiel)
                                    <div class="col-lg-4 col-md-6 col-12">
                                        <div class="single-materiel">
                                            <div class="materiel-img">
                                                <a href="{{route('materiel-detail',$materiel->slug)}}">
                                                    @php
                                                        $photo=explode(',',$materiel->photo);
                                                    @endphp
                                                    <img class="default-img" src="backend\img\materiels\{{$photo[0]}}" alt="backend\img\materiels\{{$photo[0]}}">
                                                    <img class="hover-img" src="backend\img\materiels\{{$photo[0]}}" alt="backend\img\materiels\{{$photo[0]}}">
                                                    @if($materiel->discount)
                                                                <span class="price-dec">{{$materiel->discount}} % Off</span>
                                                    @endif
                                                </a>
                                                <div class="button-head">
                                                    <div class="materiel-action">
                                                        <a data-toggle="modal" data-target="#{{$materiel->id}}" title="Quick View" href="#"><i class=" ti-eye"></i><span>achat rapide</span></a>
                                                        <a title="Wishlist" href="{{route('add-to-wishlist',$materiel->slug)}}" class="wishlist" data-id="{{$materiel->id}}"><i class=" ti-heart "></i><span>Add to Wishlist</span></a>
                                                    </div>
                                                    <div class="materiel-action-2">
                                                        <a title="Add to cart" href="{{route('add-to-cart',$materiel->slug)}}">Ajouter au panier</a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="materiel-content">
                                                <h3><a href="{{route('materiel-detail',$materiel->slug)}}">{{$materiel->nom}}</a></h3>
                                                @php
                                                    $after_discount=($materiel->price-($materiel->price*$materiel->discount)/100);
                                                @endphp
                                                <span>{{number_format($after_discount,2)}} Dhs</span>
                                                <del style="padding-left:4%;">{{number_format($materiel->price,2)}} Dhs</del>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                    <h4 class="text-warning" style="margin:100px auto;">Materiel indisponile</h4>
                            @endif



                        </div>
                        <div class="row">
                            <div class="col-md-12 justify-content-center d-flex">
                                {{$materiels->appends($_GET)->links()}}
                            </div>
                          </div>

                    </div>
                </div>
            </div>
        </section>
    </form>

    <!--/ End Materiel Style 1  -->



 

@endsection
@push('styles')
<style>
    .pagination{
        display:inline-flex;
    }
    .filter_button{
        /* height:20px; */
        text-align: center;
        background:#4caf50;
        padding:8px 16px;
        margin-top:10px;
        color: white;
    }
</style>
@endpush
@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    {{-- <script>
        $('.cart').click(function(){
            var quantity=1;
            var pro_id=$(this).data('id');
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
							// document.location.href=document.location.href;
						});
                    }
                }
            })
        });
    </script> --}}
    <script>
        $(document).ready(function(){
        /*----------------------------------------------------*/
        /*  Jquery Ui slider js
        /*----------------------------------------------------*/
        if ($("#slider-range").length > 0) {
            const max_value = parseInt( $("#slider-range").data('max') ) || 500;
            const min_value = parseInt($("#slider-range").data('min')) || 0;
            const currency = $("#slider-range").data('currency') || '';
            let price_range = min_value+'-'+max_value;
            if($("#price_range").length > 0 && $("#price_range").val()){
                price_range = $("#price_range").val().trim();
            }

            let price = price_range.split('-');
            $("#slider-range").slider({
                range: true,
                min: min_value,
                max: max_value,
                values: price,
                slide: function (event, ui) {
                    $("#amount").val(currency + ui.values[0] + " -  "+currency+ ui.values[1]);
                    $("#price_range").val(ui.values[0] + "-" + ui.values[1]);
                }
            });
            }
        if ($("#amount").length > 0) {
            const m_currency = $("#slider-range").data('currency') || '';
            $("#amount").val(m_currency + $("#slider-range").slider("values", 0) +
                "  -  "+m_currency + $("#slider-range").slider("values", 1));
            }
        })
    </script>
@endpush
