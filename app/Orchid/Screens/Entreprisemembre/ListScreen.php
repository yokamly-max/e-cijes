<?php

namespace App\Orchid\Screens\Entreprisemembre;

use App\Models\Entreprisemembre;
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
            'entreprisemembres' => Entreprisemembre::all(),
        ];
    }

    public function name(): ?string
    {
        return 'Liste des membres de l\'entreprise';
    }

    public function description(): ?string
    {
        return 'Tous les membres de l\'entreprise enregistrés';
    }

    /**
     * Barre d'action (boutons en haut)
     */
    public function commandBar(): iterable
    {
        return [
            Link::make('Créer un membre de l\'entreprise')
                ->icon('plus')
                ->route('platform.entreprisemembre.edit'),
        ];
    }

    public function layout(): iterable
    {
        return [
            Layout::view('screens.entreprisemembre.list'), 
        ];
    }

    public function toggleEtat(Request $request)
    {
        $entreprisemembre = Entreprisemembre::findOrFail($request->input('id'));
        $entreprisemembre->etat = !$entreprisemembre->etat;
        $entreprisemembre->save();

        Alert::info("État modifié.");
        return redirect()->back();
    }

    public function toggleSpotlight(Request $request)
    {
        $entreprisemembre = Entreprisemembre::findOrFail($request->input('id'));
        $entreprisemembre->spotlight = !$entreprisemembre->spotlight;
        $entreprisemembre->save();

        Alert::info("Spotlight modifié.");
        return redirect()->back();
    }

    public function delete(Request $request)
    {
        $entreprisemembre = Entreprisemembre::findOrFail($request->input('entreprisemembre'));
        $entreprisemembre->delete();

        Alert::info("Membre de l\'entreprise supprimé.");
        return redirect()->back();
    }
}
