<?php

namespace App\Orchid\Screens\Sujet;

use App\Models\Sujet;
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
            'sujets' => Sujet::all(),
        ];
    }

    public function name(): ?string
    {
        return 'Liste des sujets';
    }

    public function description(): ?string
    {
        return 'Tous les sujets enregistrés';
    }

    /**
     * Barre d'action (boutons en haut)
     */
    public function commandBar(): iterable
    {
        return [
            Link::make('Créer un sujet')
                ->icon('plus')
                ->route('platform.sujet.edit'),
        ];
    }

    public function layout(): iterable
    {
        return [
            Layout::view('screens.sujet.list'), 
        ];
    }

    public function toggleEtat(Request $request)
    {
        $sujet = Sujet::findOrFail($request->input('id'));
        $sujet->etat = !$sujet->etat;
        $sujet->save();

        Alert::info("État modifié.");
        return redirect()->back();
    }

    public function toggleSpotlight(Request $request)
    {
        $sujet = Sujet::findOrFail($request->input('id'));
        $sujet->spotlight = !$sujet->spotlight;
        $sujet->save();

        Alert::info("Spotlight modifié.");
        return redirect()->back();
    }

    public function delete(Request $request)
    {
        $sujet = Sujet::findOrFail($request->input('sujet'));
        $sujet->delete();

        Alert::info("Sujet supprimé.");
        return redirect()->back();
    }
}
