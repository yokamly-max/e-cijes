<?php

namespace App\Orchid\Screens\Suivi;

use App\Models\Suivi;
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
            'suivis' => Suivi::all(),
        ];
    }

    public function name(): ?string
    {
        return 'Liste des suivis';
    }

    public function description(): ?string
    {
        return 'Tous les suivis enregistrés';
    }

    /**
     * Barre d'action (boutons en haut)
     */
    public function commandBar(): iterable
    {
        return [
            Link::make('Créer un suivi')
                ->icon('plus')
                ->route('platform.suivi.edit'),
        ];
    }

    public function layout(): iterable
    {
        return [
            Layout::view('screens.suivi.list'), 
        ];
    }

    public function toggleEtat(Request $request)
    {
        $suivi = Suivi::findOrFail($request->input('id'));
        $suivi->etat = !$suivi->etat;
        $suivi->save();

        Alert::info("État modifié.");
        return redirect()->back();
    }

    public function toggleSpotlight(Request $request)
    {
        $suivi = Suivi::findOrFail($request->input('id'));
        $suivi->spotlight = !$suivi->spotlight;
        $suivi->save();

        Alert::info("Spotlight modifié.");
        return redirect()->back();
    }

    public function delete(Request $request)
    {
        $suivi = Suivi::findOrFail($request->input('suivi'));
        $suivi->delete();

        Alert::info("Suivi supprimé.");
        return redirect()->back();
    }
}
