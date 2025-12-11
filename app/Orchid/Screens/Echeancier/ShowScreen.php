<?php

namespace App\Orchid\Screens\Echeancier;

use App\Models\Echeancier;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Sight;
use Illuminate\Support\HtmlString;

class ShowScreen extends Screen
{
    public function query(Echeancier $echeancier): iterable
    {
        $echeancier->load(['echeancierstatut', 'entreprise']); 

        return [
            'echeancier' => $echeancier,
        ];
    }

    public function name(): ?string
    {
        return 'Détail de l\'échéancier';
    }

    public function description(): ?string
    {
        return 'Fiche complète de l\'échéancier sélectionnée';
    }

    public function layout(): iterable
    {
        return [
            Layout::legend('echeancier', [
                Sight::make('entreprise.nom', 'Entreprise'),
                Sight::make('dateecheancier', 'Date de l\'échéancier'),
                Sight::make('montant', 'Montant'),
                Sight::make('echeancierstatut.titre', 'Statut de l\'échéancier'),
                Sight::make('spotlight', 'Spotlight')->render(fn($echeancier) => $echeancier->spotlight ? '✅ Actif' : '❌ Inactif'),
                Sight::make('etat', 'État')->render(fn($echeancier) => $echeancier->etat ? '✅ Actif' : '❌ Inactif'),
                Sight::make('created_at', 'Créé le'),
                Sight::make('updated_at', 'Modifié le'),
            ]),
        ];
    }
}
