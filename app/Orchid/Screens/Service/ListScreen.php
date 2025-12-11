<?php

namespace App\Orchid\Screens\Service;

use App\Models\Service;
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
        // 1. Charger toutes les actualités locales
        $services = Service::all();

        // 2. Charger tous les pays depuis Supabase
        $paysModel = new Pays();
        $payss = collect($paysModel->all()); // Collection d'objets

        // 3. Charger toutes les langues depuis Supabase
        $langueModel = new Langue();
        $langues = collect($langueModel->all()); // Collection d'objets

        // 4. Associer à chaque actualité son pays et sa langue
        $services->transform(function ($service) use ($payss, $langues) {
            $service->pays = $payss->firstWhere('id', $service->pays_id);
            $service->langue = $langues->firstWhere('id', $service->langue_id);
            return $service;
        });

        return [
            'services' => $services,
        ];
    }

    public function name(): ?string
    {
        return 'Liste des services';
    }

    public function description(): ?string
    {
        return 'Tous les services enregistrés';
    }

    /**
     * Barre d'action (boutons en haut)
     */
    public function commandBar(): iterable
    {
        return [
            Link::make('Créer un service')
                ->icon('plus')
                ->route('platform.service.edit'),
        ];
    }

    public function layout(): iterable
    {
        return [
            Layout::view('screens.service.list'), 
        ];
    }

    public function toggleEtat(Request $request)
    {
        $service = Service::findOrFail($request->input('id'));
        $service->etat = !$service->etat;
        $service->save();

        Alert::info("État modifié.");
        return redirect()->back();
    }

    public function toggleSpotlight(Request $request)
    {
        $service = Service::findOrFail($request->input('id'));
        $service->spotlight = !$service->spotlight;
        $service->save();

        Alert::info("Spotlight modifié.");
        return redirect()->back();
    }

    public function delete(Request $request)
    {
        $service = Service::findOrFail($request->input('service'));
        $service->delete();

        Alert::info("Service supprimé.");
        return redirect()->back();
    }
}
