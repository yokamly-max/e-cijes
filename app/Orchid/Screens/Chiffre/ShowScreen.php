<?php

namespace App\Orchid\Screens\Chiffre;

use App\Models\Chiffre;
use App\Models\Pays;
use App\Models\Langue;

use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Sight;
use Illuminate\Support\HtmlString;

class ShowScreen extends Screen
{
    public function query(Chiffre $chiffre): iterable
    {
        //$chiffre->load(['langue']);

        // Charger les pays et langues depuis Supabase
        $paysList = collect((new Pays())->all())->keyBy('id');
        $langueList = collect((new Langue())->all())->keyBy('id');

        // Récupérer le pays depuis Supabase
        $pays = $paysList->get($chiffre->pays_id);
        $chiffre->pays_nom = is_object($pays) ? ($pays->name ?? 'Non défini') : 'Non défini';

        // Récupérer la langue depuis Supabase
        $langue = $langueList->get($chiffre->langue_id);
        $chiffre->langue_nom = is_object($langue) ? ($langue->name ?? 'Non défini') : 'Non défini';

        return [
            'chiffre' => $chiffre,
        ];
    }

    public function name(): ?string
    {
        return 'Détail du chiffre';
    }

    public function description(): ?string
    {
        return 'Fiche complète du chiffre sélectionnée';
    }

    public function layout(): iterable
    {
        return [
            Layout::legend('chiffre', [
                Sight::make('titre', 'Titre'),
                Sight::make('chiffre', 'Chiffre'),
                Sight::make('vignette', 'Vignette')->render(function ($chiffre) {
                    if (!$chiffre->vignette) return '—';
                    return "<img src='" . asset($chiffre->vignette) . "' width='80'>";
                }),
                Sight::make('langue_nom', 'Langue'),
                Sight::make('pays_nom', 'Pays'),
                Sight::make('spotlight', 'Spotlight')->render(fn($chiffre) => $chiffre->spotlight ? '✅ Actif' : '❌ Inactif'),
                Sight::make('etat', 'État')->render(fn($chiffre) => $chiffre->etat ? '✅ Actif' : '❌ Inactif'),
                Sight::make('created_at', 'Créé le'),
                Sight::make('updated_at', 'Modifié le'),
            ]),
        ];
    }
}
