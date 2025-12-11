<?php

namespace App\Orchid\Screens\Diagnosticreponse;

use App\Models\Diagnosticreponse;
use App\Models\Langue;

use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Sight;
use Illuminate\Support\HtmlString;

class ShowScreen extends Screen
{
    public function query(Diagnosticreponse $diagnosticreponse): iterable
    {
        $diagnosticreponse->load(['diagnosticquestion']); 

        // Charger les langues depuis Supabase
        $langueList = collect((new Langue())->all())->keyBy('id');

        // Récupérer la langue depuis Supabase
        $langue = $langueList->get($diagnosticreponse->langue_id);
        $diagnosticreponse->langue_nom = is_object($langue) ? ($langue->name ?? 'Non défini') : 'Non défini';

        return [
            'diagnosticreponse' => $diagnosticreponse,
        ];
    }

    public function name(): ?string
    {
        return 'Détail de la réponse du diagnostic';
    }

    public function description(): ?string
    {
        return 'Fiche complète de la réponse du diagnostic sélectionnée';
    }

    public function layout(): iterable
    {
        return [
            Layout::legend('diagnosticreponse', [
                Sight::make('titre', 'Titre'),
                Sight::make('position', 'Position'),
                Sight::make('score', 'Score')->render(function ($diagnosticreponse) {
                    return new HtmlString($diagnosticreponse->score); // ✅ Affiche HTML sans échapper
                }),
                Sight::make('langue_nom', 'Langue'),
                Sight::make('diagnosticquestion.titre', 'Question du diagnostic'),
                Sight::make('spotlight', 'Spotlight')->render(fn($diagnosticreponse) => $diagnosticreponse->spotlight ? '✅ Actif' : '❌ Inactif'),
                Sight::make('etat', 'État')->render(fn($diagnosticreponse) => $diagnosticreponse->etat ? '✅ Actif' : '❌ Inactif'),
                Sight::make('created_at', 'Créé le'),
                Sight::make('updated_at', 'Modifié le'),
            ]),
        ];
    }
}
