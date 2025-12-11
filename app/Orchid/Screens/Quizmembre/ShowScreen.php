<?php

namespace App\Orchid\Screens\Quizmembre;

use App\Models\Quizmembre;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Sight;
use Illuminate\Support\HtmlString;

class ShowScreen extends Screen
{
    public function query(Quizmembre $quizmembre): iterable
    {
        $quizmembre->load(['quizquestion', 'membre', 'quizreponse']);

        return [
            'quizmembre' => $quizmembre,
        ];
    }

    public function name(): ?string
    {
        return 'Détail du résultat du membre';
    }

    public function description(): ?string
    {
        return 'Fiche complète du résultat du membre sélectionnée';
    }

    public function layout(): iterable
    {
        return [
            Layout::legend('quizmembre', [
                Sight::make('membre.nom_complet', 'Membre'),
                Sight::make('quizquestion.titre', 'Question'),
                Sight::make('quizreponse.text', 'Reponse'),
                Sight::make('valeur', 'Valeur'),
                Sight::make('spotlight', 'Spotlight')->render(fn($quizmembre) => $quizmembre->spotlight ? '✅ Actif' : '❌ Inactif'),
                Sight::make('etat', 'État')->render(fn($quizmembre) => $quizmembre->etat ? '✅ Actif' : '❌ Inactif'),
                Sight::make('created_at', 'Créé le'),
                Sight::make('updated_at', 'Modifié le'),
            ]),
        ];
    }
}
