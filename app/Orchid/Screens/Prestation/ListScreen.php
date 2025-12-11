<?php

namespace App\Orchid\Screens\Prestation;

use App\Models\Prestation;
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
        $prestations = Prestation::all();

        // 2. Récupérer les pays depuis Supabase
        $paysModel = new Pays();
        $payss = collect($paysModel->all()); // collection d'objets Supabase

        // 3. Associer chaque région avec son pays
        $prestations->transform(function ($prestation) use ($payss) {
            $prestation->pays = $payss->firstWhere('id', $prestation->pays_id);
            return $prestation;
        });

        return [
            'prestations' => $prestations,
        ];
    }

    public function name(): ?string
    {
        return 'Liste des prestations';
    }

    public function description(): ?string
    {
        return 'Toutes les prestations enregistrées';
    }

    /**
     * Barre d'action (boutons en haut)
     */
    public function commandBar(): iterable
    {
        return [
            Link::make('Créer une prestation')
                ->icon('plus')
                ->route('platform.prestation.edit'),
        ];
    }

    public function layout(): iterable
    {
        return [
            Layout::view('screens.prestation.list'), 
        ];
    }

    public function toggleEtat(Request $request)
    {
        $prestation = Prestation::findOrFail($request->input('id'));
        $prestation->etat = !$prestation->etat;
        $prestation->save();

        Alert::info("État modifié.");
        return redirect()->back();
    }

    public function toggleSpotlight(Request $request)
    {
        $prestation = Prestation::findOrFail($request->input('id'));
        $prestation->spotlight = !$prestation->spotlight;
        $prestation->save();

        Alert::info("Spotlight modifié.");
        return redirect()->back();
    }

    public function delete(Request $request)
    {
        $prestation = Prestation::findOrFail($request->input('prestation'));
        $prestation->delete();

        Alert::info("Prestation supprimée.");
        return redirect()->back();
    }
}
