<?php

namespace App\Orchid\Screens\Quizmembre;

use App\Models\Quizmembre;
use Orchid\Screen\Screen;
use Illuminate\Http\Request;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Alert;
use Orchid\Screen\Actions\Link;

class ListScreen extends Screen
{
    public function query(): iterable
    {
        // 1. Charger les régions locales
        $quizmembres = Quizmembre::all();

        return [
            'quizmembres' => $quizmembres,
        ];
    }

    public function name(): ?string
    {
        return 'Liste des résultats du membre';
    }

    public function description(): ?string
    {
        return 'Tous les résultats du membre enregistrés';
    }

    /**
     * Barre d'action (boutons en haut)
     */
    public function commandBar(): iterable
    {
        return [
            Link::make('Créer un résultat du membre')
                ->icon('plus')
                ->route('platform.quizmembre.edit'),
        ];
    }

    public function layout(): iterable
    {
        return [
            Layout::view('screens.quizmembre.list'), 
        ];
    }

    public function toggleEtat(Request $request)
    {
        $quizmembre = Quizmembre::findOrFail($request->input('id'));
        $quizmembre->etat = !$quizmembre->etat;
        $quizmembre->save();

        Alert::info("État modifié.");
        return redirect()->back();
    }

    public function toggleSpotlight(Request $request)
    {
        $quizmembre = Quizmembre::findOrFail($request->input('id'));
        $quizmembre->spotlight = !$quizmembre->spotlight;
        $quizmembre->save();

        Alert::info("Spotlight modifié.");
        return redirect()->back();
    }

    public function delete(Request $request)
    {
        $quizmembre = Quizmembre::findOrFail($request->input('quizmembre'));
        $quizmembre->delete();

        Alert::info("Résultat du membre supprimé.");
        return redirect()->back();
    }
}
