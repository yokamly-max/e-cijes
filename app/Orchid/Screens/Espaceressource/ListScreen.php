<?php

namespace App\Orchid\Screens\Espaceressource;

use App\Models\Espaceressource;
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
            'espaceressources' => Espaceressource::all(),
        ];
    }

    public function name(): ?string
    {
        return 'Liste des paiements des espaces';
    }

    public function description(): ?string
    {
        return 'Tous les paiements des espaces enregistrés';
    }

    /**
     * Barre d'action (boutons en haut)
     */
    public function commandBar(): iterable
    {
        return [
            Link::make('Créer un paiement de l\'espace')
                ->icon('plus')
                ->route('platform.espaceressource.edit'),
        ];
    }

    public function layout(): iterable
    {
        return [
            Layout::view('screens.espaceressource.list'), 
        ];
    }

    public function toggleEtat(Request $request)
    {
        $espaceressource = Espaceressource::findOrFail($request->input('id'));
        $espaceressource->etat = !$espaceressource->etat;
        $espaceressource->save();

        Alert::info("État modifié.");
        return redirect()->back();
    }

    public function toggleSpotlight(Request $request)
    {
        $espaceressource = Espaceressource::findOrFail($request->input('id'));
        $espaceressource->spotlight = !$espaceressource->spotlight;
        $espaceressource->save();

        Alert::info("Spotlight modifié.");
        return redirect()->back();
    }

    public function delete(Request $request)
    {
        $espaceressource = Espaceressource::findOrFail($request->input('espaceressource'));
        $espaceressource->delete();

        Alert::info("Paiement de l'espace supprimé.");
        return redirect()->back();
    }
}
