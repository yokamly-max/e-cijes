<?php

namespace App\Orchid\Screens\Accompagnementconseiller;

use App\Models\Accompagnementconseiller;
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
            'accompagnementconseillers' => Accompagnementconseiller::all(),
        ];
    }

    public function name(): ?string
    {
        return 'Liste des conseillers des accompagnements';
    }

    public function description(): ?string
    {
        return 'Tous les conseillers des accompagnements enregistrés';
    }

    /**
     * Barre d'action (boutons en haut)
     */
    public function commandBar(): iterable
    {
        return [
            Link::make('Créer un conseiller de l\'accompagnement')
                ->icon('plus')
                ->route('platform.accompagnementconseiller.edit'),
        ];
    }

    public function layout(): iterable
    {
        return [
            Layout::view('screens.accompagnementconseiller.list'), 
        ];
    }

    public function toggleEtat(Request $request)
    {
        $accompagnementconseiller = Accompagnementconseiller::findOrFail($request->input('id'));
        $accompagnementconseiller->etat = !$accompagnementconseiller->etat;
        $accompagnementconseiller->save();

        Alert::info("État modifié.");
        return redirect()->back();
    }

    public function toggleSpotlight(Request $request)
    {
        $accompagnementconseiller = Accompagnementconseiller::findOrFail($request->input('id'));
        $accompagnementconseiller->spotlight = !$accompagnementconseiller->spotlight;
        $accompagnementconseiller->save();

        Alert::info("Spotlight modifié.");
        return redirect()->back();
    }

    public function delete(Request $request)
    {
        $accompagnementconseiller = Accompagnementconseiller::findOrFail($request->input('accompagnementconseiller'));
        $accompagnementconseiller->delete();

        Alert::info("Conseiller de l'accompagnement supprimé.");
        return redirect()->back();
    }
}
