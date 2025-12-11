<?php

namespace App\Orchid\Screens\Quiz;

use App\Models\Quiz;
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
        $quizs = Quiz::all();

        return [
            'quizs' => $quizs,
        ];
    }

    public function name(): ?string
    {
        return 'Liste des quizs';
    }

    public function description(): ?string
    {
        return 'Tous les quiz enregistrés';
    }

    /**
     * Barre d'action (boutons en haut)
     */
    public function commandBar(): iterable
    {
        return [
            Link::make('Créer un quiz')
                ->icon('plus')
                ->route('platform.quiz.edit'),
        ];
    }

    public function layout(): iterable
    {
        return [
            Layout::view('screens.quiz.list'), 
        ];
    }

    public function toggleEtat(Request $request)
    {
        $quiz = Quiz::findOrFail($request->input('id'));
        $quiz->etat = !$quiz->etat;
        $quiz->save();

        Alert::info("État modifié.");
        return redirect()->back();
    }

    public function toggleSpotlight(Request $request)
    {
        $quiz = Quiz::findOrFail($request->input('id'));
        $quiz->spotlight = !$quiz->spotlight;
        $quiz->save();

        Alert::info("Spotlight modifié.");
        return redirect()->back();
    }

    public function delete(Request $request)
    {
        $quiz = Quiz::findOrFail($request->input('quiz'));
        $quiz->delete();

        Alert::info("Quiz supprimé.");
        return redirect()->back();
    }
}
