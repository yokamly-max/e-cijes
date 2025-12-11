<?php

namespace App\Orchid\Screens\Actualite;

use App\Models\Actualite;
use App\Models\Pays;
use App\Models\Langue;
use Orchid\Screen\Screen;
use Illuminate\Http\Request;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Alert;
use Orchid\Screen\Actions\Link;

class ListScreen extends Screen
{
    public function query(): iterable
    {
        // 1. Charger toutes les actualités locales
        $actualites = Actualite::all();

        // 2. Charger tous les pays depuis Supabase
        $paysModel = new Pays();
        $payss = collect($paysModel->all()); // Collection d'objets

        // 3. Charger toutes les langues depuis Supabase
        $langueModel = new Langue();
        $langues = collect($langueModel->all()); // Collection d'objets

        // 4. Associer à chaque actualité son pays et sa langue
        $actualites->transform(function ($actualite) use ($payss, $langues) {
            $actualite->pays = $payss->firstWhere('id', $actualite->pays_id);
            $actualite->langue = $langues->firstWhere('id', $actualite->langue_id);
            return $actualite;
        });

        return [
            'actualites' => $actualites,
        ];
    }

    public function name(): ?string
    {
        return 'Liste des actualités';
    }

    public function description(): ?string
    {
        return 'Toutes les actualités enregistrées';
    }

    /**
     * Barre d'action (boutons en haut)
     */
    public function commandBar(): iterable
    {
        return [
            Link::make('Créer une actualité')
                ->icon('plus')
                ->route('platform.actualite.edit'),
        ];
    }

    public function layout(): iterable
    {
        return [
            Layout::view('screens.actualite.list'), 
        ];
    }

    public function toggleEtat(Request $request)
    {
        $actualite = Actualite::findOrFail($request->input('id'));
        $actualite->etat = !$actualite->etat;
        $actualite->save();

        Alert::info("État modifié.");
        return redirect()->back();
    }

    public function toggleSpotlight(Request $request)
    {
        $actualite = Actualite::findOrFail($request->input('id'));
        $actualite->spotlight = !$actualite->spotlight;
        $actualite->save();

        Alert::info("Spotlight modifié.");
        return redirect()->back();
    }

    public function delete(Request $request)
    {
        $actualite = Actualite::findOrFail($request->input('actualite'));
        $actualite->delete();

        Alert::info("Actualité supprimée.");
        return redirect()->back();
    }
}
