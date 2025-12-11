<?php

namespace App\Orchid\Screens\Conseiller;

use App\Models\Conseiller;
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
            'conseillers' => Conseiller::all(),
        ];
    }

    public function name(): ?string
    {
        return 'Liste des conseillers';
    }

    public function description(): ?string
    {
        return 'Tous les conseillers enregistrés';
    }

    /**
     * Barre d'action (boutons en haut)
     */
    public function commandBar(): iterable
    {
        return [
            Link::make('Créer un conseiller')
                ->icon('plus')
                ->route('platform.conseiller.edit'),
        ];
    }

    public function layout(): iterable
    {
        return [
            Layout::view('screens.conseiller.list'), 
        ];
    }

    public function toggleEtat(Request $request)
    {
        $conseiller = Conseiller::findOrFail($request->input('id'));
        $conseiller->etat = !$conseiller->etat;
        $conseiller->save();

        Alert::info("État modifié.");
        return redirect()->back();
    }

    public function toggleSpotlight(Request $request)
    {
        $conseiller = Conseiller::findOrFail($request->input('id'));
        $conseiller->spotlight = !$conseiller->spotlight;
        $conseiller->save();

        Alert::info("Spotlight modifié.");
        return redirect()->back();
    }

    public function delete(Request $request)
    {
        $conseiller = Conseiller::findOrFail($request->input('conseiller'));
        $conseiller->delete();

        Alert::info("Conseiller supprimé.");
        return redirect()->back();
    }
}
