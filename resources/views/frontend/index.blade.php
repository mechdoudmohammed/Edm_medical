@extends('frontend.layouts.master')
@section('title','EDM-Medical ||  PAGE accueil')
@section('main-content')
<!-- Slider Area -->

@if(count($banners)>0)
    <section id="Gslider" class="carousel slide" data-ride="carousel">
        <ol class="carousel-indicators">
            @foreach($banners as $key=>$banner)
        <li data-target="#Gslider" data-slide-to="{{$key}}" class="{{(($key==0)? 'active' : '')}}"></li>
            @endforeach

        </ol>
        <div class="carousel-inner" role="listbox">
                @foreach($banners as $key=>$banner)
                <div class="carousel-item {{(($key==0)? 'active' : '')}}">
                    <img class="first-slide" src="backend\img\bannière\{{$banner->photo}}" alt="First slide">
                    <div class="carousel-caption d-none d-md-block text-left">
                                           </div>
                </div>
            @endforeach
        </div>
        <a class="carousel-control-prev" href="#Gslider" role="button" data-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="sr-only">Précedent</span>
        </a>
        <a class="carousel-control-next" href="#Gslider" role="button" data-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="sr-only">Suivant</span>
        </a>
    </section>
@endif

<!--/ End Slider Area -->

<!-- Start Small Banner  -->
<section class="small-banner section">
    <div class="container-fluid">
        <div class="row">
            @php
            $category_lists=DB::table('categories')->where('status','active')->limit(3)->get();
            @endphp
            @if($category_lists)
                @foreach($category_lists as $cat)
                    @if($cat->is_parent==1)
                        <!-- Single Banner  -->
                        <div class="col-lg-4 col-md-6 col-12">
                            <div class="single-banner">
                                @if($cat->photo)
                                    <img src="backend\img\categories\{{$cat->photo}}" alt="backend\img\{{$cat->photo}}">
                                @else
                                    <img src="https://via.placeholder.com/600x370" alt="#">
                                @endif
                                <div class="content">
                                    <h3>{{$cat->title}}</h3>
                                        <a href="{{route('materiel-cat',$cat->slug)}}">Découvrez maintenant</a>
                                </div>
                            </div>
                        </div>
                    @endif
                    <!-- /End Single Banner  -->
                @endforeach
            @endif
        </div>
    </div>
</section>
<!-- End Small Banner -->

<!-- Start Materiel Area -->
<div class="materiel-area section">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="section-title">
                        <h2>Élément tendance</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="materiel-info">
                        <div class="nav-main">
                            <!-- Tab Nav -->
                            <ul class="nav nav-tabs filter-tope-group" id="myTab" role="tablist">
                                @php
                                    $categories=DB::table('categories')->where('status','active')->where('is_parent',1)->get();
                                    // dd($categories);
                                @endphp
                                @if($categories)
                                <button class="btn" style="background:black"data-filter="*">
                                    All Materiels
                                </button>
                                    @foreach($categories as $key=>$cat)

                                    <button class="btn" style="background:none;color:black;"data-filter=".{{$cat->id}}">
                                        {{$cat->title}}
                                    </button>
                                    @endforeach
                                @endif
                            </ul>
                            <!--/ End Tab Nav -->
                        </div>
                        <div class="tab-content isotope-grid" id="myTabContent">
                             <!-- Start Single Tab -->
                            @if($materiel_lists)
                                @foreach($materiel_lists as $key=>$materiel)
                                <div class="col-sm-6 col-md-4 col-lg-3 p-b-35 isotope-item {{$materiel->cat_id}}">
                                    <div class="single-materiel">
                                        <div class="materiel-img">
                                            <a href="{{route('materiel-detail',$materiel->slug)}}">
                                                @php
                                                    $photo=explode(',',$materiel->photo);
                                                // dd($photo);
                                                @endphp
                                                <img class="default-img" src="backend\img\materiels\{{$photo[0]}}" alt="backend\img\materiels\{{$photo[0]}}">
                                                <img class="hover-img" src="backend\img\materiels\{{$photo[0]}}" alt="backend\img\materiels\{{$photo[0]}}">
                                                @if($materiel->stock<=0)
                                                    <span class="out-of-stock">Vente jusqu'à rupture</span>
                                                @elseif($materiel->condition=='new')
                                                    <span class="new">Nouveau</span
                                                @elseif($materiel->condition=='hot')
                                                    <span class="hot">passionné</span>
                                                @else
                                                    <span class="price-dec">{{$materiel->discount}}% Off</span>
                                                @endif


                                            </a>
                                            <div class="button-head">
                                                <div class="materiel-action">
                                                    <a data-toggle="modal" data-target="#{{$materiel->id}}" title="Quick View" href="#"><i class=" ti-eye"></i><span>Achat rapide</span></a>
                                                    <a title="Wishlist" href="{{route('add-to-wishlist',$materiel->slug)}}" ><i class=" ti-heart "></i><span>Ajouter à la liste de souhaits</span></a>
                                                </div>
                                                <div class="materiel-action-2">
                                                    <a title="Add to cart" href="{{route('add-to-cart',$materiel->slug)}}">Ajouter au panier</a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="materiel-content">
                                            <h3><a href="{{route('materiel-detail',$materiel->slug)}}">{{$materiel->nom}}</a></h3>
                                            <div class="materiel-price">
                                                @php
                                                    $after_discount=($materiel->price-($materiel->price*$materiel->discount)/100);
                                                @endphp
                                                <span>Dhs {{number_format($after_discount,2)}}</span>
                                                <del style="padding-left:4%;"> {{number_format($materiel->price,2)}} Dhs</del>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach

                             <!--/ End Single Tab -->
                            @endif

                        <!--/ End Single Tab -->

                        </div>
                    </div>
                </div>
            </div>
        </div>
</div>
<!-- End Materiel Area -->
{{-- @php
    $featured=DB::table('materiels')->where('is_featured',1)->where('status','active')->orderBy('id','DESC')->limit(1)->get();
@endphp --}}
<!-- Start Midium Banner  -->
<section class="midium-banner">
    <div class="container">
        <div class="row">
            @if($featured)
                @foreach($featured as $data)
                    <!-- Single Banner  -->
                    <div class="col-lg-6 col-md-6 col-12">
                        <div class="single-banner">
                            @php
                                $photo=explode(',',$data->photo);
                            @endphp
                            <img src="backend\img\materiels\{{$photo[0]}}" alt="backend\img\materiels\{{$photo[0]}}">
                            <div class="content">
                                <p>{{$data->cat_info['title']}}</p>
                                <h3 id="titre_jus">{{$data->title}} Jusqu'à<span> {{$data->discount}}%</span></h3>
                                <a href="{{route('materiel-detail',$data->slug)}}">Achetez maintenant</a>
                            </div>
                        </div>
                    </div>
                    <!-- /End Single Banner  -->
                @endforeach
            @endif
        </div>
    </div>
</section>
<!-- End Midium Banner -->

<!-- Start Most Popular -->
<div class="materiel-area most-popular section">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="section-title">
                    <h2>Element passionné</h2>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="owl-carousel popular-slider">
                    @foreach($materiel_lists as $materiel)
                        @if($materiel->condition=='hot')
                            <!-- Start Single Materiel -->
                        <div class="single-materiel">
                            <div class="materiel-img">
                                <a href="{{route('materiel-detail',$materiel->slug)}}">
                                    @php
                                        $photo=explode(',',$materiel->photo);
                                    // dd($photo);
                                    @endphp
                                    <img class="default-img" src="backend\img\materiels\{{$photo[0]}}" alt="backend\img\materiels\{{$photo[0]}}">
                                    <img class="hover-img" src="backend\img\materiels\{{$photo[0]}}" alt="backend\img\materiels\{{$photo[0]}}">
                                    {{-- <span class="out-of-stock">Hot</span> --}}
                                </a>
                                <div class="button-head">
                                    <div class="materiel-action">
                                        <a data-toggle="modal" data-target="#{{$materiel->id}}" title="Quick View" href="#"><i class=" ti-eye"></i><span>Achat rapide</span></a>
                                        <a title="Wishlist" href="{{route('add-to-wishlist',$materiel->slug)}}" ><i class=" ti-heart "></i><span>Ajouter à la liste de souhaits</span></a>
                                    </div>
                                    <div class="materiel-action-2">
                                        <a href="{{route('add-to-cart',$materiel->slug)}}">Ajouter au panier</a>
                                    </div>
                                </div>
                            </div>
                            <div class="materiel-content">
                                <h3><a href="{{route('materiel-detail',$materiel->slug)}}">{{$materiel->nom}}</a></h3>
                                <div class="materiel-price">
                                    <span class="old">Dhs {{number_format($materiel->price,2)}}</span>
                                    @php
                                    $after_discount=($materiel->price-($materiel->price*$materiel->discount)/100)
                                    @endphp
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

<!-- Start Shop Home List  -->
<section class="shop-home-list section">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-12">
                <div class="row">
                    <div class="col-12">
                        <div class="shop-section-title">
                            <h1>Derniére articles</h1>
                        </div>
                    </div>
                </div>
                <div class="row">
                    @php
                        $materiel_lists=DB::table('materiels')->where('status','active')->orderBy('id','DESC')->limit(6)->get();
                    @endphp
                    @foreach($materiel_lists as $materiel)
                        <div class="col-md-4">
                            <!-- Start Single List  -->
                            <div class="single-list">
                                <div class="row">
                                <div class="col-lg-6 col-md-6 col-12">
                                    <div class="list-image overlay">
                                        @php
                                            $photo=explode(',',$materiel->photo);
                                            // dd($photo);
                                        @endphp
                                        <img src="backend\img\materiels\{{$photo[0]}}" alt="{{$photo[0]}}">
                                        <a href="{{route('add-to-cart',$materiel->slug)}}" class="buy"><i class="fa fa-shopping-bag"></i></a>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-12 no-padding">
                                    <div class="content">
                                        <h4 class="title"><a href="#">{{$materiel->nom}}</a></h4>
                                        <p class="price with-discount"> {{number_format($materiel->price,2)}} Dhs</p>
                                    </div>
                                </div>
                                </div>
                            </div>
                            <!-- End Single List  -->
                        </div>
                    @endforeach

                </div>
            </div>
        </div>
    </div>
</section>
<!-- End Shop Home List  -->
{{-- @foreach($featured as $data)
    <!-- Start Cowndown Area -->
    <section class="cown-down">
        <div class="section-inner ">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-6 col-12 padding-right">
                        <div class="image">
                            @php
                                $photo=explode(',',$data->photo);
                                // dd($photo);
                            @endphp
                            <img src="{{$photo[0]}}" alt="{{$photo[0]}}">
                        </div>
                    </div>
                    <div class="col-lg-6 col-12 padding-left">
                        <div class="content">
                            <div class="heading-block">
                                <p class="small-title">Offre du jour</p>
                                <h3 class="title">{{$data->title}}</h3>
                                <p class="text">{!! html_entity_decode($data->summary) !!}</p>
                                @php
                                    $after_discount=($materiel->price-($materiel->price*$materiel->discount)/100)
                                @endphp
                              
                                <h1 class="price"> {{number_format($after_discount)}} Dhs <s> {{number_format($data->price)}} Dhs</s></h1>
                                <div class="coming-time">
                                    <div class="clearfix" data-countdown="2021/02/30"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- /End Cowndown Area -->
@endforeach --}}
<!-- Start Shop Blog  -->
<section class="shop-blog section">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="section-title">
                    <h2>Notre Poste</h2>
                </div>
            </div>
        </div>
        <div class="row">
            @if($posts)
                @foreach($posts as $post)
                    <div class="col-lg-4 col-md-6 col-12">
                        <!-- Start Single Blog  -->
                        <div class="shop-single-blog">
                            <img src="backend\img\{{$post->photo}}" alt="backend\img\{{$post->photo}}">
                            <div class="content">
                                <p class="date">{{$post->created_at->format('d-m -Y. ')}}</p>
                                <a href="{{route('blog.detail',$post->slug)}}" class="title">{{$post->title}}</a>
                                <a href="{{route('blog.detail',$post->slug)}}" class="more-btn">Continuer la lecture</a>
                            </div>
                        </div>
                        <!-- End Single Blog  -->
                    </div>
                @endforeach
            @endif

        </div>
    </div>
</section>
<!-- End Shop Blog  -->

<!-- Start Shop Services Area -->
<section class="shop-services section home">
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

<!-- Modal -->
@if($materiel_lists)
    @foreach($materiel_lists as $key=>$materiel)
        <div class="modal fade" id="{{$materiel->id}}" tabindex="-1" role="dialog">
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
                                                @php
                                                    $photo=explode(',',$materiel->photo);
                                                // dd($photo);
                                                @endphp
                                                @foreach($photo as $data)
                                                    <div class="single-slider">
                                                        <img src="backend\img\materiels\{{$data}}" alt="backend\img\materiels\{{$data}}">
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    <!-- End Materiel slider -->
                                </div>
    
                            </div>
                        </div>
                    </div>
                </div>
        </div>
    @endforeach
@endif
<!-- Modal end -->
@endsection

@push('styles')
    <script type='text/javascript' src='https://platform-api.sharethis.com/js/sharethis.js#property=5f2e5abf393162001291e431&materiel=inline-share-buttons' async='async'></script>
    <script type='text/javascript' src='https://platform-api.sharethis.com/js/sharethis.js#property=5f2e5abf393162001291e431&materiel=inline-share-buttons' async='async'></script>
    <style>
        /* Banner Sliding */
        #Gslider .carousel-inner {
        background: #000000;
        color:black;
        }

        #Gslider .carousel-inner{
       /* height: 550px;*/
        }
        #Gslider .carousel-inner img{
            width: 100% !important;
            opacity: .8;
        }

        #Gslider .carousel-inner .carousel-caption {
        bottom: 60%;
        }

        #Gslider .carousel-inner .carousel-caption h1 {
        font-size: 50px;
        font-weight: bold;
        line-height: 100%;
        color: #4caf50;
        }

        #Gslider .carousel-inner .carousel-caption p {
        font-size: 18px;
        color: black;
        margin: 28px 0 28px 0;
        }

        #Gslider .carousel-indicators {
        bottom: 70px;
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
							// document.location.href=document.location.href;
						});
					}
                    else{
                        window.location.href='user/login'
                    }
                }
            })
        });
    </script> --}}
    {{-- <script>
        $('.wishlist').click(function(){
            var quantity=1;
            var pro_id=$(this).data('id');
            // alert(pro_id);
            $.ajax({
                url:"{{route('add-to-wishlist')}}",
                type:"POST",
                data:{
                    _token:"{{csrf_token()}}",
                    quantity:quantity,
                    pro_id:pro_id,
                },
                success:function(response){
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
            });
        });
    </script> --}}
    <script>

        /*==================================================================
        [ Isotope ]*/
        var $topeContainer = $('.isotope-grid');
        var $filter = $('.filter-tope-group');

        // filter items on button click
        $filter.each(function () {
            $filter.on('click', 'button', function () {
                var filterValue = $(this).attr('data-filter');
                $topeContainer.isotope({filter: filterValue});
            });

        });

        // init Isotope
        $(window).on('load', function () {
            var $grid = $topeContainer.each(function () {
                $(this).isotope({
                    itemSelector: '.isotope-item',
                    layoutMode: 'fitRows',
                    percentPosition: true,
                    animationEngine : 'best-available',
                    masonry: {
                        columnWidth: '.isotope-item'
                    }
                });
            });
        });

        var isotopeButton = $('.filter-tope-group button');

        $(isotopeButton).each(function(){
            $(this).on('click', function(){
                for(var i=0; i<isotopeButton.length; i++) {
                    $(isotopeButton[i]).removeClass('how-active1');
                }

                $(this).addClass('how-active1');
            });
        });
    </script>
    <script>
         function cancelFullScreen(el) {
            var requestMethod = el.cancelFullScreen||el.webkitCancelFullScreen||el.mozCancelFullScreen||el.exitFullscreen;
            if (requestMethod) { // cancel full screen.
                requestMethod.call(el);
            } else if (typeof window.ActiveXObject !== "undefined") { // Older IE.
                var wscript = new ActiveXObject("WScript.Shell");
                if (wscript !== null) {
                    wscript.SendKeys("{F11}");
                }
            }
        }

        function requestFullScreen(el) {
            // Supports most browsers and their versions.
            var requestMethod = el.requestFullScreen || el.webkitRequestFullScreen || el.mozRequestFullScreen || el.msRequestFullscreen;

            if (requestMethod) { // Native full screen.
                requestMethod.call(el);
            } else if (typeof window.ActiveXObject !== "undefined") { // Older IE.
                var wscript = new ActiveXObject("WScript.Shell");
                if (wscript !== null) {
                    wscript.SendKeys("{F11}");
                }
            }
            return false
        }
    </script>

@endpush
