<?php

namespace App\Orchid\Screens\Formationressource;

use App\Models\Formationressource;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Sight;
use Illuminate\Support\HtmlString;

class ShowScreen extends Screen
{
    public function query(Formationressource $formationressource): iterable
    {
        $formationressource->load(['accompagnement', 'formation', 'ressourcecompte', 'paiementstatut', 'membre', 'entreprise']); 

        return [
            'formationressource' => $formationressource,
        ];
    }

    public function name(): ?string
    {
        return 'Détail du paiement de la formation';
    }

    public function description(): ?string
    {
        return 'Fiche complète du paiement de la formation sélectionnée';
    }

    public function layout(): iterable
    {
        return [
            Layout::legend('formationressource', [
                Sight::make('membre.nom_complet', 'Membre'),
                Sight::make('entreprise.nom', 'Entreprise'),
                Sight::make('accompagnement.nom_complet', 'Accompagnement'),
                Sight::make('montant', 'Montant'),
                Sight::make('reference', 'Reference'),
                Sight::make('ressourcecompte.nom_complet', 'Ressource'),
                Sight::make('formation.titre', 'Formation'),
                Sight::make('paiementstatut.titre', 'Statut du paiement'),
                Sight::make('spotlight', 'Spotlight')->render(fn($formationressource) => $formationressource->spotlight ? '✅ Actif' : '❌ Inactif'),
                Sight::make('etat', 'État')->render(fn($formationressource) => $formationressource->etat ? '✅ Actif' : '❌ Inactif'),
                Sight::make('created_at', 'Créé le'),
                Sight::make('updated_at', 'Modifié le'),
            ]),
        ];
    }
}
