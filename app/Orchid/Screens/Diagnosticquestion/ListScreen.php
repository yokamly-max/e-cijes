<?php

namespace App\Orchid\Screens\Diagnosticquestion;

use App\Models\Diagnosticquestion;
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
        $diagnosticquestions = Diagnosticquestion::all();

        // 3. Charger toutes les langues depuis Supabase
        $langueModel = new Langue();
        $langues = collect($langueModel->all()); // Collection d'objets

        // 4. Associer à chaque actualité sa langue
        $diagnosticquestions->transform(function ($diagnosticquestion) use ($langues) {
            $diagnosticquestion->langue = $langues->firstWhere('id', $diagnosticquestion->langue_id);
            return $diagnosticquestion;
        });

        return [
            'diagnosticquestions' => $diagnosticquestions,
        ];
    }

    public function name(): ?string
    {
        return 'Liste des questions des diagnostics';
    }

    public function description(): ?string
    {
        return 'Toutes les questions des diagnostics enregistrées';
    }

    /**
     * Barre d'action (boutons en haut)
     */
    public function commandBar(): iterable
    {
        return [
            Link::make('Créer une question du diagnostic')
                ->icon('plus')
                ->route('platform.diagnosticquestion.edit'),
        ];
    }

    public function layout(): iterable
    {
        return [
            Layout::view('screens.diagnosticquestion.list'), 
        ];
    }

    public function toggleEtat(Request $request)
    {
        $diagnosticquestion = Diagnosticquestion::findOrFail($request->input('id'));
        $diagnosticquestion->etat = !$diagnosticquestion->etat;
        $diagnosticquestion->save();

        Alert::info("État modifié.");
        return redirect()->back();
    }

    public function toggleSpotlight(Request $request)
    {
        $diagnosticquestion = Diagnosticquestion::findOrFail($request->input('id'));
        $diagnosticquestion->spotlight = !$diagnosticquestion->spotlight;
        $diagnosticquestion->save();

        Alert::info("Spotlight modifié.");
        return redirect()->back();
    }

    public function delete(Request $request)
    {
        $diagnosticquestion = Diagnosticquestion::findOrFail($request->input('diagnosticquestion'));
        $diagnosticquestion->delete();

        Alert::info("Question du diagnostic supprimée.");
        return redirect()->back();
    }

    public function toggleObligatoire(Request $request)
    {
        $diagnosticquestion = Diagnosticquestion::findOrFail($request->input('id'));
        $diagnosticquestion->obligatoire = !$diagnosticquestion->obligatoire;
        $diagnosticquestion->save();

        Alert::info("Option Obligatoire modifiée.");
        return redirect()->back();
    }
}
