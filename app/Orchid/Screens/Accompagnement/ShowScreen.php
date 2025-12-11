<?php

namespace App\Orchid\Screens\Accompagnement;

use App\Models\Accompagnement;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Sight;
use Illuminate\Support\HtmlString;

class ShowScreen extends Screen
{
    public function query(Accompagnement $accompagnement): iterable
    {
        $accompagnement->load(['membre', 'entreprise', 'accompagnementniveau', 'accompagnementstatut']); 

        return [
            'accompagnement' => $accompagnement,
        ];
    }

    public function name(): ?string
    {
        return 'Détail de l\'accompagnement';
    }

    public function description(): ?string
    {
        return 'Fiche complète de l\'accompagnement sélectionnée';
    }

    public function layout(): iterable
    {
        return [
            Layout::legend('accompagnement', [
                Sight::make('membre.nom_complet', 'Membre'),
                Sight::make('entreprise.nom', 'Entreprise'),
                Sight::make('dateaccompagnement', 'Date de l\'accompagnement'),
                Sight::make('accompagnementniveau.titre', 'Type de l\'accompagnement'),
                Sight::make('accompagnementstatut.titre', 'Statut de l\'accompagnement'),
                Sight::make('spotlight', 'Spotlight')->render(fn($accompagnement) => $accompagnement->spotlight ? '✅ Actif' : '❌ Inactif'),
                Sight::make('etat', 'État')->render(fn($accompagnement) => $accompagnement->etat ? '✅ Actif' : '❌ Inactif'),
                Sight::make('created_at', 'Créé le'),
                Sight::make('updated_at', 'Modifié le'),
            ]),
        ];
    }
}
