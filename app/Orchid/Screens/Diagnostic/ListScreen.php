<?php

namespace App\Orchid\Screens\Diagnostic;

use App\Models\Diagnostic;
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
            'diagnostics' => Diagnostic::all(),
        ];
    }

    public function name(): ?string
    {
        return 'Liste des diagnostics';
    }

    public function description(): ?string
    {
        return 'Tous les diagnostics enregistrés';
    }

    /**
     * Barre d'action (boutons en haut)
     */
    public function commandBar(): iterable
    {
        return [
            Link::make('Créer un diagnostic')
                ->icon('plus')
                ->route('platform.diagnostic.edit'),
        ];
    }

    public function layout(): iterable
    {
        return [
            Layout::view('screens.diagnostic.list'), 
        ];
    }

    public function toggleEtat(Request $request)
    {
        $diagnostic = Diagnostic::findOrFail($request->input('id'));
        $diagnostic->etat = !$diagnostic->etat;
        $diagnostic->save();

        Alert::info("État modifié.");
        return redirect()->back();
    }

    public function toggleSpotlight(Request $request)
    {
        $diagnostic = Diagnostic::findOrFail($request->input('id'));
        $diagnostic->spotlight = !$diagnostic->spotlight;
        $diagnostic->save();

        Alert::info("Spotlight modifié.");
        return redirect()->back();
    }

    public function delete(Request $request)
    {
        $diagnostic = Diagnostic::findOrFail($request->input('diagnostic'));
        $diagnostic->delete();

        Alert::info("Diagnostic supprimé.");
        return redirect()->back();
    }
}
