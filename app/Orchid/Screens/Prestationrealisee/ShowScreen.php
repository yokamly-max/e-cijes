<?php

namespace App\Orchid\Screens\Prestationrealisee;

use App\Models\Prestationrealisee;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Sight;
use Illuminate\Support\HtmlString;

class ShowScreen extends Screen
{
    public function query(Prestationrealisee $prestationrealisee): iterable
    {
        $prestationrealisee->load(['prestation', 'accompagnement', 'prestationrealiseestatut']); 

        return [
            'prestationrealisee' => $prestationrealisee,
        ];
    }

    public function name(): ?string
    {
        return 'Détail de la réalisation';
    }

    public function description(): ?string
    {
        return 'Fiche complète de la réalisation sélectionnée';
    }

    public function layout(): iterable
    {
        return [
            Layout::legend('prestationrealisee', [
                Sight::make('daterealisation', 'Date de la réalisation'),
                Sight::make('note', 'Note'),
                Sight::make('feedback', 'Feedback'),
                Sight::make('accompagnement.nom_complet', 'Accompagnement'),
                Sight::make('prestation.titre', 'Prestation'),
                Sight::make('prestationrealiseestatut.titre', 'Statut'),
                Sight::make('spotlight', 'Spotlight')->render(fn($prestationrealisee) => $prestationrealisee->spotlight ? '✅ Actif' : '❌ Inactif'),
                Sight::make('etat', 'État')->render(fn($prestationrealisee) => $prestationrealisee->etat ? '✅ Actif' : '❌ Inactif'),
                Sight::make('created_at', 'Créé le'),
                Sight::make('updated_at', 'Modifié le'),
            ]),
        ];
    }
}
