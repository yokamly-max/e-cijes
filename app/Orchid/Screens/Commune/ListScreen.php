<?php

namespace App\Orchid\Screens\Commune;

use App\Models\Commune;
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
            'communes' => Commune::with('prefecture')->get(),
        ];
    }

    public function name(): ?string
    {
        return 'Liste des communes';
    }

    public function description(): ?string
    {
        return 'Toutes les communes enregistrées';
    }

    /**
     * Barre d'action (boutons en haut)
     */
    public function commandBar(): iterable
    {
        return [
            Link::make('Créer une commune')
                ->icon('plus')
                ->route('platform.commune.edit'),
        ];
    }

    public function layout(): iterable
    {
        return [
            Layout::view('screens.commune.list'), // ✅ CORRECT : Utilise Layout::view()
        ];
    }

    public function toggleEtat(Request $request)
    {
        $commune = Commune::findOrFail($request->input('id'));
        $commune->etat = !$commune->etat;
        $commune->save();

        Alert::info("État modifié.");
        return redirect()->back();
    }

    public function delete(Request $request)
    {
        $commune = Commune::findOrFail($request->input('commune'));
        $commune->delete();

        Alert::info("Commune supprimée.");
        return redirect()->back();
    }
}
