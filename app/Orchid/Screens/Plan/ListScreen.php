<?php

namespace App\Orchid\Screens\Plan;

use App\Models\Plan;
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
            'plans' => Plan::all(),
        ];
    }

    public function name(): ?string
    {
        return 'Liste des plans d\'accompagnements';
    }

    public function description(): ?string
    {
        return 'Tous les plans d\'accompagnements enregistrés';
    }

    /**
     * Barre d'action (boutons en haut)
     */
    public function commandBar(): iterable
    {
        return [
            Link::make('Créer un plan')
                ->icon('plus')
                ->route('platform.plan.edit'),
        ];
    }

    public function layout(): iterable
    {
        return [
            Layout::view('screens.plan.list'), 
        ];
    }

    public function toggleEtat(Request $request)
    {
        $plan = Plan::findOrFail($request->input('id'));
        $plan->etat = !$plan->etat;
        $plan->save();

        Alert::info("État modifié.");
        return redirect()->back();
    }

    public function toggleSpotlight(Request $request)
    {
        $plan = Plan::findOrFail($request->input('id'));
        $plan->spotlight = !$plan->spotlight;
        $plan->save();

        Alert::info("Spotlight modifié.");
        return redirect()->back();
    }

    public function delete(Request $request)
    {
        $plan = Plan::findOrFail($request->input('plan'));
        $plan->delete();

        Alert::info("Plan supprimé.");
        return redirect()->back();
    }
}
