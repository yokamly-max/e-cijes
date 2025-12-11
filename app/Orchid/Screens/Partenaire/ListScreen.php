<?php

namespace App\Orchid\Screens\Partenaire;

use App\Models\Partenaire;
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
        $partenaires = Partenaire::all();

        // 2. Charger tous les pays depuis Supabase
        $paysModel = new Pays();
        $payss = collect($paysModel->all()); // Collection d'objets

        // 3. Charger toutes les langues depuis Supabase
        $langueModel = new Langue();
        $langues = collect($langueModel->all()); // Collection d'objets

        // 4. Associer à chaque actualité son pays et sa langue
        $partenaires->transform(function ($partenaire) use ($payss, $langues) {
            $partenaire->pays = $payss->firstWhere('id', $partenaire->pays_id);
            $partenaire->langue = $langues->firstWhere('id', $partenaire->langue_id);
            return $partenaire;
        });

        return [
            'partenaires' => $partenaires,
        ];
    }

    public function name(): ?string
    {
        return 'Liste des partenaires';
    }

    public function description(): ?string
    {
        return 'Tous les partenaires enregistrés';
    }

    /**
     * Barre d'action (boutons en haut)
     */
    public function commandBar(): iterable
    {
        return [
            Link::make('Créer un partenaire')
                ->icon('plus')
                ->route('platform.partenaire.edit'),
        ];
    }

    public function layout(): iterable
    {
        return [
            Layout::view('screens.partenaire.list'), 
        ];
    }

    public function toggleEtat(Request $request)
    {
        $partenaire = Partenaire::findOrFail($request->input('id'));
        $partenaire->etat = !$partenaire->etat;
        $partenaire->save();

        Alert::info("État modifié.");
        return redirect()->back();
    }

    public function toggleSpotlight(Request $request)
    {
        $partenaire = Partenaire::findOrFail($request->input('id'));
        $partenaire->spotlight = !$partenaire->spotlight;
        $partenaire->save();

        Alert::info("Spotlight modifié.");
        return redirect()->back();
    }

    public function delete(Request $request)
    {
        $partenaire = Partenaire::findOrFail($request->input('partenaire'));
        $partenaire->delete();

        Alert::info("Partenaire supprimé.");
        return redirect()->back();
    }
}
