<?php

namespace App\Orchid\Screens\Bonutilise;

use App\Models\Bonutilise;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Sight;
use Illuminate\Support\HtmlString;

class ShowScreen extends Screen
{
    public function query(Bonutilise $bonutilise): iterable
    {
        $bonutilise->load(['bon', 'prestationrealisee']); 

        return [
            'bonutilise' => $bonutilise,
        ];
    }

    public function name(): ?string
    {
        return 'Détail du bon utilisé';
    }

    public function description(): ?string
    {
        return 'Fiche complète du bon utilisé sélectionnée';
    }

    public function layout(): iterable
    {
        return [
            Layout::legend('bonutilise', [
                Sight::make('montant', 'Montant'),
                Sight::make('noteservice', 'Note de service'),
                Sight::make('bon.montant', 'Bon'),
                Sight::make('prestationrealisee.note', 'Prestation realisée'),
                Sight::make('spotlight', 'Spotlight')->render(fn($bonutilise) => $bonutilise->spotlight ? '✅ Actif' : '❌ Inactif'),
                Sight::make('etat', 'État')->render(fn($bonutilise) => $bonutilise->etat ? '✅ Actif' : '❌ Inactif'),
                Sight::make('created_at', 'Créé le'),
                Sight::make('updated_at', 'Modifié le'),
            ]),
        ];
    }
}
