<?php

namespace App\Http\Controllers;

use App\Models\Commentaire;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;

class CommentaireController extends Controller
{

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //traitement de l'ajout commentaire
        $request->validate([
            'nom' => 'required',
        ]);


        $commentaire = new Commentaire();
        $commentaire->nom = $request->nom;
        $commentaire->email = $request->email;
        $commentaire->siteweb = $request->siteweb;
        $commentaire->resume = $request->resume;
        $commentaire->date = $request->date;
        $commentaire->actualite_id = $request->actualite_id;
        $commentaire->etat = 1;
        Schema::disableForeignKeyConstraints();
        $commentaire->save();
        Schema::enableForeignKeyConstraints();

        //return redirect()->route('commentaire.create')->with('status', 'Votre commentaire a bien été enregistré.');
        return redirect()->route('actualite.detail', ['id' => $request->actualite_id])->with('status', 'Votre commentaire a bien été enregistré.');


    }


}

