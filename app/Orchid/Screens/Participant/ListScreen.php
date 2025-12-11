<?php

namespace App\Orchid\Screens\Participant;

use App\Models\Participant;
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
            'participants' => Participant::all(),
        ];
    }

    public function name(): ?string
    {
        return 'Liste des participations';
    }

    public function description(): ?string
    {
        return 'Toutes les participations enregistrées';
    }

    /**
     * Barre d'action (boutons en haut)
     */
    public function commandBar(): iterable
    {
        return [
            Link::make('Créer une participation')
                ->icon('plus')
                ->route('platform.participant.edit'),
        ];
    }

    public function layout(): iterable
    {
        return [
            Layout::view('screens.participant.list'), 
        ];
    }

    public function toggleEtat(Request $request)
    {
        $participant = Participant::findOrFail($request->input('id'));
        $participant->etat = !$participant->etat;
        $participant->save();

        Alert::info("État modifié.");
        return redirect()->back();
    }

    public function toggleSpotlight(Request $request)
    {
        $participant = Participant::findOrFail($request->input('id'));
        $participant->spotlight = !$participant->spotlight;
        $participant->save();

        Alert::info("Spotlight modifié.");
        return redirect()->back();
    }

    public function delete(Request $request)
    {
        $participant = Participant::findOrFail($request->input('participant'));
        $participant->delete();

        Alert::info("Participation supprimée.");
        return redirect()->back();
    }
}
