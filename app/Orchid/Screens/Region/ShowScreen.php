<?php

namespace App\Orchid\Screens\Region;

use App\Models\Region;
use App\Models\Pays;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Sight;


class ShowScreen extends Screen
{
    
    public function query(Region $region): iterable
    {
        // Charger tous les pays depuis Supabase
        $paysModel = new Pays();
        $paysList = collect($paysModel->all())->keyBy('id');

        // Récupérer le pays correspondant
        $pays = $paysList[$region->pays_id] ?? null;

        $region->pays_nom = is_array($pays)
            ? ($pays['name'] ?? 'Non défini')
            : ($pays->name ?? 'Non défini');

        return [
            'region' => $region
        ];
    }

    public function name(): ?string
    {
        return 'Détail de la région';
    }

    public function description(): ?string
    {
        return 'Fiche complète de la région sélectionnée';
    }

    public function layout(): iterable
    {
        return [
            Layout::legend('region', [
                Sight::make('nom', 'Nom'),
                Sight::make('code', 'Code'),
                Sight::make('pays_nom', 'Pays'),
                Sight::make('etat', 'État')->render(fn($region) => $region->etat ? '✅ Actif' : '❌ Inactif'),
                Sight::make('created_at', 'Créé le'),
                Sight::make('updated_at', 'Modifié le'),
            ]),
        ];
    }

}
