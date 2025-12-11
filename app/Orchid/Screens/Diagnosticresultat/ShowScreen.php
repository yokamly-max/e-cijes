<?php

namespace App\Orchid\Screens\Diagnosticresultat;

use App\Models\Diagnosticresultat;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Sight;
use Illuminate\Support\HtmlString;

class ShowScreen extends Screen
{
    public function query(Diagnosticresultat $diagnosticresultat): iterable
    {
        $diagnosticresultat->load(['diagnosticquestion', 'diagnosticreponse', 'diagnostic']); 

        return [
            'diagnosticresultat' => $diagnosticresultat,
        ];
    }

    public function name(): ?string
    {
        return 'Détail du résultat du diagnostic';
    }

    public function description(): ?string
    {
        return 'Fiche complète du résultat du diagnostic sélectionnée';
    }

    public function layout(): iterable
    {
        return [
            Layout::legend('diagnosticresultat', [
                Sight::make('diagnostic.nom_complet', 'Diagnostic'),
                Sight::make('diagnosticquestion.titre', 'Question'),
                Sight::make('diagnosticreponse.titre', 'Réponse'),
                Sight::make('reponsetexte', 'Réponse texte'),
                Sight::make('diagnosticreponseids', 'Les réponses'),
                Sight::make('spotlight', 'Spotlight')->render(fn($diagnosticresultat) => $diagnosticresultat->spotlight ? '✅ Actif' : '❌ Inactif'),
                Sight::make('etat', 'État')->render(fn($diagnosticresultat) => $diagnosticresultat->etat ? '✅ Actif' : '❌ Inactif'),
                Sight::make('created_at', 'Créé le'),
                Sight::make('updated_at', 'Modifié le'),
            ]),
        ];
    }
}
