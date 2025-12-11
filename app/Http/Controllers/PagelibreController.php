<?php

namespace App\Http\Controllers;

use App\Models\Pagelibre;
use App\Models\Slider;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;

class PagelibreController extends Controller
{

    public function detail($id)
    {
        $slider = Slider::where('etat', 1)->where('spotlight', 0)->where('slidertype_id', '=', 1)->inRandomOrder()->first();

        //Afficher le detail de l'pagelibre
        $pagelibre = Pagelibre::find($id);
        $pagelibres = DB::table('pagelibres')->where('etat', 1)->where('langue_id', __('id'))->where('parent', $id)->get();
        
        return view('pagelibre.detail', compact(['pagelibre', 'pagelibres', 'slider']));
    }


}

