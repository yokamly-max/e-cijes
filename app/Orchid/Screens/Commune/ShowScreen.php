<?php

namespace App\Orchid\Screens\Commune;

use App\Models\Commune;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Sight;

class ShowScreen extends Screen
{
    public function query(Commune $commune): iterable
    {
        $commune->load('prefecture'); // Pour afficher le nom de la préfecture

        return [
            'commune' => $commune,
        ];
    }

    public function name(): ?string
    {
        return 'Détail de la commune';
    }

    public function description(): ?string
    {
        return 'Fiche complète de la commune sélectionnée';
    }

    public function layout(): iterable
    {
        return [
            Layout::legend('commune', [
                Sight::make('nom', 'Nom'),
                Sight::make('prefecture.nom', 'Préfecture'),
                Sight::make('etat', 'État')->render(fn($commune) => $commune->etat ? '✅ Actif' : '❌ Inactif'),
                Sight::make('created_at', 'Créé le'),
                Sight::make('updated_at', 'Modifié le'),
            ]),
        ];
    }
}
