@extends('frontend.layouts.master')

@section('title','EDM-Medical || Suivre Commande')

@section('main-content')
    <!-- Breadcrumbs -->
    <div class="breadcrumbs">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="bread-inner">
                        <ul class="bread-list">
                            <li><a href="{{route('home')}}">Acceuil<i class="ti-arrow-right"></i></a></li>
                            <li class="active"><a href="javascript:void(0);">Suivre commande</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Breadcrumbs -->
<section class="tracking_box_area section_gap py-5">
    <div class="container">
        <div class="tracking_box_inner">
            <p>Pour suivre votre commande, veuillez entrer votre ID de commande dans la case ci-dessous et appuyez sur le bouton «Suivre». Cela a été donné
                 à vous sur votre reçu et dans l'e-mail de confirmation que vous auriez dû recevoir.</p>
            <form class="row tracking_form my-4" action="{{route('materiel.track.order')}}" method="post" novalidate="novalidate">
              @csrf
                <div class="col-md-8 form-group">
                    <input type="text" class="form-control p-2"  name="order_number" placeholder="Entrer le numero de commande">
                </div>
                <div class="col-md-8 form-group">
                    <button type="submit" value="submit" class="btn submit_btn">Suivre commande</button>
                </div>
            </form>
        </div>
    </div>
</section>
@endsection