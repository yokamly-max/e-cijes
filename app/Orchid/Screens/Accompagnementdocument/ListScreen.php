<?php

namespace App\Orchid\Screens\Accompagnementdocument;

use App\Models\Accompagnementdocument;
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
            'accompagnementdocuments' => Accompagnementdocument::all(),
        ];
    }

    public function name(): ?string
    {
        return 'Liste des documents d\'accompagnement';
    }

    public function description(): ?string
    {
        return 'Tous les documents d\'accompagnement enregistrés';
    }

    /**
     * Barre d'action (boutons en haut)
     */
    public function commandBar(): iterable
    {
        return [
            Link::make('Créer un document')
                ->icon('plus')
                ->route('platform.accompagnementdocument.edit'),
        ];
    }

    public function layout(): iterable
    {
        return [
            Layout::view('screens.accompagnementdocument.list'), 
        ];
    }

    public function toggleEtat(Request $request)
    {
        $accompagnementdocument = Accompagnementdocument::findOrFail($request->input('id'));
        $accompagnementdocument->etat = !$accompagnementdocument->etat;
        $accompagnementdocument->save();

        Alert::info("État modifié.");
        return redirect()->back();
    }

    public function toggleSpotlight(Request $request)
    {
        $accompagnementdocument = Accompagnementdocument::findOrFail($request->input('id'));
        $accompagnementdocument->spotlight = !$accompagnementdocument->spotlight;
        $accompagnementdocument->save();

        Alert::info("Spotlight modifié.");
        return redirect()->back();
    }

    public function delete(Request $request)
    {
        $accompagnementdocument = Accompagnementdocument::findOrFail($request->input('accompagnementdocument'));
        $accompagnementdocument->delete();

        Alert::info("Document supprimé.");
        return redirect()->back();
    }
}
