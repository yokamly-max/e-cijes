<?php

namespace App\Orchid\Screens\Formation;

use App\Models\Formation;
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
        $formations = Formation::all();

        // 2. Récupérer les pays depuis Supabase
        $paysModel = new Pays();
        $payss = collect($paysModel->all()); // collection d'objets Supabase

        // 3. Associer chaque région avec son pays
        $formations->transform(function ($formation) use ($payss) {
            $formation->pays = $payss->firstWhere('id', $formation->pays_id);
            return $formation;
        });

        return [
            'formations' => $formations,
        ];
    }

    public function name(): ?string
    {
        return 'Liste des formations';
    }

    public function description(): ?string
    {
        return 'Toutes les formations enregistrées';
    }

    /**
     * Barre d'action (boutons en haut)
     */
    public function commandBar(): iterable
    {
        return [
            Link::make('Créer une formation')
                ->icon('plus')
                ->route('platform.formation.edit'),
        ];
    }

    public function layout(): iterable
    {
        return [
            Layout::view('screens.formation.list'), 
        ];
    }

    public function toggleEtat(Request $request)
    {
        $formation = Formation::findOrFail($request->input('id'));
        $formation->etat = !$formation->etat;
        $formation->save();

        Alert::info("État modifié.");
        return redirect()->back();
    }

    public function toggleSpotlight(Request $request)
    {
        $formation = Formation::findOrFail($request->input('id'));
        $formation->spotlight = !$formation->spotlight;
        $formation->save();

        Alert::info("Spotlight modifié.");
        return redirect()->back();
    }

    public function delete(Request $request)
    {
        $formation = Formation::findOrFail($request->input('formation'));
        $formation->delete();

        Alert::info("Formation supprimée.");
        return redirect()->back();
    }
}
