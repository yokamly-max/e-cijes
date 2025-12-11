<?php

namespace App\Orchid\Screens\Bonutilise;

use App\Models\Bonutilise;
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
            'bonutilises' => Bonutilise::all(),
        ];
    }

    public function name(): ?string
    {
        return 'Liste des bons utilisés';
    }

    public function description(): ?string
    {
        return 'Tous les bons utilisés enregistrés';
    }

    /**
     * Barre d'action (boutons en haut)
     */
    public function commandBar(): iterable
    {
        return [
            Link::make('Créer un bon utilisé')
                ->icon('plus')
                ->route('platform.bonutilise.edit'),
        ];
    }

    public function layout(): iterable
    {
        return [
            Layout::view('screens.bonutilise.list'), 
        ];
    }

    public function toggleEtat(Request $request)
    {
        $bonutilise = Bonutilise::findOrFail($request->input('id'));
        $bonutilise->etat = !$bonutilise->etat;
        $bonutilise->save();

        Alert::info("État modifié.");
        return redirect()->back();
    }

    public function toggleSpotlight(Request $request)
    {
        $bonutilise = Bonutilise::findOrFail($request->input('id'));
        $bonutilise->spotlight = !$bonutilise->spotlight;
        $bonutilise->save();

        Alert::info("Spotlight modifié.");
        return redirect()->back();
    }

    public function delete(Request $request)
    {
        $bonutilise = Bonutilise::findOrFail($request->input('bonutilise'));
        $bonutilise->delete();

        Alert::info("Bon utilisé supprimé.");
        return redirect()->back();
    }
}
