<?php

namespace App\Orchid\Screens\Newsletter;

use App\Models\Newsletter;
use App\Models\Pays;
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
        $newsletters = Newsletter::all();

        // 2. Récupérer les pays depuis Supabase
        $paysModel = new Pays();
        $payss = collect($paysModel->all()); // collection d'objets Supabase

        // 3. Associer chaque région avec son pays
        $newsletters->transform(function ($newsletter) use ($payss) {
            $newsletter->pays = $payss->firstWhere('id', $newsletter->pays_id);
            return $newsletter;
        });

        return [
            'newsletters' => $newsletters,
        ];
    }

    public function name(): ?string
    {
        return 'Liste des newsletters';
    }

    public function description(): ?string
    {
        return 'Toutes les newsletters enregistrées';
    }

    /**
     * Barre d'action (boutons en haut)
     */
    public function commandBar(): iterable
    {
        return [
            Link::make('Créer une newsletter')
                ->icon('plus')
                ->route('platform.newsletter.edit'),
        ];
    }

    public function layout(): iterable
    {
        return [
            Layout::view('screens.newsletter.list'), 
        ];
    }

    public function toggleEtat(Request $request)
    {
        $newsletter = Newsletter::findOrFail($request->input('id'));
        $newsletter->etat = !$newsletter->etat;
        $newsletter->save();

        Alert::info("État modifié.");
        return redirect()->back();
    }

    public function toggleSpotlight(Request $request)
    {
        $newsletter = Newsletter::findOrFail($request->input('id'));
        $newsletter->spotlight = !$newsletter->spotlight;
        $newsletter->save();

        Alert::info("Spotlight modifié.");
        return redirect()->back();
    }

    public function delete(Request $request)
    {
        $newsletter = Newsletter::findOrFail($request->input('newsletter'));
        $newsletter->delete();

        Alert::info("Newsletter supprimée.");
        return redirect()->back();
    }
}
