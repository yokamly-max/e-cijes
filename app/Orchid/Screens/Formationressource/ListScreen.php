<?php

namespace App\Orchid\Screens\Formationressource;

use App\Models\Formationressource;
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
            'formationressources' => Formationressource::all(),
        ];
    }

    public function name(): ?string
    {
        return 'Liste des paiements des formations';
    }

    public function description(): ?string
    {
        return 'Tous les paiements des formations enregistrés';
    }

    /**
     * Barre d'action (boutons en haut)
     */
    public function commandBar(): iterable
    {
        return [
            Link::make('Créer un paiement de la formation')
                ->icon('plus')
                ->route('platform.formationressource.edit'),
        ];
    }

    public function layout(): iterable
    {
        return [
            Layout::view('screens.formationressource.list'), 
        ];
    }

    public function toggleEtat(Request $request)
    {
        $formationressource = Formationressource::findOrFail($request->input('id'));
        $formationressource->etat = !$formationressource->etat;
        $formationressource->save();

        Alert::info("État modifié.");
        return redirect()->back();
    }

    public function toggleSpotlight(Request $request)
    {
        $formationressource = Formationressource::findOrFail($request->input('id'));
        $formationressource->spotlight = !$formationressource->spotlight;
        $formationressource->save();

        Alert::info("Spotlight modifié.");
        return redirect()->back();
    }

    public function delete(Request $request)
    {
        $formationressource = Formationressource::findOrFail($request->input('formationressource'));
        $formationressource->delete();

        Alert::info("Paiement de la formation supprimé.");
        return redirect()->back();
    }
}
