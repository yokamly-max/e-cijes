<?php

namespace App\Orchid\Screens\Commentaire;

use App\Models\Commentaire;
use App\Models\Pays;
use Orchid\Screen\Screen;
use Illuminate\Http\Request;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Alert;
use Orchid\Screen\Actions\Link;

class ListScreen extends Screen
{
    public function query(): iterable
    {
        // 1. Charger les régions locales
        $commentaires = Commentaire::all();

        // 2. Récupérer les pays depuis Supabase
        $paysModel = new Pays();
        $payss = collect($paysModel->all()); // collection d'objets Supabase

        // 3. Associer chaque région avec son pays
        $commentaires->transform(function ($commentaire) use ($payss) {
            $commentaire->pays = $payss->firstWhere('id', $commentaire->pays_id);
            return $commentaire;
        });

        return [
            'commentaires' => $commentaires,
        ];
    }

    public function name(): ?string
    {
        return 'Liste des commentaires';
    }

    public function description(): ?string
    {
        return 'Tous les commentaires enregistrés';
    }

    /**
     * Barre d'action (boutons en haut)
     */
    public function commandBar(): iterable
    {
        return [
            Link::make('Créer un commentaire')
                ->icon('plus')
                ->route('platform.commentaire.edit'),
        ];
    }

    public function layout(): iterable
    {
        return [
            Layout::view('screens.commentaire.list'), 
        ];
    }

    public function toggleEtat(Request $request)
    {
        $commentaire = Commentaire::findOrFail($request->input('id'));
        $commentaire->etat = !$commentaire->etat;
        $commentaire->save();

        Alert::info("État modifié.");
        return redirect()->back();
    }

    public function delete(Request $request)
    {
        $commentaire = Commentaire::findOrFail($request->input('commentaire'));
        $commentaire->delete();

        Alert::info("Commentaire supprimé.");
        return redirect()->back();
    }
}
