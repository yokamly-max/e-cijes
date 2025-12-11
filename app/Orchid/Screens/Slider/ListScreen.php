<?php

namespace App\Orchid\Screens\Slider;

use App\Models\Slider;
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
        $sliders = Slider::all();

        // 2. Charger tous les pays depuis Supabase
        $paysModel = new Pays();
        $payss = collect($paysModel->all()); // Collection d'objets

        // 3. Charger toutes les langues depuis Supabase
        $langueModel = new Langue();
        $langues = collect($langueModel->all()); // Collection d'objets

        // 4. Associer à chaque actualité son pays et sa langue
        $sliders->transform(function ($slider) use ($payss, $langues) {
            $slider->pays = $payss->firstWhere('id', $slider->pays_id);
            $slider->langue = $langues->firstWhere('id', $slider->langue_id);
            return $slider;
        });

        return [
            'sliders' => $sliders,
        ];
    }

    public function name(): ?string
    {
        return 'Liste des sliders';
    }

    public function description(): ?string
    {
        return 'Tous les sliders enregistrés';
    }

    /**
     * Barre d'action (boutons en haut)
     */
    public function commandBar(): iterable
    {
        return [
            Link::make('Créer un slider')
                ->icon('plus')
                ->route('platform.slider.edit'),
        ];
    }

    public function layout(): iterable
    {
        return [
            Layout::view('screens.slider.list'), 
        ];
    }

    public function toggleEtat(Request $request)
    {
        $slider = Slider::findOrFail($request->input('id'));
        $slider->etat = !$slider->etat;
        $slider->save();

        Alert::info("État modifié.");
        return redirect()->back();
    }

    public function toggleSpotlight(Request $request)
    {
        $slider = Slider::findOrFail($request->input('id'));
        $slider->spotlight = !$slider->spotlight;
        $slider->save();

        Alert::info("Spotlight modifié.");
        return redirect()->back();
    }

    public function delete(Request $request)
    {
        $slider = Slider::findOrFail($request->input('slider'));
        $slider->delete();

        Alert::info("Slider supprimé.");
        return redirect()->back();
    }
}
