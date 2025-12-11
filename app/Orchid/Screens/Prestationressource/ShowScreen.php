<?php

namespace App\Orchid\Screens\Prestationressource;

use App\Models\Prestationressource;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Sight;
use Illuminate\Support\HtmlString;

class ShowScreen extends Screen
{
    public function query(Prestationressource $prestationressource): iterable
    {
        $prestationressource->load(['accompagnement', 'prestation', 'ressourcecompte', 'paiementstatut', 'membre', 'entreprise']); 

        return [
            'prestationressource' => $prestationressource,
        ];
    }

    public function name(): ?string
    {
        return 'Détail du paiement de la prestation';
    }

    public function description(): ?string
    {
        return 'Fiche complète du paiement de la prestation sélectionnée';
    }

    public function layout(): iterable
    {
        return [
            Layout::legend('prestationressource', [
                Sight::make('membre.nom_complet', 'Membre'),
                Sight::make('entreprise.nom', 'Entreprise'),
                Sight::make('accompagnement.nom_complet', 'Accompagnement'),
                Sight::make('montant', 'Montant'),
                Sight::make('reference', 'Reference'),
                Sight::make('ressourcecompte.nom_complet', 'Ressource'),
                Sight::make('prestation.titre', 'Prestation'),
                Sight::make('paiementstatut.titre', 'Statut du paiement'),
                Sight::make('spotlight', 'Spotlight')->render(fn($prestationressource) => $prestationressource->spotlight ? '✅ Actif' : '❌ Inactif'),
                Sight::make('etat', 'État')->render(fn($prestationressource) => $prestationressource->etat ? '✅ Actif' : '❌ Inactif'),
                Sight::make('created_at', 'Créé le'),
                Sight::make('updated_at', 'Modifié le'),
            ]),
        ];
    }
}
