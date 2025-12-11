<?php

namespace App\Orchid\Screens\Service;

use App\Models\Service;
use App\Models\Pays;
use App\Models\Langue;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Sight;
use Illuminate\Support\HtmlString;

class ShowScreen extends Screen
{
    public function query(Service $service): iterable
    {
        //$service->load();

        // Charger les pays et langues depuis Supabase
        $paysList = collect((new Pays())->all())->keyBy('id');
        $langueList = collect((new Langue())->all())->keyBy('id');

        // Récupérer le pays depuis Supabase
        $pays = $paysList->get($service->pays_id);
        $service->pays_nom = is_object($pays) ? ($pays->name ?? 'Non défini') : 'Non défini';

        // Récupérer la langue depuis Supabase
        $langue = $langueList->get($service->langue_id);
        $service->langue_nom = is_object($langue) ? ($langue->name ?? 'Non défini') : 'Non défini';

        return [
            'service' => $service,
        ];
    }

    public function name(): ?string
    {
        return 'Détail du service';
    }

    public function description(): ?string
    {
        return 'Fiche complète du service sélectionnée';
    }

    public function layout(): iterable
    {
        return [
            Layout::legend('service', [
                Sight::make('titre', 'Titre'),
                Sight::make('resume', 'Résumé'),
                Sight::make('description', 'Description')->render(function ($service) {
                    return new HtmlString($service->description); // ✅ Affiche HTML sans échapper
                }),
                Sight::make('vignette', 'Vignette')->render(function ($service) {
                    if (!$service->vignette) return '—';
                    return "<img src='" . asset($service->vignette) . "' width='80'>";
                }),
                Sight::make('langue_nom', 'Langue'),
                Sight::make('pays_nom', 'Pays'),
                Sight::make('spotlight', 'Spotlight')->render(fn($service) => $service->spotlight ? '✅ Actif' : '❌ Inactif'),
                Sight::make('etat', 'État')->render(fn($service) => $service->etat ? '✅ Actif' : '❌ Inactif'),
                Sight::make('created_at', 'Créé le'),
                Sight::make('updated_at', 'Modifié le'),
            ]),
        ];
    }
}
