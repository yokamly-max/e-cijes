<?php

namespace App\Orchid\Screens\Quizquestion;

use App\Models\Quizquestion;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Sight;
use Illuminate\Support\HtmlString;

class ShowScreen extends Screen
{
    public function query(Quizquestion $quizquestion): iterable
    {
        $quizquestion->load(['quizquestiontype', 'quiz']);

        return [
            'quizquestion' => $quizquestion,
        ];
    }

    public function name(): ?string
    {
        return 'Détail de la question du quiz';
    }

    public function description(): ?string
    {
        return 'Fiche complète de la question du quiz sélectionnée';
    }

    public function layout(): iterable
    {
        return [
            Layout::legend('quizquestion', [
                Sight::make('titre', 'Titre'),
                Sight::make('point', 'Point'),
                Sight::make('quizquestiontype.titre', 'Type de la question'),
                Sight::make('quiz.titre', 'Quiz'),
                Sight::make('spotlight', 'Spotlight')->render(fn($quizquestion) => $quizquestion->spotlight ? '✅ Actif' : '❌ Inactif'),
                Sight::make('etat', 'État')->render(fn($quizquestion) => $quizquestion->etat ? '✅ Actif' : '❌ Inactif'),
                Sight::make('created_at', 'Créé le'),
                Sight::make('updated_at', 'Modifié le'),
            ]),
        ];
    }
}
