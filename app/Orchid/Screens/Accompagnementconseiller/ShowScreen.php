<?php

namespace App\Orchid\Screens\Accompagnementconseiller;

use App\Models\Accompagnementconseiller;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Sight;
use Illuminate\Support\HtmlString;

class ShowScreen extends Screen
{
    public function query(Accompagnementconseiller $accompagnementconseiller): iterable
    {
        $accompagnementconseiller->load(['accompagnementtype', 'conseiller', 'accompagnement']); 

        return [
            'accompagnementconseiller' => $accompagnementconseiller,
        ];
    }

    public function name(): ?string
    {
        return 'Détail du conseiller de l\'accompagnement';
    }

    public function description(): ?string
    {
        return 'Fiche complète du conseiller de l\'accompagnement sélectionnée';
    }

    public function layout(): iterable
    {
        return [
            Layout::legend('accompagnementconseiller', [
                Sight::make('accompagnement.membre.nom_complet', 'Accompagnement'),
                Sight::make('datedebut', 'Date de début'),
                Sight::make('datefin', 'Date de fin'),
                Sight::make('observation', 'Observation'),
                Sight::make('conseiller.membre.nom_complet', 'Conseiller'),
                Sight::make('montant', 'Montant'),
                Sight::make('accompagnementtype.titre', 'Type du conseiller de l\'accompagnement'),
                Sight::make('spotlight', 'Spotlight')->render(fn($accompagnementconseiller) => $accompagnementconseiller->spotlight ? '✅ Actif' : '❌ Inactif'),
                Sight::make('etat', 'État')->render(fn($accompagnementconseiller) => $accompagnementconseiller->etat ? '✅ Actif' : '❌ Inactif'),
                Sight::make('created_at', 'Créé le'),
                Sight::make('updated_at', 'Modifié le'),
            ]),
        ];
    }
}
