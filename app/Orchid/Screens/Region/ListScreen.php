<?php

namespace App\Orchid\Screens\Region;

use App\Models\Region;
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
        $regions = Region::all();

        // 2. Récupérer les pays depuis Supabase
        $paysModel = new Pays();
        $payss = collect($paysModel->all()); // collection d'objets Supabase

        // 3. Associer chaque région avec son pays
        $regions->transform(function ($region) use ($payss) {
            $region->pays = $payss->firstWhere('id', $region->pays_id);
            return $region;
        });

        return [
            'regions' => $regions,
        ];
    }

    public function name(): ?string
    {
        return 'Liste des régions';
    }

    public function description(): ?string
    {
        return 'Toutes les régions enregistrées';
    }

    /**
     * Barre d'action (boutons en haut)
     */
    public function commandBar(): iterable
    {
        return [
            Link::make('Créer une région')
                ->icon('plus')
                ->route('platform.region.edit'),
        ];
    }

    public function layout(): iterable
    {
        return [
            Layout::view('screens.region.list'), // ✅ CORRECT : Utilise Layout::view()
        ];
    }

    public function toggleEtat(Request $request)
    {
        $region = Region::findOrFail($request->input('id'));
        $region->etat = !$region->etat;
        $region->save();

        Alert::info("État modifié.");
        return redirect()->back();
    }

    public function delete(Request $request)
    {
        $region = Region::findOrFail($request->input('region'));
        $region->delete();

        Alert::info("Région supprimée.");
        return redirect()->back();
    }
}
