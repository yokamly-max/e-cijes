<?php

namespace App\Orchid\Screens\Pagelibre;

use App\Models\Pagelibre;
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
        $pagelibres = Pagelibre::all();

        // 3. Charger toutes les langues depuis Supabase
        $langueModel = new Langue();
        $langues = collect($langueModel->all()); // Collection d'objets

        // 4. Associer à chaque actualité sa langue
        $pagelibres->transform(function ($pagelibre) use ($langues) {
            $pagelibre->langue = $langues->firstWhere('id', $pagelibre->langue_id);
            return $pagelibre;
        });

        return [
            'pagelibres' => $pagelibres,
        ];
    }

    public function name(): ?string
    {
        return 'Liste des pages de présentation';
    }

    public function description(): ?string
    {
        return 'Toutes les pages de présentation enregistrées';
    }

    /**
     * Barre d'action (boutons en haut)
     */
    public function commandBar(): iterable
    {
        return [
            Link::make('Créer une page de présentation')
                ->icon('plus')
                ->route('platform.pagelibre.edit'),
        ];
    }

    public function layout(): iterable
    {
        return [
            Layout::view('screens.pagelibre.list'), 
        ];
    }

    public function toggleEtat(Request $request)
    {
        $pagelibre = Pagelibre::findOrFail($request->input('id'));
        $pagelibre->etat = !$pagelibre->etat;
        $pagelibre->save();

        Alert::info("État modifié.");
        return redirect()->back();
    }

    public function toggleSpotlight(Request $request)
    {
        $pagelibre = Pagelibre::findOrFail($request->input('id'));
        $pagelibre->spotlight = !$pagelibre->spotlight;
        $pagelibre->save();

        Alert::info("Spotlight modifié.");
        return redirect()->back();
    }

    public function delete(Request $request)
    {
        $pagelibre = Pagelibre::findOrFail($request->input('pagelibre'));
        $pagelibre->delete();

        Alert::info("Page de présentation supprimée.");
        return redirect()->back();
    }
}
