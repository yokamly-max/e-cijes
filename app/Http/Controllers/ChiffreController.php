<?php

namespace App\Http\Controllers;

use App\Models\Chiffre;
use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ChiffreController extends Controller
{

    public function liste()
    {
        $slider = Slider::where('etat', 1)->where('spotlight', 0)->where('slidertype_id', '=', 1)->inRandomOrder()->first();

        //affiche la liste des chiffres
        //$chiffres = Chiffre::paginate(2);
        $chiffres = Chiffre::where('etat', 1)->where('langue_id', __('id'))->orderBy('id', 'desc')->paginate(12);
        //dd($chiffres);
        return view('chiffre.liste', compact(['chiffres', 'slider']));
    }


}

