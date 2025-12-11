<?php

namespace App\Orchid\Screens\Partenaire;

use App\Models\Partenaire;
use App\Models\Pays;
use App\Models\Langue;

use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Sight;
use Illuminate\Support\HtmlString;

class ShowScreen extends Screen
{
    public function query(Partenaire $partenaire): iterable
    {
        $partenaire->load(['partenairetype']);

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
        return 'Détail du partenaire';
    }

    public function description(): ?string
    {
        return 'Fiche complète du partenaire sélectionnée';
    }

    public function layout(): iterable
    {
        return [
            Layout::legend('partenaire', [
                Sight::make('titre', 'Titre'),
                Sight::make('contact', 'Contact'),
                Sight::make('description', 'Description')->render(function ($partenaire) {
                    return new HtmlString($partenaire->description); // ✅ Affiche HTML sans échapper
                }),
                Sight::make('partenairetype.titre', 'Type du partenaire'),
                Sight::make('vignette', 'Vignette')->render(function ($partenaire) {
                    if (!$partenaire->vignette) return '—';
                    return "<img src='" . asset($partenaire->vignette) . "' width='80'>";
                }),
                Sight::make('langue_nom', 'Langue'),
                Sight::make('pays_nom', 'Pays'),
                Sight::make('spotlight', 'Spotlight')->render(fn($partenaire) => $partenaire->spotlight ? '✅ Actif' : '❌ Inactif'),
                Sight::make('etat', 'État')->render(fn($partenaire) => $partenaire->etat ? '✅ Actif' : '❌ Inactif'),
                Sight::make('created_at', 'Créé le'),
                Sight::make('updated_at', 'Modifié le'),
            ]),
        ];
    }
}
