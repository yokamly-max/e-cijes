<?php

namespace App\Orchid\Screens\Expert;

use App\Models\Expert;
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
            'experts' => Expert::all(),
        ];
    }

    public function name(): ?string
    {
        return 'Liste des experts';
    }

    public function description(): ?string
    {
        return 'Tous les experts enregistrés';
    }

    /**
     * Barre d'action (boutons en haut)
     */
    public function commandBar(): iterable
    {
        return [
            Link::make('Créer un expert')
                ->icon('plus')
                ->route('platform.expert.edit'),
        ];
    }

    public function layout(): iterable
    {
        return [
            Layout::view('screens.expert.list'), 
        ];
    }

    public function toggleEtat(Request $request)
    {
        $expert = Expert::findOrFail($request->input('id'));
        $expert->etat = !$expert->etat;
        $expert->save();

        Alert::info("État modifié.");
        return redirect()->back();
    }

    public function toggleSpotlight(Request $request)
    {
        $expert = Expert::findOrFail($request->input('id'));
        $expert->spotlight = !$expert->spotlight;
        $expert->save();

        Alert::info("Spotlight modifié.");
        return redirect()->back();
    }

    public function delete(Request $request)
    {
        $expert = Expert::findOrFail($request->input('expert'));
        $expert->delete();

        Alert::info("Expert supprimé.");
        return redirect()->back();
    }
}
