<?php

namespace App\Orchid\Screens\Temoignage;

use App\Models\Temoignage;
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
        $temoignages = Temoignage::all();

        // 2. Charger tous les pays depuis Supabase
        $paysModel = new Pays();
        $payss = collect($paysModel->all()); // Collection d'objets

        // 3. Charger toutes les langues depuis Supabase
        $langueModel = new Langue();
        $langues = collect($langueModel->all()); // Collection d'objets

        // 4. Associer à chaque actualité son pays et sa langue
        $temoignages->transform(function ($temoignage) use ($payss, $langues) {
            $temoignage->pays = $payss->firstWhere('id', $temoignage->pays_id);
            $temoignage->langue = $langues->firstWhere('id', $temoignage->langue_id);
            return $temoignage;
        });

        return [
            'temoignages' => $temoignages,
        ];
    }

    public function name(): ?string
    {
        return 'Liste des témoignages';
    }

    public function description(): ?string
    {
        return 'Tous les témoignages enregistrés';
    }

    /**
     * Barre d'action (boutons en haut)
     */
    public function commandBar(): iterable
    {
        return [
            Link::make('Créer un témoignage')
                ->icon('plus')
                ->route('platform.temoignage.edit'),
        ];
    }

    public function layout(): iterable
    {
        return [
            Layout::view('screens.temoignage.list'), 
        ];
    }

    public function toggleEtat(Request $request)
    {
        $temoignage = Temoignage::findOrFail($request->input('id'));
        $temoignage->etat = !$temoignage->etat;
        $temoignage->save();

        Alert::info("État modifié.");
        return redirect()->back();
    }

    public function toggleSpotlight(Request $request)
    {
        $temoignage = Temoignage::findOrFail($request->input('id'));
        $temoignage->spotlight = !$temoignage->spotlight;
        $temoignage->save();

        Alert::info("Spotlight modifié.");
        return redirect()->back();
    }

    public function delete(Request $request)
    {
        $temoignage = Temoignage::findOrFail($request->input('temoignage'));
        $temoignage->delete();

        Alert::info("Témoignage supprimé.");
        return redirect()->back();
    }
}
