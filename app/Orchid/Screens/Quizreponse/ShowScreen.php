<?php

namespace App\Orchid\Screens\Quizreponse;

use App\Models\Quizreponse;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Sight;
use Illuminate\Support\HtmlString;

class ShowScreen extends Screen
{
    public function query(Quizreponse $quizreponse): iterable
    {
        $quizreponse->load(['quizquestion']);

        return [
            'quizreponse' => $quizreponse,
        ];
    }

    public function name(): ?string
    {
        return 'Détail de la reponse du quiz';
    }

    public function description(): ?string
    {
        return 'Fiche complète de la reponse du quiz sélectionnée';
    }

    public function layout(): iterable
    {
        return [
            Layout::legend('quizreponse', [
                Sight::make('text', 'Text'),
                Sight::make('correcte', 'Correcte'),
                Sight::make('quizquestion.titre', 'Question'),
                Sight::make('quiz.titre', 'Quiz'),
                Sight::make('correcte', 'Correcte')->render(fn($quizreponse) => $quizreponse->correcte ? '✅ Actif' : '❌ Inactif'),
                Sight::make('spotlight', 'Spotlight')->render(fn($quizreponse) => $quizreponse->spotlight ? '✅ Actif' : '❌ Inactif'),
                Sight::make('etat', 'État')->render(fn($quizreponse) => $quizreponse->etat ? '✅ Actif' : '❌ Inactif'),
                Sight::make('created_at', 'Créé le'),
                Sight::make('updated_at', 'Modifié le'),
            ]),
        ];
    }
}
