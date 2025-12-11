<?php

namespace App\Orchid\Screens\Prefecture;

use App\Models\Prefecture;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Sight;

class ShowScreen extends Screen
{
    public function query(Prefecture $prefecture): iterable
    {
        $prefecture->load('region'); // Pour afficher le nom de la région

        return [
            'prefecture' => $prefecture,
        ];
    }

    public function name(): ?string
    {
        return 'Détail de la préfecture';
    }

    public function description(): ?string
    {
        return 'Fiche complète de la préfecture sélectionnée';
    }

    public function layout(): iterable
    {
        return [
            Layout::legend('prefecture', [
                Sight::make('nom', 'Nom'),
                Sight::make('cheflieu', 'Chef lieu'),
                Sight::make('region.nom', 'Région'),
                Sight::make('etat', 'État')->render(fn($prefecture) => $prefecture->etat ? '✅ Actif' : '❌ Inactif'),
                Sight::make('created_at', 'Créé le'),
                Sight::make('updated_at', 'Modifié le'),
            ]),
        ];
    }
}
