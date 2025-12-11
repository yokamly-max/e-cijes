<?php

namespace App\Orchid\Screens\Evenement;

use App\Models\Evenement;
use App\Models\Pays;
use App\Models\Langue;
use Orchid\Screen\Screen;
use Illuminate\Http\Request;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Alert;
use Orchid\Screen\Actions\Link;

class ListScreen extends Screen
{
    public function query(): iterable
    {
        // 1. Charger toutes les évènements locales
        $evenements = Evenement::all();

        // 2. Charger tous les pays depuis Supabase
        $paysModel = new Pays();
        $payss = collect($paysModel->all()); // Collection d'objets

        // 3. Charger toutes les langues depuis Supabase
        $langueModel = new Langue();
        $langues = collect($langueModel->all()); // Collection d'objets

        // 4. Associer à chaque évènement son pays et sa langue
        $evenements->transform(function ($evenement) use ($payss, $langues) {
            $evenement->pays = $payss->firstWhere('id', $evenement->pays_id);
            $evenement->langue = $langues->firstWhere('id', $evenement->langue_id);
            return $evenement;
        });

        return [
            'evenements' => $evenements,
        ];
    }

    public function name(): ?string
    {
        return 'Liste des évènements';
    }

    public function description(): ?string
    {
        return 'Toutes les évènements enregistrées';
    }

    /**
     * Barre d'action (boutons en haut)
     */
    public function commandBar(): iterable
    {
        return [
            Link::make('Créer une évènement')
                ->icon('plus')
                ->route('platform.evenement.edit'),
        ];
    }

    public function layout(): iterable
    {
        return [
            Layout::view('screens.evenement.list'), 
        ];
    }

    public function toggleEtat(Request $request)
    {
        $evenement = Evenement::findOrFail($request->input('id'));
        $evenement->etat = !$evenement->etat;
        $evenement->save();

        Alert::info("État modifié.");
        return redirect()->back();
    }

    public function toggleSpotlight(Request $request)
    {
        $evenement = Evenement::findOrFail($request->input('id'));
        $evenement->spotlight = !$evenement->spotlight;
        $evenement->save();

        Alert::info("Spotlight modifié.");
        return redirect()->back();
    }

    public function delete(Request $request)
    {
        $evenement = Evenement::findOrFail($request->input('evenement'));
        $evenement->delete();

        Alert::info("Évènement supprimée.");
        return redirect()->back();
    }
}
