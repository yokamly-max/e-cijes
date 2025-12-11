<?php

namespace App\Orchid\Screens\Actualite;

use App\Models\Actualite;
use App\Models\Pays;
use App\Models\Langue;

use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Sight;
use Illuminate\Support\HtmlString;

class ShowScreen extends Screen
{

    public function query(Actualite $actualite): iterable
    {
        // Charger les relations locales
        $actualite->load('actualitetype');

        // Charger les pays et langues depuis Supabase
        $paysList = collect((new Pays())->all())->keyBy('id');
        $langueList = collect((new Langue())->all())->keyBy('id');

        // Récupérer le pays depuis Supabase
        $pays = $paysList->get($actualite->pays_id);
        $actualite->pays_nom = is_object($pays) ? ($pays->name ?? 'Non défini') : 'Non défini';

        // Récupérer la langue depuis Supabase
        $langue = $langueList->get($actualite->langue_id);
        $actualite->langue_nom = is_object($langue) ? ($langue->name ?? 'Non défini') : 'Non défini';

        return [
            'actualite' => $actualite,
        ];
    }

    public function name(): ?string
    {
        return 'Détail de l\'actualité';
    }

    public function description(): ?string
    {
        return 'Fiche complète de l\'actualité sélectionnée';
    }

    public function layout(): iterable
    {
        return [
            Layout::legend('actualite', [
                Sight::make('dateactualite', 'Date de l\'actualité'),
                Sight::make('titre', 'Titre'),
                Sight::make('resume', 'Résumé'),
                Sight::make('description', 'Description')->render(function ($actualite) {
                    return new HtmlString($actualite->description); // ✅ Affiche HTML sans échapper
                }),
                Sight::make('actualitetype.titre', 'Type de l\'actualité'),
                Sight::make('vignette', 'Vignette')->render(function ($actualite) {
                    if (!$actualite->vignette) return '—';
                    return "<img src='" . asset($actualite->vignette) . "' width='80'>";
                }),
                Sight::make('langue_nom', 'Langue'),
                Sight::make('pays_nom', 'Pays'),
                Sight::make('spotlight', 'Spotlight')->render(fn($actualite) => $actualite->spotlight ? '✅ Actif' : '❌ Inactif'),
                Sight::make('etat', 'État')->render(fn($actualite) => $actualite->etat ? '✅ Actif' : '❌ Inactif'),
                Sight::make('created_at', 'Créé le'),
                Sight::make('updated_at', 'Modifié le'),
            ]),
        ];
    }
}
