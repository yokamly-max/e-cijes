<?php

namespace App\Orchid\Screens\Prestationrealisee;

use App\Models\Prestationrealisee;
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
            'prestationrealisees' => Prestationrealisee::all(),
        ];
    }

    public function name(): ?string
    {
        return 'Liste des réalisations';
    }

    public function description(): ?string
    {
        return 'Toutes les réalisations enregistrées';
    }

    /**
     * Barre d'action (boutons en haut)
     */
    public function commandBar(): iterable
    {
        return [
            Link::make('Créer une réalisation')
                ->icon('plus')
                ->route('platform.prestationrealisee.edit'),
        ];
    }

    public function layout(): iterable
    {
        return [
            Layout::view('screens.prestationrealisee.list'), 
        ];
    }

    public function toggleEtat(Request $request)
    {
        $prestationrealisee = Prestationrealisee::findOrFail($request->input('id'));
        $prestationrealisee->etat = !$prestationrealisee->etat;
        $prestationrealisee->save();

        Alert::info("État modifié.");
        return redirect()->back();
    }

    public function toggleSpotlight(Request $request)
    {
        $prestationrealisee = Prestationrealisee::findOrFail($request->input('id'));
        $prestationrealisee->spotlight = !$prestationrealisee->spotlight;
        $prestationrealisee->save();

        Alert::info("Spotlight modifié.");
        return redirect()->back();
    }

    public function delete(Request $request)
    {
        $prestationrealisee = Prestationrealisee::findOrFail($request->input('prestationrealisee'));
        $prestationrealisee->delete();

        Alert::info("Réalisation supprimée.");
        return redirect()->back();
    }
}
