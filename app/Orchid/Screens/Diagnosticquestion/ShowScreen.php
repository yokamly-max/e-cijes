<?php

namespace App\Orchid\Screens\Diagnosticquestion;

use App\Models\Diagnosticquestion;
use App\Models\Langue;

use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Sight;
use Illuminate\Support\HtmlString;

class ShowScreen extends Screen
{
    public function query(Diagnosticquestion $diagnosticquestion): iterable
    {
        $diagnosticquestion->load(['diagnosticmodule', 'diagnosticquestiontype', 'diagnosticquestioncategorie']); 

        // Charger les langues depuis Supabase
        $langueList = collect((new Langue())->all())->keyBy('id');

        // Récupérer la langue depuis Supabase
        $langue = $langueList->get($diagnosticquestion->langue_id);
        $diagnosticquestion->langue_nom = is_object($langue) ? ($langue->name ?? 'Non défini') : 'Non défini';

        return [
            'diagnosticquestion' => $diagnosticquestion,
        ];
    }

    public function name(): ?string
    {
        return 'Détail de la question du diagnostic';
    }

    public function description(): ?string
    {
        return 'Fiche complète de la question du diagnostic sélectionnée';
    }

    public function layout(): iterable
    {
        return [
            Layout::legend('diagnosticquestion', [
                Sight::make('langue_nom', 'Langue'),
                Sight::make('diagnosticmodule.titre', 'Module du diagnostic'),
                Sight::make('titre', 'Titre'),
                Sight::make('position', 'Position'),
                Sight::make('diagnosticquestiontype.titre', 'Type de la question du diagnostic'),
                Sight::make('diagnosticquestioncategorie.titre', 'Categorie de la question du diagnostic'),
                Sight::make('questionparent.titre', 'Question parente'),
                Sight::make('obligatoire', 'Obligatoire')->render(fn($diagnosticquestion) => $diagnosticquestion->obligatoire ? '✅ Oui' : '❌ Non'),
                Sight::make('spotlight', 'Spotlight')->render(fn($diagnosticquestion) => $diagnosticquestion->spotlight ? '✅ Actif' : '❌ Inactif'),
                Sight::make('etat', 'État')->render(fn($diagnosticquestion) => $diagnosticquestion->etat ? '✅ Actif' : '❌ Inactif'),
                Sight::make('created_at', 'Créé le'),
                Sight::make('updated_at', 'Modifié le'),
            ]),
        ];
    }
}
