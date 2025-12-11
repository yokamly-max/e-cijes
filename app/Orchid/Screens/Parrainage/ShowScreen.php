<?php

namespace App\Orchid\Screens\Parrainage;

use App\Models\Parrainage;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Sight;
use Illuminate\Support\HtmlString;

class ShowScreen extends Screen
{
    public function query(Parrainage $parrainage): iterable
    {
        $parrainage->load(['membreparrain', 'membrefilleul']); 

        return [
            'parrainage' => $parrainage,
        ];
    }

    public function name(): ?string
    {
        return 'Détail du parrainage';
    }

    public function description(): ?string
    {
        return 'Fiche complète du parrainage sélectionnée';
    }

    public function layout(): iterable
    {
        return [
            Layout::legend('parrainage', [
                Sight::make('lien', 'Lien'),
                Sight::make('membreparrain.nom_complet', 'Membre parrain'),
                Sight::make('membrefilleul.nom_complet', 'Membre filleul'),
                Sight::make('spotlight', 'Spotlight')->render(fn($parrainage) => $parrainage->spotlight ? '✅ Actif' : '❌ Inactif'),
                Sight::make('etat', 'État')->render(fn($parrainage) => $parrainage->etat ? '✅ Actif' : '❌ Inactif'),
                Sight::make('created_at', 'Créé le'),
                Sight::make('updated_at', 'Modifié le'),
            ]),
        ];
    }
}
