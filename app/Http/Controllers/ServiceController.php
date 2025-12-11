<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ServiceController extends Controller
{
    
    public function liste()
    {
        $slider = Slider::where('etat', 1)->where('spotlight', 0)->where('slidertype_id', '=', 1)->inRandomOrder()->first();

        //affiche la liste des services
        //$services = Service::paginate(2);
        $services = Service::where('etat', 1)->where('langue_id', __('id'))->orderBy('id', 'desc')->paginate(12);
        //dd($services);
        return view('service.liste', compact(['services', 'slider']));
    }


    public function detail($id)
    {
        $slider = Slider::where('etat', 1)->where('spotlight', 0)->where('slidertype_id', '=', 1)->inRandomOrder()->first();

        //Afficher le detail de l'service
        $service = Service::find($id);
        return view('service.detail', compact(['service', 'slider']));
    }


}

