<?php

namespace App\Orchid\Screens\Evenementinscription;

use App\Models\Evenementinscription;
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
            'evenementinscriptions' => Evenementinscription::all(),
        ];
    }

    public function name(): ?string
    {
        return 'Liste des inscriptions à l\'évènement';
    }

    public function description(): ?string
    {
        return 'Toutes les inscriptions à l\'évènement enregistrées';
    }

    /**
     * Barre d'action (boutons en haut)
     */
    public function commandBar(): iterable
    {
        return [
            Link::make('Créer une inscription à l\'évènement')
                ->icon('plus')
                ->route('platform.evenementinscription.edit'),
        ];
    }

    public function layout(): iterable
    {
        return [
            Layout::view('screens.evenementinscription.list'), 
        ];
    }

    public function toggleEtat(Request $request)
    {
        $evenementinscription = Evenementinscription::findOrFail($request->input('id'));
        $evenementinscription->etat = !$evenementinscription->etat;
        $evenementinscription->save();

        Alert::info("État modifié.");
        return redirect()->back();
    }

    public function toggleSpotlight(Request $request)
    {
        $evenementinscription = Evenementinscription::findOrFail($request->input('id'));
        $evenementinscription->spotlight = !$evenementinscription->spotlight;
        $evenementinscription->save();

        Alert::info("Spotlight modifié.");
        return redirect()->back();
    }

    public function delete(Request $request)
    {
        $evenementinscription = Evenementinscription::findOrFail($request->input('evenementinscription'));
        $evenementinscription->delete();

        Alert::info("Inscription à l'évènement supprimée.");
        return redirect()->back();
    }
}
