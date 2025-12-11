<?php

namespace App\Orchid\Screens\Action;

use App\Models\Action;
use App\Models\Pays;
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
        $actions = Action::all();

        return [
            'actions' => $actions,
        ];
    }

    public function name(): ?string
    {
        return 'Liste des actions';
    }

    public function description(): ?string
    {
        return 'Toutes les actions enregistrées';
    }

    /**
     * Barre d'action (boutons en haut)
     */
    public function commandBar(): iterable
    {
        return [
            Link::make('Créer une action')
                ->icon('plus')
                ->route('platform.action.edit'),
        ];
    }

    public function layout(): iterable
    {
        return [
            Layout::view('screens.action.list'), 
        ];
    }

    public function toggleEtat(Request $request)
    {
        $action = Action::findOrFail($request->input('id'));
        $action->etat = !$action->etat;
        $action->save();

        Alert::info("État modifié.");
        return redirect()->back();
    }

    public function toggleSpotlight(Request $request)
    {
        $action = Action::findOrFail($request->input('id'));
        $action->spotlight = !$action->spotlight;
        $action->save();

        Alert::info("Spotlight modifié.");
        return redirect()->back();
    }

    public function delete(Request $request)
    {
        $action = Action::findOrFail($request->input('action'));
        $action->delete();

        Alert::info("Action supprimée.");
        return redirect()->back();
    }
}
