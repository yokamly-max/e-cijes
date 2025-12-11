<?php

namespace App\Orchid\Screens\Conseillerentreprise;

use App\Models\Conseillerentreprise;
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
            'conseillerentreprises' => Conseillerentreprise::all(),
        ];
    }

    public function name(): ?string
    {
        return 'Liste des attributions de conseillers';
    }

    public function description(): ?string
    {
        return 'Toutes les attributions de conseillers enregistrées';
    }

    /**
     * Barre d'action (boutons en haut)
     */
    public function commandBar(): iterable
    {
        return [
            Link::make('Créer une attribution de conseiller')
                ->icon('plus')
                ->route('platform.conseillerentreprise.edit'),
        ];
    }

    public function layout(): iterable
    {
        return [
            Layout::view('screens.conseillerentreprise.list'), 
        ];
    }

    public function toggleEtat(Request $request)
    {
        $conseillerentreprise = Conseillerentreprise::findOrFail($request->input('id'));
        $conseillerentreprise->etat = !$conseillerentreprise->etat;
        $conseillerentreprise->save();

        Alert::info("État modifié.");
        return redirect()->back();
    }

    public function toggleSpotlight(Request $request)
    {
        $conseillerentreprise = Conseillerentreprise::findOrFail($request->input('id'));
        $conseillerentreprise->spotlight = !$conseillerentreprise->spotlight;
        $conseillerentreprise->save();

        Alert::info("Spotlight modifié.");
        return redirect()->back();
    }

    public function delete(Request $request)
    {
        $conseillerentreprise = Conseillerentreprise::findOrFail($request->input('conseillerentreprise'));
        $conseillerentreprise->delete();

        Alert::info("Attribution de conseiller supprimée.");
        return redirect()->back();
    }
}
