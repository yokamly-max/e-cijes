<?php

namespace App\Orchid\Screens\Quizquestion;

use App\Models\Quizquestion;
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
        $quizquestions = Quizquestion::all();

        return [
            'quizquestions' => $quizquestions,
        ];
    }

    public function name(): ?string
    {
        return 'Liste des questions du quiz';
    }

    public function description(): ?string
    {
        return 'Toutes les questions du quiz enregistrées';
    }

    /**
     * Barre d'action (boutons en haut)
     */
    public function commandBar(): iterable
    {
        return [
            Link::make('Créer une question du quiz')
                ->icon('plus')
                ->route('platform.quizquestion.edit'),
        ];
    }

    public function layout(): iterable
    {
        return [
            Layout::view('screens.quizquestion.list'), 
        ];
    }

    public function toggleEtat(Request $request)
    {
        $quizquestion = Quizquestion::findOrFail($request->input('id'));
        $quizquestion->etat = !$quizquestion->etat;
        $quizquestion->save();

        Alert::info("État modifié.");
        return redirect()->back();
    }

    public function toggleSpotlight(Request $request)
    {
        $quizquestion = Quizquestion::findOrFail($request->input('id'));
        $quizquestion->spotlight = !$quizquestion->spotlight;
        $quizquestion->save();

        Alert::info("Spotlight modifié.");
        return redirect()->back();
    }

    public function delete(Request $request)
    {
        $quizquestion = Quizquestion::findOrFail($request->input('quizquestion'));
        $quizquestion->delete();

        Alert::info("Question du quiz supprimée.");
        return redirect()->back();
    }
}
