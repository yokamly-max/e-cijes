<?php

namespace App\Orchid\Screens\Espace;

use App\Models\Espace;
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
        $espaces = Espace::all();

        // 2. Récupérer les pays depuis Supabase
        $paysModel = new Pays();
        $payss = collect($paysModel->all()); // collection d'objets Supabase

        // 3. Associer chaque région avec son pays
        $espaces->transform(function ($espace) use ($payss) {
            $espace->pays = $payss->firstWhere('id', $espace->pays_id);
            return $espace;
        });

        return [
            'espaces' => $espaces,
        ];
    }

    public function name(): ?string
    {
        return 'Liste des espaces';
    }

    public function description(): ?string
    {
        return 'Tous les espaces enregistrés';
    }

    /**
     * Barre d'action (boutons en haut)
     */
    public function commandBar(): iterable
    {
        return [
            Link::make('Créer un espace')
                ->icon('plus')
                ->route('platform.espace.edit'),
        ];
    }

    public function layout(): iterable
    {
        return [
            Layout::view('screens.espace.list'), 
        ];
    }

    public function toggleEtat(Request $request)
    {
        $espace = Espace::findOrFail($request->input('id'));
        $espace->etat = !$espace->etat;
        $espace->save();

        Alert::info("État modifié.");
        return redirect()->back();
    }

    public function toggleSpotlight(Request $request)
    {
        $espace = Espace::findOrFail($request->input('id'));
        $espace->spotlight = !$espace->spotlight;
        $espace->save();

        Alert::info("Spotlight modifié.");
        return redirect()->back();
    }

    public function delete(Request $request)
    {
        $espace = Espace::findOrFail($request->input('espace'));
        $espace->delete();

        Alert::info("Espace supprimé.");
        return redirect()->back();
    }
}
