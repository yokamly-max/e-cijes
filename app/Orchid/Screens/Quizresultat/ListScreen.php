<?php

namespace App\Orchid\Screens\Quizresultat;

use App\Models\Quizresultat;
use Orchid\Screen\Screen;
use Illuminate\Http\Request;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Alert;
use Orchid\Screen\Actions\Link;

class ListScreen extends Screen
{
    public function query(): iterable
    {
        $quizresultats = Quizresultat::all();

        return [
            'quizresultats' => $quizresultats,
        ];
    }

    public function name(): ?string
    {
        return 'Liste des résultats du quiz';
    }

    public function description(): ?string
    {
        return 'Tous les résultats du quiz enregistrés';
    }

    /**
     * Barre d'action (boutons en haut)
     */
    public function commandBar(): iterable
    {
        return [
            Link::make('Créer un résultat du quiz')
                ->icon('plus')
                ->route('platform.quizresultat.edit'),
        ];
    }

    public function layout(): iterable
    {
        return [
            Layout::view('screens.quizresultat.list'), 
        ];
    }

    public function toggleEtat(Request $request)
    {
        $quizresultat = Quizresultat::findOrFail($request->input('id'));
        $quizresultat->etat = !$quizresultat->etat;
        $quizresultat->save();

        Alert::info("État modifié.");
        return redirect()->back();
    }

    public function toggleSpotlight(Request $request)
    {
        $quizresultat = Quizresultat::findOrFail($request->input('id'));
        $quizresultat->spotlight = !$quizresultat->spotlight;
        $quizresultat->save();

        Alert::info("Spotlight modifié.");
        return redirect()->back();
    }

    public function delete(Request $request)
    {
        $quizresultat = Quizresultat::findOrFail($request->input('quizresultat'));
        $quizresultat->delete();

        Alert::info("Résultat du quiz supprimé.");
        return redirect()->back();
    }
}
