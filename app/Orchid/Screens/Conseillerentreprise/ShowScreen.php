<?php

namespace App\Orchid\Screens\Conseillerentreprise;

use App\Models\Conseillerentreprise;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Sight;
use Illuminate\Support\HtmlString;

class ShowScreen extends Screen
{
    public function query(Conseillerentreprise $conseillerentreprise): iterable
    {
        $conseillerentreprise->load(['conseiller', 'entreprise']); 

        return [
            'conseillerentreprise' => $conseillerentreprise,
        ];
    }

    public function name(): ?string
    {
        return 'Détail de l\'attribution de conseiller';
    }

    public function description(): ?string
    {
        return 'Fiche complète de l\'attribution de conseiller sélectionnée';
    }

    public function layout(): iterable
    {
        return [
            Layout::legend('conseillerentreprise', [
                Sight::make('conseiller.membre.nom_complet', 'Conseiller'),
                Sight::make('entreprise.nom', 'Entreprise'),
                Sight::make('spotlight', 'Spotlight')->render(fn($conseillerentreprise) => $conseillerentreprise->spotlight ? '✅ Actif' : '❌ Inactif'),
                Sight::make('etat', 'État')->render(fn($conseillerentreprise) => $conseillerentreprise->etat ? '✅ Actif' : '❌ Inactif'),
                Sight::make('created_at', 'Créé le'),
                Sight::make('updated_at', 'Modifié le'),
            ]),
        ];
    }
}
