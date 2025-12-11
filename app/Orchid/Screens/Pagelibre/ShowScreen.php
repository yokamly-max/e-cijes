<?php

namespace App\Orchid\Screens\Pagelibre;

use App\Models\Pagelibre;
use App\Models\Langue;

use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Sight;
use Illuminate\Support\HtmlString;

class ShowScreen extends Screen
{
    public function query(Pagelibre $pagelibre): iterable
    {
        $pagelibre->load(['pageparent']); 

        // Charger les langues depuis Supabase
        $langueList = collect((new Langue())->all())->keyBy('id');

        // Récupérer la langue depuis Supabase
        $langue = $langueList->get($pagelibre->langue_id);
        $pagelibre->langue_nom = is_object($langue) ? ($langue->name ?? 'Non défini') : 'Non défini';

        return [
            'pagelibre' => $pagelibre,
        ];
    }

    public function name(): ?string
    {
        return 'Détail de la page de présentation';
    }

    public function description(): ?string
    {
        return 'Fiche complète de la page de présentation sélectionnée';
    }

    public function layout(): iterable
    {
        return [
            Layout::legend('pagelibre', [
                Sight::make('titre', 'Titre'),
                Sight::make('resume', 'Résumé'),
                Sight::make('description', 'Description')->render(function ($pagelibre) {
                    return new HtmlString($pagelibre->description); // ✅ Affiche HTML sans échapper
                }),
                Sight::make('pageparent.titre', 'Page parent'),
                Sight::make('vignette', 'Vignette')->render(function ($pagelibre) {
                    if (!$pagelibre->vignette) return '—';
                    return "<img src='" . asset($pagelibre->vignette) . "' width='80'>";
                }),
                Sight::make('langue_nom', 'Langue'),
                Sight::make('spotlight', 'Spotlight')->render(fn($pagelibre) => $pagelibre->spotlight ? '✅ Actif' : '❌ Inactif'),
                Sight::make('etat', 'État')->render(fn($pagelibre) => $pagelibre->etat ? '✅ Actif' : '❌ Inactif'),
                Sight::make('created_at', 'Créé le'),
                Sight::make('updated_at', 'Modifié le'),
            ]),
        ];
    }
}
