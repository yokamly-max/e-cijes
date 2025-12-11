<?php

namespace App\Orchid\Screens\Conseillerprescription;

use App\Models\Conseillerprescription;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Sight;
use Illuminate\Support\HtmlString;

class ShowScreen extends Screen
{
    public function query(Conseillerprescription $conseillerprescription): iterable
    {
        $conseillerprescription->load(['conseiller', 'membre', 'entreprise', 'formation', 'prestation']); 

        return [
            'conseillerprescription' => $conseillerprescription,
        ];
    }

    public function name(): ?string
    {
        return 'Détail de la prescription du conseiller';
    }

    public function description(): ?string
    {
        return 'Fiche complète de la prescription du conseiller sélectionnée';
    }

    public function layout(): iterable
    {
        return [
            Layout::legend('conseillerprescription', [
                Sight::make('conseiller.membre.nom_complet', 'Conseiller'),
                Sight::make('membre.nom_complet', 'Membre'),
                Sight::make('entreprise.nom', 'Entreprise'),
                Sight::make('prestation.titre', 'Prestation'),
                Sight::make('formation.titre', 'Formation'),
                Sight::make('spotlight', 'Spotlight')->render(fn($conseillerprescription) => $conseillerprescription->spotlight ? '✅ Actif' : '❌ Inactif'),
                Sight::make('etat', 'État')->render(fn($conseillerprescription) => $conseillerprescription->etat ? '✅ Actif' : '❌ Inactif'),
                Sight::make('created_at', 'Créé le'),
                Sight::make('updated_at', 'Modifié le'),
            ]),
        ];
    }
}
