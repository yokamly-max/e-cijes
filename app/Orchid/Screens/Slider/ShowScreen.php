<?php

namespace App\Orchid\Screens\Slider;

use App\Models\Slider;
use App\Models\Pays;
use App\Models\Langue;

use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Sight;
use Illuminate\Support\HtmlString;

class ShowScreen extends Screen
{
    public function query(Slider $slider): iterable
    {
        $slider->load(['slidertype']);

        // Charger les pays et langues depuis Supabase
        $paysList = collect((new Pays())->all())->keyBy('id');
        $langueList = collect((new Langue())->all())->keyBy('id');

        // Récupérer le pays depuis Supabase
        $pays = $paysList->get($slider->pays_id);
        $slider->pays_nom = is_object($pays) ? ($pays->name ?? 'Non défini') : 'Non défini';

        // Récupérer la langue depuis Supabase
        $langue = $langueList->get($slider->langue_id);
        $slider->langue_nom = is_object($langue) ? ($langue->name ?? 'Non défini') : 'Non défini';

        return [
            'slider' => $slider,
        ];
    }

    public function name(): ?string
    {
        return 'Détail du slider';
    }

    public function description(): ?string
    {
        return 'Fiche complète du slider sélectionnée';
    }

    public function layout(): iterable
    {
        return [
            Layout::legend('slider', [
                Sight::make('titre', 'Titre'),
                Sight::make('resume', 'Résumé'),
                Sight::make('lienurl', 'Lien url'),
                Sight::make('description', 'Description')->render(function ($slider) {
                    return new HtmlString($slider->description); // ✅ Affiche HTML sans échapper
                }),
                Sight::make('slidertype.titre', 'Type du slider'),
                Sight::make('vignette', 'Vignette')->render(function ($slider) {
                    if (!$slider->vignette) return '—';
                    return "<img src='" . asset($slider->vignette) . "' width='80'>";
                }),
                Sight::make('langue_nom', 'Langue'),
                Sight::make('pays_nom', 'Pays'),
                Sight::make('spotlight', 'Spotlight')->render(fn($slider) => $slider->spotlight ? '✅ Actif' : '❌ Inactif'),
                Sight::make('etat', 'État')->render(fn($slider) => $slider->etat ? '✅ Actif' : '❌ Inactif'),
                Sight::make('created_at', 'Créé le'),
                Sight::make('updated_at', 'Modifié le'),
            ]),
        ];
    }
}
