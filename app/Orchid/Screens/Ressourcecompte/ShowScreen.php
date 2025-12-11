<?php

namespace App\Orchid\Screens\Ressourcecompte;

use App\Models\Ressourcecompte;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Sight;
use Illuminate\Support\HtmlString;

class ShowScreen extends Screen
{
    public function query(Ressourcecompte $ressourcecompte): iterable
    {
        $ressourcecompte->load(['membre', 'ressourcetype', 'entreprise', 'user']);

        return [
            'ressourcecompte' => $ressourcecompte,
        ];
    }

    public function name(): ?string
    {
        return 'Détail de la ressource';
    }

    public function description(): ?string
    {
        return 'Fiche complète de la ressource sélectionnée';
    }

    public function layout(): iterable
    {
        return [
            Layout::legend('ressourcecompte', [
                Sight::make('solde', 'Solde'),
                Sight::make('ressourcetype.titre', 'Type de la ressource'),
                Sight::make('membre.nom_complet', 'Membre'),
                Sight::make('entreprise.nom', 'Entreprise'),
                Sight::make('user.name', 'Utilisateur'),
                Sight::make('spotlight', 'Spotlight')->render(fn($ressourcecompte) => $ressourcecompte->spotlight ? '✅ Actif' : '❌ Inactif'),
                Sight::make('etat', 'État')->render(fn($ressourcecompte) => $ressourcecompte->etat ? '✅ Actif' : '❌ Inactif'),
                Sight::make('created_at', 'Créé le'),
                Sight::make('updated_at', 'Modifié le'),
            ]),
        ];
    }
}
