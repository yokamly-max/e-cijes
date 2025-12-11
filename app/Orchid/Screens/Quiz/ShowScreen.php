<?php

namespace App\Orchid\Screens\Quiz;

use App\Models\Quiz;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Sight;
use Illuminate\Support\HtmlString;

class ShowScreen extends Screen
{
    public function query(Quiz $quiz): iterable
    {
        $quiz->load(['formation']);

        return [
            'quiz' => $quiz,
        ];
    }

    public function name(): ?string
    {
        return 'Détail du quiz';
    }

    public function description(): ?string
    {
        return 'Fiche complète du quiz sélectionné';
    }

    public function layout(): iterable
    {
        return [
            Layout::legend('quiz', [
                Sight::make('titre', 'Titre'),
                Sight::make('seuil_reussite', 'Seuil réussite'),
                Sight::make('formation.titre', 'Formation'),
                Sight::make('spotlight', 'Spotlight')->render(fn($quiz) => $quiz->spotlight ? '✅ Actif' : '❌ Inactif'),
                Sight::make('etat', 'État')->render(fn($quiz) => $quiz->etat ? '✅ Actif' : '❌ Inactif'),
                Sight::make('created_at', 'Créé le'),
                Sight::make('updated_at', 'Modifié le'),
            ]),
        ];
    }
}
