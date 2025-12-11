<?php

namespace App\Orchid\Screens\Reservation;

use App\Models\Reservation;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Sight;
use Illuminate\Support\HtmlString;

class ShowScreen extends Screen
{
    public function query(Reservation $reservation): iterable
    {
        $reservation->load(['reservationstatut', 'espace', 'membre']); 

        return [
            'reservation' => $reservation,
        ];
    }

    public function name(): ?string
    {
        return 'Détail de la réservation';
    }

    public function description(): ?string
    {
        return 'Fiche complète de la réservation sélectionnée';
    }

    public function layout(): iterable
    {
        return [
            Layout::legend('reservation', [
                Sight::make('membre.nom_complet', 'Membre'),
                Sight::make('datedebut', 'Date de début'),
                Sight::make('datefin', 'Date de fin'),
                Sight::make('observation', 'Observation'),
                Sight::make('espace.titre', 'Espace'),
                Sight::make('montant', 'Montant'),
                Sight::make('reservationstatut.titre', 'Statut de la réservation'),
                Sight::make('spotlight', 'Spotlight')->render(fn($reservation) => $reservation->spotlight ? '✅ Actif' : '❌ Inactif'),
                Sight::make('etat', 'État')->render(fn($reservation) => $reservation->etat ? '✅ Actif' : '❌ Inactif'),
                Sight::make('created_at', 'Créé le'),
                Sight::make('updated_at', 'Modifié le'),
            ]),
        ];
    }
}
