<?php

namespace App\Orchid\Screens\Quizreponse;

use App\Models\Quizreponse;
use Orchid\Screen\Screen;
use Illuminate\Http\Request;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Alert;
use Orchid\Screen\Actions\Link;

class ListScreen extends Screen
{
    public function query(): iterable
    {
        // 1. Charger les régions locales
        $quizreponses = Quizreponse::all();

        return [
            'quizreponses' => $quizreponses,
        ];
    }

    public function name(): ?string
    {
        return 'Liste des reponses du quiz';
    }

    public function description(): ?string
    {
        return 'Toutes les reponses du quiz enregistrées';
    }

    /**
     * Barre d'action (boutons en haut)
     */
    public function commandBar(): iterable
    {
        return [
            Link::make('Créer une reponse du quiz')
                ->icon('plus')
                ->route('platform.quizreponse.edit'),
        ];
    }

    public function layout(): iterable
    {
        return [
            Layout::view('screens.quizreponse.list'), 
        ];
    }

    public function toggleEtat(Request $request)
    {
        $quizreponse = Quizreponse::findOrFail($request->input('id'));
        $quizreponse->etat = !$quizreponse->etat;
        $quizreponse->save();

        Alert::info("État modifié.");
        return redirect()->back();
    }

    public function toggleSpotlight(Request $request)
    {
        $quizreponse = Quizreponse::findOrFail($request->input('id'));
        $quizreponse->spotlight = !$quizreponse->spotlight;
        $quizreponse->save();

        Alert::info("Spotlight modifié.");
        return redirect()->back();
    }

    public function delete(Request $request)
    {
        $quizreponse = Quizreponse::findOrFail($request->input('quizreponse'));
        $quizreponse->delete();

        Alert::info("Reponse du quiz supprimée.");
        return redirect()->back();
    }

    public function toggleCorrecte(Request $request)
    {
        $quizreponse = Quizreponse::findOrFail($request->input('id'));
        $quizreponse->correcte = !$quizreponse->correcte;
        $quizreponse->save();

        Alert::info("Correcte modifié.");
        return redirect()->back();
    }
}
