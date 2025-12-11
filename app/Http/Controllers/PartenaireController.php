<?php

namespace App\Http\Controllers;

use App\Models\Partenaire;
use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;

class PartenaireController extends Controller
{
    
    public function liste()
    {
        $slider = Slider::where('etat', 1)->where('spotlight', 0)->where('slidertype_id', '=', 1)->inRandomOrder()->first();

        //affiche la liste des partenaires
        //$partenaires = Partenaire::paginate(2);
        $partenaires = Partenaire::where('etat', 1)->where('langue_id', __('id'))->orderBy('partenairetype_id', 'asc')->orderBy('id', 'desc')->get();
        //dd($partenaires);
        return view('partenaire.liste', compact(['partenaires', 'slider']));
    }


    public function detail($id)
    {
        $slider = Slider::where('etat', 1)->where('spotlight', 0)->where('slidertype_id', '=', 1)->inRandomOrder()->first();

        //Afficher le detail de l'partenaire
        $partenaire = Partenaire::find($id);
        return view('partenaire.detail', compact(['partenaire', 'slider']));
    }
}
