<?php

namespace App\Orchid\Screens\Membre;

use App\Models\Membre;
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
        $membres = Membre::all();

        // 2. Récupérer les pays depuis Supabase
        $paysModel = new Pays();
        $payss = collect($paysModel->all()); // collection d'objets Supabase

        // 3. Associer chaque région avec son pays
        $membres->transform(function ($membre) use ($payss) {
            $membre->pays = $payss->firstWhere('id', $membre->pays_id);
            return $membre;
        });

        return [
            'membres' => $membres,
        ];
    }

    public function name(): ?string
    {
        return 'Liste des membres';
    }

    public function description(): ?string
    {
        return 'Tous les membres enregistrés';
    }

    /**
     * Barre d'action (boutons en haut)
     */
    public function commandBar(): iterable
    {
        return [
            Link::make('Créer un membre')
                ->icon('plus')
                ->route('platform.membre.edit'),
        ];
    }

    public function layout(): iterable
    {
        return [
            Layout::view('screens.membre.list'), 
        ];
    }

    public function toggleEtat(Request $request)
    {
        $membre = Membre::findOrFail($request->input('id'));
        $membre->etat = !$membre->etat;
        $membre->save();

        Alert::info("État modifié.");
        return redirect()->back();
    }

    public function delete(Request $request)
    {
        $membre = Membre::findOrFail($request->input('membre'));
        $membre->delete();

        Alert::info("Membre supprimé.");
        return redirect()->back();
    }
}
