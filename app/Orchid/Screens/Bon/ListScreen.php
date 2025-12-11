<?php

namespace App\Orchid\Screens\Bon;

use App\Models\Bon;
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
        $bons = Bon::all();

        // 2. Récupérer les pays depuis Supabase
        $paysModel = new Pays();
        $payss = collect($paysModel->all()); // collection d'objets Supabase

        // 3. Associer chaque région avec son pays
        $bons->transform(function ($bon) use ($payss) {
            $bon->pays = $payss->firstWhere('id', $bon->pays_id);
            return $bon;
        });

        return [
            'bons' => $bons,
        ];
    }

    public function name(): ?string
    {
        return 'Liste des bons';
    }

    public function description(): ?string
    {
        return 'Tous les bons enregistrés';
    }

    /**
     * Barre d'action (boutons en haut)
     */
    public function commandBar(): iterable
    {
        return [
            Link::make('Créer un bon')
                ->icon('plus')
                ->route('platform.bon.edit'),
        ];
    }

    public function layout(): iterable
    {
        return [
            Layout::view('screens.bon.list'), 
        ];
    }

    public function toggleEtat(Request $request)
    {
        $bon = Bon::findOrFail($request->input('id'));
        $bon->etat = !$bon->etat;
        $bon->save();

        Alert::info("État modifié.");
        return redirect()->back();
    }

    public function toggleSpotlight(Request $request)
    {
        $bon = Bon::findOrFail($request->input('id'));
        $bon->spotlight = !$bon->spotlight;
        $bon->save();

        Alert::info("Spotlight modifié.");
        return redirect()->back();
    }

    public function delete(Request $request)
    {
        $bon = Bon::findOrFail($request->input('bon'));
        $bon->delete();

        Alert::info("Bon supprimé.");
        return redirect()->back();
    }
}
