<?php

namespace App\Orchid\Screens\Entreprise;

use App\Models\Entreprise;
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
        $entreprises = Entreprise::all();

        // 2. Récupérer les pays depuis Supabase
        $paysModel = new Pays();
        $payss = collect($paysModel->all()); // collection d'objets Supabase

        // 3. Associer chaque région avec son pays
        $entreprises->transform(function ($entreprise) use ($payss) {
            $entreprise->pays = $payss->firstWhere('id', $entreprise->pays_id);
            return $entreprise;
        });

        return [
            'entreprises' => $entreprises,
        ];
    }

    public function name(): ?string
    {
        return 'Liste des entreprises';
    }

    public function description(): ?string
    {
        return 'Toutes les entreprises enregistrées';
    }

    /**
     * Barre d'action (boutons en haut)
     */
    public function commandBar(): iterable
    {
        return [
            Link::make('Créer une entreprise')
                ->icon('plus')
                ->route('platform.entreprise.edit'),
        ];
    }

    public function layout(): iterable
    {
        return [
            Layout::view('screens.entreprise.list'), 
        ];
    }

    public function toggleEtat(Request $request)
    {
        $entreprise = Entreprise::findOrFail($request->input('id'));
        $entreprise->etat = !$entreprise->etat;
        $entreprise->save();

        Alert::info("État modifié.");
        return redirect()->back();
    }

    public function toggleSpotlight(Request $request)
    {
        $entreprise = Entreprise::findOrFail($request->input('id'));
        $entreprise->spotlight = !$entreprise->spotlight;
        $entreprise->save();

        Alert::info("Spotlight modifié.");
        return redirect()->back();
    }

    public function delete(Request $request)
    {
        $entreprise = Entreprise::findOrFail($request->input('entreprise'));
        $entreprise->delete();

        Alert::info("Entreprise supprimée.");
        return redirect()->back();
    }
}
