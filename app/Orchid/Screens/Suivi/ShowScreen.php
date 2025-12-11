<?php

namespace App\Orchid\Screens\Suivi;

use App\Models\Suivi;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Sight;
use Illuminate\Support\HtmlString;

class ShowScreen extends Screen
{
    public function query(Suivi $suivi): iterable
    {
        $suivi->load(['suivistatut', 'suivitype', 'accompagnement']); 

        return [
            'suivi' => $suivi,
        ];
    }

    public function name(): ?string
    {
        return 'Détail du suivi';
    }

    public function description(): ?string
    {
        return 'Fiche complète du suivi sélectionnée';
    }

    public function layout(): iterable
    {
        return [
            Layout::legend('suivi', [
                Sight::make('accompagnement.nom_complet', 'Accompagnement'),
                Sight::make('datesuivi', 'Date du suivi'),
                Sight::make('observation', 'Observation'),
                Sight::make('suivitype.titre', 'Type du suivi'),
                Sight::make('suivistatut.titre', 'Statut du suivi'),
                Sight::make('spotlight', 'Spotlight')->render(fn($suivi) => $suivi->spotlight ? '✅ Actif' : '❌ Inactif'),
                Sight::make('etat', 'État')->render(fn($suivi) => $suivi->etat ? '✅ Actif' : '❌ Inactif'),
                Sight::make('created_at', 'Créé le'),
                Sight::make('updated_at', 'Modifié le'),
            ]),
        ];
    }
}
