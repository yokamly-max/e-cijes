<?php

namespace App\Orchid\Screens\Ressourcecompte;

use App\Models\Ressourcecompte;
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
        $ressourcecomptes = Ressourcecompte::all();

        return [
            'ressourcecomptes' => $ressourcecomptes,
        ];
    }

    public function name(): ?string
    {
        return 'Liste des ressources';
    }

    public function description(): ?string
    {
        return 'Toutes les ressources enregistrées';
    }

    /**
     * Barre d'action (boutons en haut)
     */
    public function commandBar(): iterable
    {
        return [
            Link::make('Créer une ressource')
                ->icon('plus')
                ->route('platform.ressourcecompte.edit'),
        ];
    }

    public function layout(): iterable
    {
        return [
            Layout::view('screens.ressourcecompte.list'), 
        ];
    }

    public function toggleEtat(Request $request)
    {
        $ressourcecompte = Ressourcecompte::findOrFail($request->input('id'));
        $ressourcecompte->etat = !$ressourcecompte->etat;
        $ressourcecompte->save();

        Alert::info("État modifié.");
        return redirect()->back();
    }

    public function toggleSpotlight(Request $request)
    {
        $ressourcecompte = Ressourcecompte::findOrFail($request->input('id'));
        $ressourcecompte->spotlight = !$ressourcecompte->spotlight;
        $ressourcecompte->save();

        Alert::info("Spotlight modifié.");
        return redirect()->back();
    }

    public function delete(Request $request)
    {
        $ressourcecompte = Ressourcecompte::findOrFail($request->input('ressourcecompte'));
        $ressourcecompte->delete();

        Alert::info("Ressource supprimée.");
        return redirect()->back();
    }
}
