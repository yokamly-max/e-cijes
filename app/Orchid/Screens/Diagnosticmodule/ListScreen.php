<?php

namespace App\Orchid\Screens\Diagnosticmodule;

use App\Models\Diagnosticmodule;
use App\Models\Diagnosticmoduletype;
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
        $diagnosticmodules = Diagnosticmodule::all();

        // 2. Charger tous les pays depuis Supabase
        $paysModel = new Pays();
        $payss = collect($paysModel->all()); // Collection d'objets

        // 3. Charger toutes les langues depuis Supabase
        $langueModel = new Langue();
        $langues = collect($langueModel->all()); // Collection d'objets

        // 4. Associer à chaque actualité son pays et sa langue
        $diagnosticmodules->transform(function ($diagnosticmodule) use ($payss, $langues) {
            $diagnosticmodule->pays = $payss->firstWhere('id', $diagnosticmodule->pays_id);
            $diagnosticmodule->langue = $langues->firstWhere('id', $diagnosticmodule->langue_id);
            return $diagnosticmodule;
        });

        return [
            'diagnosticmodules' => $diagnosticmodules,
        ];
    }

    public function name(): ?string
    {
        return 'Liste des modules des diagnostics';
    }

    public function description(): ?string
    {
        return 'Tous les modules des diagnostics enregistrés';
    }

    /**
     * Barre d'action (boutons en haut)
     */
    public function commandBar(): iterable
    {
        return [
            Link::make('Créer un module de diagnostic')
                ->icon('plus')
                ->route('platform.diagnosticmodule.edit'),
        ];
    }

    public function layout(): iterable
    {
        return [
            Layout::view('screens.diagnosticmodule.list'), 
        ];
    }

    public function toggleEtat(Request $request)
    {
        $diagnosticmodule = Diagnosticmodule::findOrFail($request->input('id'));
        $diagnosticmodule->etat = !$diagnosticmodule->etat;
        $diagnosticmodule->save();

        Alert::info("État modifié.");
        return redirect()->back();
    }

    public function toggleSpotlight(Request $request)
    {
        $diagnosticmodule = Diagnosticmodule::findOrFail($request->input('id'));
        $diagnosticmodule->spotlight = !$diagnosticmodule->spotlight;
        $diagnosticmodule->save();

        Alert::info("Spotlight modifié.");
        return redirect()->back();
    }

    public function delete(Request $request)
    {
        $diagnosticmodule = Diagnosticmodule::findOrFail($request->input('diagnosticmodule'));
        $diagnosticmodule->delete();

        Alert::info("Module de diagnostic supprimé.");
        return redirect()->back();
    }
}
