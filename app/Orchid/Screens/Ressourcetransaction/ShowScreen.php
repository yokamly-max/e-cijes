<?php

namespace App\Orchid\Screens\Ressourcetransaction;

use App\Models\Ressourcetransaction;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Sight;
use Illuminate\Support\HtmlString;

class ShowScreen extends Screen
{
    public function query(Ressourcetransaction $ressourcetransaction): iterable
    {
        $ressourcetransaction->load(['ressourcecompte', 'operationtype']); 

        return [
            'ressourcetransaction' => $ressourcetransaction,
        ];
    }

    public function name(): ?string
    {
        return 'Détail de la transaction';
    }

    public function description(): ?string
    {
        return 'Fiche complète de la transaction sélectionnée';
    }

    public function layout(): iterable
    {
        return [
            Layout::legend('ressourcetransaction', [
                Sight::make('operationtype.titre', 'Type de l\'opération'),
                Sight::make('datetransaction', 'Date de la transaction'),
                Sight::make('montant', 'Montant'),
                Sight::make('reference', 'Référence'),
                Sight::make('ressourcecompte.nom_complet', 'Ressource'),
                Sight::make('spotlight', 'Spotlight')->render(fn($ressourcetransaction) => $ressourcetransaction->spotlight ? '✅ Actif' : '❌ Inactif'),
                Sight::make('etat', 'État')->render(fn($ressourcetransaction) => $ressourcetransaction->etat ? '✅ Actif' : '❌ Inactif'),
                Sight::make('created_at', 'Créé le'),
                Sight::make('updated_at', 'Modifié le'),
            ]),
        ];
    }
}
