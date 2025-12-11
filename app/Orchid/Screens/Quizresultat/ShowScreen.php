<?php

namespace App\Orchid\Screens\Quizresultat;

use App\Models\Quizresultat;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Sight;
use Illuminate\Support\HtmlString;

class ShowScreen extends Screen
{
    public function query(Quizresultat $quizresultat): iterable
    {
        $quizresultat->load(['quiz', 'membre', 'quizresultatstatut']);

        return [
            'quizresultat' => $quizresultat,
        ];
    }

    public function name(): ?string
    {
        return 'Détail du résultat du quiz';
    }

    public function description(): ?string
    {
        return 'Fiche complète du résultat du quiz sélectionnée';
    }

    public function layout(): iterable
    {
        return [
            Layout::legend('quizresultat', [
                Sight::make('membre.nom_complet', 'Membre'),
                Sight::make('quiz.titre', 'Quiz'),
                Sight::make('quizresultatstatut.titre', 'Statut'),
                Sight::make('score', 'Score'),
                Sight::make('spotlight', 'Spotlight')->render(fn($quizresultat) => $quizresultat->spotlight ? '✅ Actif' : '❌ Inactif'),
                Sight::make('etat', 'État')->render(fn($quizresultat) => $quizresultat->etat ? '✅ Actif' : '❌ Inactif'),
                Sight::make('created_at', 'Créé le'),
                Sight::make('updated_at', 'Modifié le'),
            ]),
        ];
    }
}
