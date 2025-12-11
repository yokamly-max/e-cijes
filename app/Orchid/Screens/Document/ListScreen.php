<?php

namespace App\Orchid\Screens\Document;

use App\Models\Document;
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
            'documents' => Document::all(),
        ];
    }

    public function name(): ?string
    {
        return 'Liste des documents';
    }

    public function description(): ?string
    {
        return 'Tous les documents enregistrés';
    }

    /**
     * Barre d'action (boutons en haut)
     */
    public function commandBar(): iterable
    {
        return [
            Link::make('Créer un document')
                ->icon('plus')
                ->route('platform.document.edit'),
        ];
    }

    public function layout(): iterable
    {
        return [
            Layout::view('screens.document.list'), 
        ];
    }

    public function toggleEtat(Request $request)
    {
        $document = Document::findOrFail($request->input('id'));
        $document->etat = !$document->etat;
        $document->save();

        Alert::info("État modifié.");
        return redirect()->back();
    }

    public function toggleSpotlight(Request $request)
    {
        $document = Document::findOrFail($request->input('id'));
        $document->spotlight = !$document->spotlight;
        $document->save();

        Alert::info("Spotlight modifié.");
        return redirect()->back();
    }

    public function delete(Request $request)
    {
        $document = Document::findOrFail($request->input('document'));
        $document->delete();

        Alert::info("Document supprimé.");
        return redirect()->back();
    }
}
