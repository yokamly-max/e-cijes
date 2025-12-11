<?php

namespace App\Orchid\Screens\Parrainage;

use App\Models\Parrainage;
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
            'parrainages' => Parrainage::all(),
        ];
    }

    public function name(): ?string
    {
        return 'Liste des parrainages';
    }

    public function description(): ?string
    {
        return 'Tous les parrainages enregistrés';
    }

    /**
     * Barre d'action (boutons en haut)
     */
    public function commandBar(): iterable
    {
        return [
            Link::make('Créer un parrainage')
                ->icon('plus')
                ->route('platform.parrainage.edit'),
        ];
    }

    public function layout(): iterable
    {
        return [
            Layout::view('screens.parrainage.list'), 
        ];
    }

    public function toggleEtat(Request $request)
    {
        $parrainage = Parrainage::findOrFail($request->input('id'));
        $parrainage->etat = !$parrainage->etat;
        $parrainage->save();

        Alert::info("État modifié.");
        return redirect()->back();
    }

    public function toggleSpotlight(Request $request)
    {
        $parrainage = Parrainage::findOrFail($request->input('id'));
        $parrainage->spotlight = !$parrainage->spotlight;
        $parrainage->save();

        Alert::info("Spotlight modifié.");
        return redirect()->back();
    }

    public function delete(Request $request)
    {
        $parrainage = Parrainage::findOrFail($request->input('parrainage'));
        $parrainage->delete();

        Alert::info("Parrainage supprimé.");
        return redirect()->back();
    }
}
