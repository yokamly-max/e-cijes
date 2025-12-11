<?php

namespace App\Orchid\Screens\Prestationressource;

use App\Models\Prestationressource;
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
            'prestationressources' => Prestationressource::all(),
        ];
    }

    public function name(): ?string
    {
        return 'Liste des paiements des prestations';
    }

    public function description(): ?string
    {
        return 'Tous les paiements des prestations enregistrés';
    }

    /**
     * Barre d'action (boutons en haut)
     */
    public function commandBar(): iterable
    {
        return [
            Link::make('Créer un paiement de la prestation')
                ->icon('plus')
                ->route('platform.prestationressource.edit'),
        ];
    }

    public function layout(): iterable
    {
        return [
            Layout::view('screens.prestationressource.list'), 
        ];
    }

    public function toggleEtat(Request $request)
    {
        $prestationressource = Prestationressource::findOrFail($request->input('id'));
        $prestationressource->etat = !$prestationressource->etat;
        $prestationressource->save();

        Alert::info("État modifié.");
        return redirect()->back();
    }

    public function toggleSpotlight(Request $request)
    {
        $prestationressource = Prestationressource::findOrFail($request->input('id'));
        $prestationressource->spotlight = !$prestationressource->spotlight;
        $prestationressource->save();

        Alert::info("Spotlight modifié.");
        return redirect()->back();
    }

    public function delete(Request $request)
    {
        $prestationressource = Prestationressource::findOrFail($request->input('prestationressource'));
        $prestationressource->delete();

        Alert::info("Paiement de la prestation supprimé.");
        return redirect()->back();
    }
}
