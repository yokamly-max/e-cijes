<?php

namespace App\Orchid\Screens\Disponibilite;

use App\Models\Disponibilite;
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
            'disponibilites' => Disponibilite::all(),
        ];
    }

    public function name(): ?string
    {
        return 'Liste des disponibilités';
    }

    public function description(): ?string
    {
        return 'Toutes les disponibilités enregistrées';
    }

    /**
     * Barre d'action (boutons en haut)
     */
    public function commandBar(): iterable
    {
        return [
            Link::make('Créer une disponibilité')
                ->icon('plus')
                ->route('platform.disponibilite.edit'),
        ];
    }

    public function layout(): iterable
    {
        return [
            Layout::view('screens.disponibilite.list'), 
        ];
    }

    public function toggleEtat(Request $request)
    {
        $disponibilite = Disponibilite::findOrFail($request->input('id'));
        $disponibilite->etat = !$disponibilite->etat;
        $disponibilite->save();

        Alert::info("État modifié.");
        return redirect()->back();
    }

    public function toggleSpotlight(Request $request)
    {
        $disponibilite = Disponibilite::findOrFail($request->input('id'));
        $disponibilite->spotlight = !$disponibilite->spotlight;
        $disponibilite->save();

        Alert::info("Spotlight modifié.");
        return redirect()->back();
    }

    public function delete(Request $request)
    {
        $disponibilite = Disponibilite::findOrFail($request->input('disponibilite'));
        $disponibilite->delete();

        Alert::info("Disponibilité supprimée.");
        return redirect()->back();
    }
}
