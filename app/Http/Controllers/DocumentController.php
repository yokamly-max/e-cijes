<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\Slider;
use App\Models\Documenttype;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;

class DocumentController extends Controller
{

    public function liste($id = 0)
    {
        $slider = Slider::where('etat', 1)->where('spotlight', 0)->where('slidertype_id', '=', 1)->inRandomOrder()->first();

        //affiche la liste des documents
        //$documents = Document::paginate(2);
        if($id > 0){
        $documents = Document::where('etat', 1)->where('documenttype_id', $id)->orderBy('datedocument', 'desc')->orderBy('id', 'asc')->paginate(12);

        if(!(count($documents) > 0)){
        $documenttypes = Documenttype::Where('parent', $id)->get('id');
        $documents = Document::where('etat', 1)->whereIn('documenttype_id', $documenttypes)->orderBy('datedocument', 'desc')->orderBy('id', 'asc')->paginate(30);
        }
        
        $documenttype = Documenttype::find($id);
        //dd($documents);
        return view('document.liste', compact(['documents', 'slider', 'documenttype']));
        }else{
        $id = 0;
        $documents = Document::where('etat', 1)->orderBy('datedocument', 'desc')->orderBy('id', 'asc')->paginate(30);
        //dd($documents);
        return view('document.liste', compact(['documents', 'slider'])); 
        }
    }

}

