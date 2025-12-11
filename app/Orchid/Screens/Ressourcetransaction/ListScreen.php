<?php

namespace App\Orchid\Screens\Ressourcetransaction;

use App\Models\Ressourcetransaction;
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
            'ressourcetransactions' => Ressourcetransaction::all(),
        ];
    }

    public function name(): ?string
    {
        return 'Liste des transactions';
    }

    public function description(): ?string
    {
        return 'Toutes les transactions enregistrées';
    }

    /**
     * Barre d'action (boutons en haut)
     */
    public function commandBar(): iterable
    {
        return [
            Link::make('Créer une transaction')
                ->icon('plus')
                ->route('platform.ressourcetransaction.edit'),
        ];
    }

    public function layout(): iterable
    {
        return [
            Layout::view('screens.ressourcetransaction.list'), 
        ];
    }

    public function toggleEtat(Request $request)
    {
        $ressourcetransaction = Ressourcetransaction::findOrFail($request->input('id'));
        $ressourcetransaction->etat = !$ressourcetransaction->etat;
        $ressourcetransaction->save();

        Alert::info("État modifié.");
        return redirect()->back();
    }

    public function toggleSpotlight(Request $request)
    {
        $ressourcetransaction = Ressourcetransaction::findOrFail($request->input('id'));
        $ressourcetransaction->spotlight = !$ressourcetransaction->spotlight;
        $ressourcetransaction->save();

        Alert::info("Spotlight modifié.");
        return redirect()->back();
    }

    public function delete(Request $request)
    {
        $ressourcetransaction = Ressourcetransaction::findOrFail($request->input('ressourcetransaction'));
        $ressourcetransaction->delete();

        Alert::info("Transaction supprimée.");
        return redirect()->back();
    }
}
