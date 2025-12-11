<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use App\Models\Slider;
use App\Models\Pagelibre;
use App\Models\Actualite;
use App\Models\Chiffre;
use App\Models\Faq;
use App\Models\Partenaire;
use App\Models\Temoignage;
use App\Models\Service;

class IndexController extends Controller
{
    //afficher index
    public function index(){

        $sliders = Slider::where('etat', 1)->where('slidertype_id', '=', 1)->orderBy('slidertype_id', 'asc')->orderBy('id', 'desc')->get();

        $pagelibre = Pagelibre::where('etat', 1)->where('spotlight', 1)->where('langue_id', __('id'))->first();

        $chiffres = Chiffre::where('etat', 1)->where('langue_id', __('id'))->orderBy('id', 'desc')->limit(4)->get();

        $services = Service::where('etat', 1)->where('langue_id', __('id'))->orderBy('id', 'desc')->limit(3)->get();

        $temoignages = Temoignage::where('etat', 1)->where('langue_id', __('id'))->orderBy('id', 'desc')->limit(4)->get();

        $partenaires = Partenaire::where('etat', 1)->where('langue_id', __('id'))->where('spotlight', 0)->orderBy('partenairetype_id', 'asc')->orderBy('id', 'asc')->get();

        $actualites = Actualite::where('etat', 1)->where('langue_id', __('id'))->orderBy('id', 'desc')->limit(3)->get();

//dd($pagelibre);



        return view('index.index', compact(['sliders', 'pagelibre', 'chiffres', 'services', 'temoignages', 'partenaires', 'actualites']));
    }

    //afficher recherche
    public function recherche(Request $request)
    {

        $slider = Slider::where('etat', 1)->where('spotlight', 0)->where('slidertype_id', '=', 1)->inRandomOrder()->first();

        //traitement de l'ajout contact
        $request->validate([
            'recherche' => 'required',
        ]);

        $pagelibres = Pagelibre::where(function($query) use ($request) {
        $query->where('titre', 'like', '%' . strtolower($request->recherche) . '%')
              ->orWhere('resume', 'like', '%' . strtolower($request->recherche) . '%');
    })->where('etat', 1)->where('langue_id', __('id'))->orderBy('titre', 'asc')->get();

        $chiffres = Chiffre::where(function($query) use ($request) {
        $query->where('titre', 'like', '%' . strtolower($request->recherche) . '%');
    })->where('etat', 1)->where('langue_id', __('id'))->orderBy('id', 'desc')->get();

        $services = Service::where(function($query) use ($request) {
        $query->where('titre', 'like', '%' . strtolower($request->recherche) . '%')
              ->orWhere('resume', 'like', '%' . strtolower($request->recherche) . '%');
    })->where('etat', 1)->where('langue_id', __('id'))->orderBy('titre', 'asc')->get();

        $temoignages = Temoignage::where(function($query) use ($request) {
        $query->where('nom', 'like', '%' . strtolower($request->recherche) . '%')
              ->orWhere('profil', 'like', '%' . strtolower($request->recherche) . '%');
    })->where('etat', 1)->where('langue_id', __('id'))->orderBy('id', 'desc')->get();

        $partenaires = Partenaire::where(function($query) use ($request) {
        $query->where('titre', 'like', '%' . strtolower($request->recherche) . '%');
    })->where('etat', 1)->where('langue_id', __('id'))->orderBy('titre', 'asc')->get();

        $actualites = Actualite::where(function($query) use ($request) {
        $query->where('titre', 'like', '%' . strtolower($request->recherche) . '%')
              ->orWhere('resume', 'like', '%' . strtolower($request->recherche) . '%');
    })->where('etat', 1)->where('langue_id', __('id'))->orderBy('id', 'desc')->get();

        $faqs = Faq::where(function($query) use ($request) {
        $query->where('question', 'like', '%' . strtolower($request->recherche) . '%')
              ->orWhere('reponse', 'like', '%' . strtolower($request->recherche) . '%');
    })->where('etat', 1)->where('langue_id', __('id'))->orderBy('question', 'asc')->get();


        return view('index.recherche', compact(['slider', 'pagelibres', 'chiffres', 'services', 'temoignages', 'partenaires', 'actualites', 'faqs']));
    }


}
