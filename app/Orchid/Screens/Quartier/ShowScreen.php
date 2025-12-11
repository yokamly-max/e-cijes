<?php

namespace App\Orchid\Screens\Quartier;

use App\Models\Quartier;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Sight;

class ShowScreen extends Screen
{
    public function query(Quartier $quartier): iterable
    {
        $quartier->load('commune'); // Pour afficher le nom de la commune

        return [
            'quartier' => $quartier,
        ];
    }

    public function name(): ?string
    {
        return 'Détail du quartier';
    }

    public function description(): ?string
    {
        return 'Fiche complète du quartier sélectionné';
    }

    public function layout(): iterable
    {
        return [
            Layout::legend('quartier', [
                Sight::make('nom', 'Nom'),
                Sight::make('commune.nom', 'Commune'),
                Sight::make('etat', 'État')->render(fn($quartier) => $quartier->etat ? '✅ Actif' : '❌ Inactif'),
                Sight::make('created_at', 'Créé le'),
                Sight::make('updated_at', 'Modifié le'),
            ]),
        ];
    }
}
