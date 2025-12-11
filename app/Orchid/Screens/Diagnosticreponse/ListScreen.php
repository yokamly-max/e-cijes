<?php

namespace App\Orchid\Screens\Diagnosticreponse;

use App\Models\Diagnosticreponse;
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
        $diagnosticreponses = Diagnosticreponse::all();

        // 3. Charger toutes les langues depuis Supabase
        $langueModel = new Langue();
        $langues = collect($langueModel->all()); // Collection d'objets

        // 4. Associer à chaque actualité sa langue
        $diagnosticreponses->transform(function ($diagnosticreponse) use ($langues) {
            $diagnosticreponse->langue = $langues->firstWhere('id', $diagnosticreponse->langue_id);
            return $diagnosticreponse;
        });

        return [
            'diagnosticreponses' => $diagnosticreponses,
        ];
    }

    public function name(): ?string
    {
        return 'Liste des réponses des diagnostics';
    }

    public function description(): ?string
    {
        return 'Toutes les réponses des diagnostics enregistrées';
    }

    /**
     * Barre d'action (boutons en haut)
     */
    public function commandBar(): iterable
    {
        return [
            Link::make('Créer une réponse du diagnostic')
                ->icon('plus')
                ->route('platform.diagnosticreponse.edit'),
        ];
    }

    public function layout(): iterable
    {
        return [
            Layout::view('screens.diagnosticreponse.list'), 
        ];
    }

    public function toggleEtat(Request $request)
    {
        $diagnosticreponse = Diagnosticreponse::findOrFail($request->input('id'));
        $diagnosticreponse->etat = !$diagnosticreponse->etat;
        $diagnosticreponse->save();

        Alert::info("État modifié.");
        return redirect()->back();
    }

    public function toggleSpotlight(Request $request)
    {
        $diagnosticreponse = Diagnosticreponse::findOrFail($request->input('id'));
        $diagnosticreponse->spotlight = !$diagnosticreponse->spotlight;
        $diagnosticreponse->save();

        Alert::info("Spotlight modifié.");
        return redirect()->back();
    }

    public function delete(Request $request)
    {
        $diagnosticreponse = Diagnosticreponse::findOrFail($request->input('diagnosticreponse'));
        $diagnosticreponse->delete();

        Alert::info("Réponse du diagnostic supprimée.");
        return redirect()->back();
    }
}
