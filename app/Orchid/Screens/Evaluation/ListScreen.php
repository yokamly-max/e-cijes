<?php

namespace App\Orchid\Screens\Evaluation;

use App\Models\Evaluation;
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
            'evaluations' => Evaluation::all(),
        ];
    }

    public function name(): ?string
    {
        return 'Liste des évaluations';
    }

    public function description(): ?string
    {
        return 'Toutes les évaluations enregistrées';
    }

    /**
     * Barre d'action (boutons en haut)
     */
    public function commandBar(): iterable
    {
        return [
            Link::make('Créer une évaluation')
                ->icon('plus')
                ->route('platform.evaluation.edit'),
        ];
    }

    public function layout(): iterable
    {
        return [
            Layout::view('screens.evaluation.list'), 
        ];
    }

    public function toggleEtat(Request $request)
    {
        $evaluation = Evaluation::findOrFail($request->input('id'));
        $evaluation->etat = !$evaluation->etat;
        $evaluation->save();

        Alert::info("État modifié.");
        return redirect()->back();
    }

    public function toggleSpotlight(Request $request)
    {
        $evaluation = Evaluation::findOrFail($request->input('id'));
        $evaluation->spotlight = !$evaluation->spotlight;
        $evaluation->save();

        Alert::info("Spotlight modifié.");
        return redirect()->back();
    }

    public function delete(Request $request)
    {
        $evaluation = Evaluation::findOrFail($request->input('evaluation'));
        $evaluation->delete();

        Alert::info("Evaluation supprimée.");
        return redirect()->back();
    }
}
