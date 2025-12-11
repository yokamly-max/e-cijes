<?php

namespace App\Orchid\Screens\Messageforum;

use App\Models\Messageforum;
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
            'messageforums' => Messageforum::all(),
        ];
    }

    public function name(): ?string
    {
        return 'Liste des messages';
    }

    public function description(): ?string
    {
        return 'Tous les messages enregistrés';
    }

    /**
     * Barre d'action (boutons en haut)
     */
    public function commandBar(): iterable
    {
        return [
            Link::make('Créer un message')
                ->icon('plus')
                ->route('platform.messageforum.edit'),
        ];
    }

    public function layout(): iterable
    {
        return [
            Layout::view('screens.messageforum.list'), 
        ];
    }

    public function toggleEtat(Request $request)
    {
        $messageforum = Messageforum::findOrFail($request->input('id'));
        $messageforum->etat = !$messageforum->etat;
        $messageforum->save();

        Alert::info("État modifié.");
        return redirect()->back();
    }

    public function toggleSpotlight(Request $request)
    {
        $messageforum = Messageforum::findOrFail($request->input('id'));
        $messageforum->spotlight = !$messageforum->spotlight;
        $messageforum->save();

        Alert::info("Spotlight modifié.");
        return redirect()->back();
    }

    public function delete(Request $request)
    {
        $messageforum = Messageforum::findOrFail($request->input('messageforum'));
        $messageforum->delete();

        Alert::info("Message supprimé.");
        return redirect()->back();
    }
}
