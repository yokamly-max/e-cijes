<?php

namespace App\Orchid\Screens\Evenementressource;

use App\Models\Evenementressource;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Sight;
use Illuminate\Support\HtmlString;

class ShowScreen extends Screen
{
    public function query(Evenementressource $evenementressource): iterable
    {
        $evenementressource->load(['accompagnement', 'evenement', 'ressourcecompte', 'paiementstatut', 'membre', 'entreprise']); 

        return [
            'evenementressource' => $evenementressource,
        ];
    }

    public function name(): ?string
    {
        return 'Détail du paiement de l\'évènement';
    }

    public function description(): ?string
    {
        return 'Fiche complète du paiement de l\'évènement sélectionnée';
    }

    public function layout(): iterable
    {
        return [
            Layout::legend('evenementressource', [
                Sight::make('membre.nom_complet', 'Membre'),
                Sight::make('entreprise.nom', 'Entreprise'),
                Sight::make('accompagnement.nom_complet', 'Accompagnement'),
                Sight::make('montant', 'Montant'),
                Sight::make('reference', 'Reference'),
                Sight::make('ressourcecompte.nom_complet', 'Ressource'),
                Sight::make('evenement.titre', 'Evenement'),
                Sight::make('paiementstatut.titre', 'Statut du paiement'),
                Sight::make('spotlight', 'Spotlight')->render(fn($evenementressource) => $evenementressource->spotlight ? '✅ Actif' : '❌ Inactif'),
                Sight::make('etat', 'État')->render(fn($evenementressource) => $evenementressource->etat ? '✅ Actif' : '❌ Inactif'),
                Sight::make('created_at', 'Créé le'),
                Sight::make('updated_at', 'Modifié le'),
            ]),
        ];
    }
}
