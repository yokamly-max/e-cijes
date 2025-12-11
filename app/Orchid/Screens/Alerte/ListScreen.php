<?php

namespace App\Orchid\Screens\Alerte;

use App\Models\Alerte;
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
        // 1. Charger toutes les actualités locales
        $alertes = Alerte::all();

        // 3. Charger toutes les langues depuis Supabase
        $langueModel = new Langue();
        $langues = collect($langueModel->all()); // Collection d'objets

        // 4. Associer à chaque actualité sa langue
        $alertes->transform(function ($alerte) use ($langues) {
            $alerte->langue = $langues->firstWhere('id', $alerte->langue_id);
            return $alerte;
        });

        return [
            'alertes' => $alertes,
        ];
    }

    public function name(): ?string
    {
        return 'Liste des alertes';
    }

    public function description(): ?string
    {
        return 'Toutes les alertes enregistrées';
    }

    /**
     * Barre d'action (boutons en haut)
     */
    public function commandBar(): iterable
    {
        return [
            Link::make('Créer une alerte')
                ->icon('plus')
                ->route('platform.alerte.edit'),
        ];
    }

    public function layout(): iterable
    {
        return [
            Layout::view('screens.alerte.list'), 
        ];
    }

    public function toggleEtat(Request $request)
    {
        $alerte = Alerte::findOrFail($request->input('id'));
        $alerte->etat = !$alerte->etat;
        $alerte->save();

        Alert::info("État modifié.");
        return redirect()->back();
    }

    public function toggleLu(Request $request)
    {
        $alerte = Alerte::findOrFail($request->input('id'));
        $alerte->lu = !$alerte->lu;
        $alerte->save();

        Alert::info("Lu modifié.");
        return redirect()->back();
    }

    public function delete(Request $request)
    {
        $alerte = Alerte::findOrFail($request->input('alerte'));
        $alerte->delete();

        Alert::info("Alerte supprimée.");
        return redirect()->back();
    }
}
