<?php

namespace App\Orchid\Screens\Participant;

use App\Models\Participant;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Sight;
use Illuminate\Support\HtmlString;

class ShowScreen extends Screen
{
    public function query(Participant $participant): iterable
    {
        $participant->load(['membre', 'formation', 'participantstatut']); 

        return [
            'participant' => $participant,
        ];
    }

    public function name(): ?string
    {
        return 'Détail de la participation';
    }

    public function description(): ?string
    {
        return 'Fiche complète de la participation sélectionnée';
    }

    public function layout(): iterable
    {
        return [
            Layout::legend('participant', [
                Sight::make('membre.nom_complet', 'Membre'),
                Sight::make('dateparticipant', 'Date de la participation'),
                Sight::make('formation.titre', 'Formation'),
                Sight::make('participantstatut.titre', 'Statut de la participation'),
                Sight::make('spotlight', 'Spotlight')->render(fn($participant) => $participant->spotlight ? '✅ Actif' : '❌ Inactif'),
                Sight::make('etat', 'État')->render(fn($participant) => $participant->etat ? '✅ Actif' : '❌ Inactif'),
                Sight::make('created_at', 'Créé le'),
                Sight::make('updated_at', 'Modifié le'),
            ]),
        ];
    }
}
