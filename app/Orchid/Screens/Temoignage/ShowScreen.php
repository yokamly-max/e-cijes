<?php

namespace App\Orchid\Screens\Temoignage;

use App\Models\Temoignage;
use App\Models\Pays;
use App\Models\Langue;

use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Sight;
use Illuminate\Support\HtmlString;

class ShowScreen extends Screen
{
    public function query(Temoignage $temoignage): iterable
    {
        //$temoignage->load(['langue']);

        // Charger les pays et langues depuis Supabase
        $paysList = collect((new Pays())->all())->keyBy('id');
        $langueList = collect((new Langue())->all())->keyBy('id');

        // Récupérer le pays depuis Supabase
        $pays = $paysList->get($temoignage->pays_id);
        $temoignage->pays_nom = is_object($pays) ? ($pays->name ?? 'Non défini') : 'Non défini';

        // Récupérer la langue depuis Supabase
        $langue = $langueList->get($temoignage->langue_id);
        $temoignage->langue_nom = is_object($langue) ? ($langue->name ?? 'Non défini') : 'Non défini';

        return [
            'temoignage' => $temoignage,
        ];
    }

    public function name(): ?string
    {
        return 'Détail du témoignage';
    }

    public function description(): ?string
    {
        return 'Fiche complète du témoignage sélectionnée';
    }

    public function layout(): iterable
    {
        return [
            Layout::legend('temoignage', [
                Sight::make('nom', 'Nom et prénom(s)'),
                Sight::make('profil', 'Profil'),
                Sight::make('commentaire', 'Témoignage'),
                Sight::make('vignette', 'Vignette')->render(function ($temoignage) {
                    if (!$temoignage->vignette) return '—';
                    return "<img src='" . asset($temoignage->vignette) . "' width='80'>";
                }),
                Sight::make('langue_nom', 'Langue'),
                Sight::make('pays_nom', 'Pays'),
                Sight::make('spotlight', 'Spotlight')->render(fn($temoignage) => $temoignage->spotlight ? '✅ Actif' : '❌ Inactif'),
                Sight::make('etat', 'État')->render(fn($temoignage) => $temoignage->etat ? '✅ Actif' : '❌ Inactif'),
                Sight::make('created_at', 'Créé le'),
                Sight::make('updated_at', 'Modifié le'),
            ]),
        ];
    }
}
