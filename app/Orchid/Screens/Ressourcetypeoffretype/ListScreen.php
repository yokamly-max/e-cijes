<?php

namespace App\Orchid\Screens\Ressourcetypeoffretype;

use App\Models\Ressourcetypeoffretype;
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
            'ressourcetypeoffretypes' => Ressourcetypeoffretype::all(),
        ];
    }

    public function name(): ?string
    {
        return 'Liste des types des paiements';
    }

    public function description(): ?string
    {
        return 'Tous les types des paiements enregistrés';
    }

    /**
     * Barre d'action (boutons en haut)
     */
    public function commandBar(): iterable
    {
        return [
            Link::make('Créer un type de paiement')
                ->icon('plus')
                ->route('platform.ressourcetypeoffretype.edit'),
        ];
    }

    public function layout(): iterable
    {
        return [
            Layout::view('screens.ressourcetypeoffretype.list'), 
        ];
    }

    public function toggleEtat(Request $request)
    {
        $ressourcetypeoffretype = Ressourcetypeoffretype::findOrFail($request->input('id'));
        $ressourcetypeoffretype->etat = !$ressourcetypeoffretype->etat;
        $ressourcetypeoffretype->save();

        Alert::info("État modifié.");
        return redirect()->back();
    }

    public function toggleSpotlight(Request $request)
    {
        $ressourcetypeoffretype = Ressourcetypeoffretype::findOrFail($request->input('id'));
        $ressourcetypeoffretype->spotlight = !$ressourcetypeoffretype->spotlight;
        $ressourcetypeoffretype->save();

        Alert::info("Spotlight modifié.");
        return redirect()->back();
    }

    public function delete(Request $request)
    {
        $ressourcetypeoffretype = Ressourcetypeoffretype::findOrFail($request->input('ressourcetypeoffretype'));
        $ressourcetypeoffretype->delete();

        Alert::info("Type de paiement supprimé.");
        return redirect()->back();
    }
}
