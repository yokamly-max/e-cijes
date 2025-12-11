<?php

namespace App\Orchid\Screens\Echeancier;

use App\Models\Echeancier;
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
            'echeanciers' => Echeancier::all(),
        ];
    }

    public function name(): ?string
    {
        return 'Liste des échéanciers';
    }

    public function description(): ?string
    {
        return 'Tous les échéanciers enregistrés';
    }

    /**
     * Barre d'action (boutons en haut)
     */
    public function commandBar(): iterable
    {
        return [
            Link::make('Créer un échéancier')
                ->icon('plus')
                ->route('platform.echeancier.edit'),
        ];
    }

    public function layout(): iterable
    {
        return [
            Layout::view('screens.echeancier.list'), 
        ];
    }

    public function toggleEtat(Request $request)
    {
        $echeancier = Echeancier::findOrFail($request->input('id'));
        $echeancier->etat = !$echeancier->etat;
        $echeancier->save();

        Alert::info("État modifié.");
        return redirect()->back();
    }

    public function toggleSpotlight(Request $request)
    {
        $echeancier = Echeancier::findOrFail($request->input('id'));
        $echeancier->spotlight = !$echeancier->spotlight;
        $echeancier->save();

        Alert::info("Spotlight modifié.");
        return redirect()->back();
    }

    public function delete(Request $request)
    {
        $echeancier = Echeancier::findOrFail($request->input('echeancier'));
        $echeancier->delete();

        Alert::info("Echéancier supprimé.");
        return redirect()->back();
    }
}
