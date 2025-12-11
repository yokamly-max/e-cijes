<?php

namespace App\Orchid\Screens\Accompagnement;

use App\Models\Accompagnement;
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
            'accompagnements' => Accompagnement::all(),
        ];
    }

    public function name(): ?string
    {
        return 'Liste des accompagnements';
    }

    public function description(): ?string
    {
        return 'Tous les accompagnements enregistrés';
    }

    /**
     * Barre d'action (boutons en haut)
     */
    public function commandBar(): iterable
    {
        return [
            Link::make('Créer un accompagnement')
                ->icon('plus')
                ->route('platform.accompagnement.edit'),
        ];
    }

    public function layout(): iterable
    {
        return [
            Layout::view('screens.accompagnement.list'), 
        ];
    }

    public function toggleEtat(Request $request)
    {
        $accompagnement = Accompagnement::findOrFail($request->input('id'));
        $accompagnement->etat = !$accompagnement->etat;
        $accompagnement->save();

        Alert::info("État modifié.");
        return redirect()->back();
    }

    public function toggleSpotlight(Request $request)
    {
        $accompagnement = Accompagnement::findOrFail($request->input('id'));
        $accompagnement->spotlight = !$accompagnement->spotlight;
        $accompagnement->save();

        Alert::info("Spotlight modifié.");
        return redirect()->back();
    }

    public function delete(Request $request)
    {
        $accompagnement = Accompagnement::findOrFail($request->input('accompagnement'));
        $accompagnement->delete();

        Alert::info("Accompagnement supprimé.");
        return redirect()->back();
    }
}
