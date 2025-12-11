<?php

namespace App\Http\Controllers;

use App\Models\Temoignage;
use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class TemoignageController extends Controller
{

    public function liste()
    {
        $slider = Slider::where('etat', 1)->where('spotlight', 0)->where('slidertype_id', '=', 1)->inRandomOrder()->first();

        //affiche la liste des temoignages
        //$temoignages = Temoignage::paginate(2);
        $temoignages = Temoignage::where('etat', 1)->where('langue_id', __('id'))->orderBy('id', 'desc')->paginate(12);
        //dd($temoignages);
        return view('temoignage.liste', compact(['temoignages', 'slider']));
    }



}

