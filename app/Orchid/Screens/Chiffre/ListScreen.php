<?php

namespace App\Orchid\Screens\Chiffre;

use App\Models\Chiffre;
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
        $chiffres = Chiffre::all();

        // 2. Charger tous les pays depuis Supabase
        $paysModel = new Pays();
        $payss = collect($paysModel->all()); // Collection d'objets

        // 3. Charger toutes les langues depuis Supabase
        $langueModel = new Langue();
        $langues = collect($langueModel->all()); // Collection d'objets

        // 4. Associer à chaque actualité son pays et sa langue
        $chiffres->transform(function ($chiffre) use ($payss, $langues) {
            $chiffre->pays = $payss->firstWhere('id', $chiffre->pays_id);
            $chiffre->langue = $langues->firstWhere('id', $chiffre->langue_id);
            return $chiffre;
        });

        return [
            'chiffres' => $chiffres,
        ];
    }
    
    public function name(): ?string
    {
        return 'Liste des chiffres';
    }

    public function description(): ?string
    {
        return 'Tous les chiffres enregistrés';
    }

    /**
     * Barre d'action (boutons en haut)
     */
    public function commandBar(): iterable
    {
        return [
            Link::make('Créer un chiffre')
                ->icon('plus')
                ->route('platform.chiffre.edit'),
        ];
    }

    public function layout(): iterable
    {
        return [
            Layout::view('screens.chiffre.list'), 
        ];
    }

    public function toggleEtat(Request $request)
    {
        $chiffre = Chiffre::findOrFail($request->input('id'));
        $chiffre->etat = !$chiffre->etat;
        $chiffre->save();

        Alert::info("État modifié.");
        return redirect()->back();
    }

    public function toggleSpotlight(Request $request)
    {
        $chiffre = Chiffre::findOrFail($request->input('id'));
        $chiffre->spotlight = !$chiffre->spotlight;
        $chiffre->save();

        Alert::info("Spotlight modifié.");
        return redirect()->back();
    }

    public function delete(Request $request)
    {
        $chiffre = Chiffre::findOrFail($request->input('chiffre'));
        $chiffre->delete();

        Alert::info("Chiffre supprimé.");
        return redirect()->back();
    }
}
