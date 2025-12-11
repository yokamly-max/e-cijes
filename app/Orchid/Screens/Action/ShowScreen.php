<?php

namespace App\Orchid\Screens\Action;

use App\Models\Action;
use App\Models\Pays;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Sight;
use Illuminate\Support\HtmlString;

class ShowScreen extends Screen
{
    public function query(Action $action): iterable
    {
        $action->load(['ressourcetype']);

        return [
            'action' => $action,
        ];
    }

    public function name(): ?string
    {
        return 'Détail de l\'action';
    }

    public function description(): ?string
    {
        return 'Fiche complète de l\'action sélectionnée';
    }

    public function layout(): iterable
    {
        return [
            Layout::legend('action', [
                Sight::make('titre', 'Titre'),
                Sight::make('code', 'Code'),
                Sight::make('point', 'Point'),
                Sight::make('limite', 'Limite'),
                Sight::make('seuil', 'Seuil'),
                Sight::make('ressourcetype.titre', 'Type de ressource'),
                Sight::make('spotlight', 'Spotlight')->render(fn($action) => $action->spotlight ? '✅ Actif' : '❌ Inactif'),
                Sight::make('etat', 'État')->render(fn($action) => $action->etat ? '✅ Actif' : '❌ Inactif'),
                Sight::make('created_at', 'Créé le'),
                Sight::make('updated_at', 'Modifié le'),
            ]),
        ];
    }
}
