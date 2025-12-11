<?php

namespace App\Orchid\Screens\Recompense;

use App\Models\Recompense;
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
            'recompenses' => Recompense::all(),
        ];
    }

    public function name(): ?string
    {
        return 'Liste des récompenses';
    }

    public function description(): ?string
    {
        return 'Toutes les récompenses enregistrées';
    }

    /**
     * Barre d'action (boutons en haut)
     */
    public function commandBar(): iterable
    {
        return [
            Link::make('Créer une récompense')
                ->icon('plus')
                ->route('platform.recompense.edit'),
        ];
    }

    public function layout(): iterable
    {
        return [
            Layout::view('screens.recompense.list'), 
        ];
    }

    public function toggleEtat(Request $request)
    {
        $recompense = Recompense::findOrFail($request->input('id'));
        $recompense->etat = !$recompense->etat;
        $recompense->save();

        Alert::info("État modifié.");
        return redirect()->back();
    }

    public function toggleSpotlight(Request $request)
    {
        $recompense = Recompense::findOrFail($request->input('id'));
        $recompense->spotlight = !$recompense->spotlight;
        $recompense->save();

        Alert::info("Spotlight modifié.");
        return redirect()->back();
    }

    public function delete(Request $request)
    {
        $recompense = Recompense::findOrFail($request->input('recompense'));
        $recompense->delete();

        Alert::info("Récompense supprimée.");
        return redirect()->back();
    }
}
