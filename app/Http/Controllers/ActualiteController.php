<?php

namespace App\Http\Controllers;

use App\Models\Actualite;
use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;

class ActualiteController extends Controller
{

    public function liste()
    {
        $slider = Slider::where('etat', 1)->where('spotlight', 0)->where('slidertype_id', '=', 1)->inRandomOrder()->first();

        //affiche la liste des actualites
        //$actualites = Actualite::paginate(2);
        $actualites = Actualite::where('etat', 1)->where('langue_id', __('id'))->orderBy('id', 'desc')->paginate(12);
        //dd(__('id'));
        return view('actualite.liste', compact(['actualites', 'slider']));
    }


    public function detail($id)
    {
        $slider = Slider::where('etat', 1)->where('spotlight', 0)->where('slidertype_id', '=', 1)->inRandomOrder()->first();

        //Afficher le detail de l'actualite
        $actualite = Actualite::find($id);
        $commentaires = DB::table('commentaires')->where('etat', 1)->where('actualite_id', $id)->orderBy('id', 'desc')->get();

        return view('actualite.detail', compact(['actualite', 'commentaires', 'slider']));
    }

}

