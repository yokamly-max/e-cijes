<?php

namespace App\Orchid\Screens\Diagnosticresultat;

use App\Models\Diagnosticresultat;
use Orchid\Screen\Screen;
use Illuminate\Http\Request;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Alert;
use Orchid\Screen\Actions\Link;

class ListScreen extends Screen
{
    public function query(): iterable
    {
        return [
            'diagnosticresultats' => Diagnosticresultat::all(),
        ];
    }

    public function name(): ?string
    {
        return 'Liste des résultats des diagnostics';
    }

    public function description(): ?string
    {
        return 'Tous les résultats des diagnostics enregistrés';
    }

    /**
     * Barre d'action (boutons en haut)
     */
    public function commandBar(): iterable
    {
        return [
            Link::make('Créer un résultat du diagnostic')
                ->icon('plus')
                ->route('platform.diagnosticresultat.edit'),
        ];
    }

    public function layout(): iterable
    {
        return [
            Layout::view('screens.diagnosticresultat.list'), 
        ];
    }

    public function toggleEtat(Request $request)
    {
        $diagnosticresultat = Diagnosticresultat::findOrFail($request->input('id'));
        $diagnosticresultat->etat = !$diagnosticresultat->etat;
        $diagnosticresultat->save();

        Alert::info("État modifié.");
        return redirect()->back();
    }

    public function toggleSpotlight(Request $request)
    {
        $diagnosticresultat = Diagnosticresultat::findOrFail($request->input('id'));
        $diagnosticresultat->spotlight = !$diagnosticresultat->spotlight;
        $diagnosticresultat->save();

        Alert::info("Spotlight modifié.");
        return redirect()->back();
    }

    public function delete(Request $request)
    {
        $diagnosticresultat = Diagnosticresultat::findOrFail($request->input('diagnosticresultat'));
        $diagnosticresultat->delete();

        Alert::info("Résultat du diagnostic supprimé.");
        return redirect()->back();
    }
}
