<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use App\Models\Cart;
use App\Models\Order;
use App\Models\Livraison;
use App\Models\Location;
use App\User;
use PDF;
use Notification;
use Helper;
use Illuminate\Support\Str;
use App\Notifications\StatusNotification;
class LocationController extends Controller
{
    /*
    public function index()
    {

        return view('frontend.pages.location');
    }*/
    public function index()
    {
        $locations=location::orderBy('id','DESC')->paginate(10);
        return view('backend.location.index')->with('locations',$locations);
    }

    public function store()
    {
   
    }
    public function location_form(){
        return view('frontend.pages.location');
    }
}
