<?php

namespace App\Orchid\Screens\Evaluation;

use App\Models\Evaluation;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Sight;
use Illuminate\Support\HtmlString;

class ShowScreen extends Screen
{
    public function query(Evaluation $evaluation): iterable
    {
        $evaluation->load(['membre', 'expert']); 

        return [
            'evaluation' => $evaluation,
        ];
    }

    public function name(): ?string
    {
        return 'Détail de l\'évaluation';
    }

    public function description(): ?string
    {
        return 'Fiche complète de l\'évaluation sélectionnée';
    }

    public function layout(): iterable
    {
        return [
            Layout::legend('evaluation', [
                Sight::make('expert.membre.nom_complet', 'Expert'),
                Sight::make('membre.nom_complet', 'Membre'),
                Sight::make('note', 'Note'),
                Sight::make('commentaire', 'Commentaire'),
                Sight::make('spotlight', 'Spotlight')->render(fn($evaluation) => $evaluation->spotlight ? '✅ Actif' : '❌ Inactif'),
                Sight::make('etat', 'État')->render(fn($evaluation) => $evaluation->etat ? '✅ Actif' : '❌ Inactif'),
                Sight::make('created_at', 'Créé le'),
                Sight::make('updated_at', 'Modifié le'),
            ]),
        ];
    }
}
