<?php

namespace App\Orchid\Screens\Disponibilite;

use App\Models\Disponibilite;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Sight;
use Illuminate\Support\HtmlString;

class ShowScreen extends Screen
{
    public function query(Disponibilite $disponibilite): iterable
    {
        $disponibilite->load(['jour', 'expert']); 

        return [
            'disponibilite' => $disponibilite,
        ];
    }

    public function name(): ?string
    {
        return 'Détail de la disponibilité';
    }

    public function description(): ?string
    {
        return 'Fiche complète de la disponibilité sélectionnée';
    }

    public function layout(): iterable
    {
        return [
            Layout::legend('disponibilite', [
                Sight::make('expert.membre.nom_complet', 'Expert'),
                Sight::make('jour.titre', 'Jour'),
                Sight::make('horairedebut', 'Horaire début'),
                Sight::make('horairefin', 'Horaire fin'),
                Sight::make('spotlight', 'Spotlight')->render(fn($disponibilite) => $disponibilite->spotlight ? '✅ Actif' : '❌ Inactif'),
                Sight::make('etat', 'État')->render(fn($disponibilite) => $disponibilite->etat ? '✅ Actif' : '❌ Inactif'),
                Sight::make('created_at', 'Créé le'),
                Sight::make('updated_at', 'Modifié le'),
            ]),
        ];
    }
}
