<?php

namespace App\Orchid\Screens\Evenement;

use App\Models\Evenement;
use App\Models\Pays;
use App\Models\Langue;

use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Sight;
use Illuminate\Support\HtmlString;

class ShowScreen extends Screen
{

    public function query(Evenement $evenement): iterable
    {
        // Charger les relations locales
        $evenement->load('evenementtype');

        // Charger les pays et langues depuis Supabase
        $paysList = collect((new Pays())->all())->keyBy('id');
        $langueList = collect((new Langue())->all())->keyBy('id');

        // Récupérer le pays depuis Supabase
        $pays = $paysList->get($evenement->pays_id);
        $evenement->pays_nom = is_object($pays) ? ($pays->name ?? 'Non défini') : 'Non défini';

        // Récupérer la langue depuis Supabase
        $langue = $langueList->get($evenement->langue_id);
        $evenement->langue_nom = is_object($langue) ? ($langue->name ?? 'Non défini') : 'Non défini';

        return [
            'evenement' => $evenement,
        ];
    }

    public function name(): ?string
    {
        return 'Détail de l\'évènement';
    }

    public function description(): ?string
    {
        return 'Fiche complète de l\'évènement sélectionnée';
    }

    public function layout(): iterable
    {
        return [
            Layout::legend('evenement', [
                Sight::make('dateevenement', 'Date de l\'évènement'),
                Sight::make('titre', 'Titre'),
                Sight::make('resume', 'Résumé'),
                Sight::make('prix', 'Prix'),
                Sight::make('description', 'Description')->render(function ($evenement) {
                    return new HtmlString($evenement->description); // ✅ Affiche HTML sans échapper
                }),
                Sight::make('evenementtype.titre', 'Type de l\'évènement'),
                Sight::make('vignette', 'Vignette')->render(function ($evenement) {
                    if (!$evenement->vignette) return '—';
                    return "<img src='" . asset($evenement->vignette) . "' width='80'>";
                }),
                Sight::make('langue_nom', 'Langue'),
                Sight::make('pays_nom', 'Pays'),
                Sight::make('spotlight', 'Spotlight')->render(fn($evenement) => $evenement->spotlight ? '✅ Actif' : '❌ Inactif'),
                Sight::make('etat', 'État')->render(fn($evenement) => $evenement->etat ? '✅ Actif' : '❌ Inactif'),
                Sight::make('created_at', 'Créé le'),
                Sight::make('updated_at', 'Modifié le'),
            ]),
        ];
    }
}
