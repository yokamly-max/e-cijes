<?php

namespace App\Orchid\Screens\Ressourcetypeoffretype;

use App\Models\Ressourcetypeoffretype;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Sight;
use Illuminate\Support\HtmlString;

class ShowScreen extends Screen
{
    public function query(Ressourcetypeoffretype $ressourcetypeoffretype): iterable
    {
        $ressourcetypeoffretype->load(['ressourcetype', 'offretype', 'table']); 

        return [
            'ressourcetypeoffretype' => $ressourcetypeoffretype,
        ];
    }

    public function name(): ?string
    {
        return 'Détail du type de paiement';
    }

    public function description(): ?string
    {
        return 'Fiche complète du type de paiement sélectionnée';
    }

    public function layout(): iterable
    {
        return [
            Layout::legend('ressourcetypeoffretype', [
                Sight::make('ressourcetype.titre', 'Type de ressource'),
                Sight::make('offretype.titre', 'Type d\'offre'),
                Sight::make('table_id', 'Id table'),
                Sight::make('spotlight', 'Spotlight')->render(fn($ressourcetypeoffretype) => $ressourcetypeoffretype->spotlight ? '✅ Actif' : '❌ Inactif'),
                Sight::make('etat', 'État')->render(fn($ressourcetypeoffretype) => $ressourcetypeoffretype->etat ? '✅ Actif' : '❌ Inactif'),
                Sight::make('created_at', 'Créé le'),
                Sight::make('updated_at', 'Modifié le'),
            ]),
        ];
    }
}
