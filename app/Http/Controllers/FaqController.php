<?php

namespace App\Http\Controllers;

use App\Models\Faq;
use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class FaqController extends Controller
{
    
    public function liste()
    {
        $slider = Slider::where('etat', 1)->where('spotlight', 0)->where('slidertype_id', '=', 1)->inRandomOrder()->first();

        //affiche la liste des faqs
        //$faqs = Faq::paginate(2);
        $faqs = Faq::where('etat', 1)->where('langue_id', __('id'))->orderBy('id', 'desc')->paginate(20);
        //dd($faqs);
        return view('faq.liste', compact(['faqs', 'slider']));
    }



}

