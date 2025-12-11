<?php

namespace App\Orchid\Screens\Diagnostic;

use App\Models\Diagnostic;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Sight;
use Illuminate\Support\HtmlString;

class ShowScreen extends Screen
{
    public function query(Diagnostic $diagnostic): iterable
    {
        $diagnostic->load(['accompagnement', 'diagnostictype', 'diagnosticstatut', 'membre', 'entreprise']); 

        return [
            'diagnostic' => $diagnostic,
        ];
    }

    public function name(): ?string
    {
        return 'Détail du diagnostic';
    }

    public function description(): ?string
    {
        return 'Fiche complète du diagnostic sélectionnée';
    }

    public function layout(): iterable
    {
        return [
            Layout::legend('diagnostic', [
                Sight::make('membre.nom_complet', 'Membre'),
                Sight::make('entreprise.nom', 'Entreprise'),
                Sight::make('accompagnement.nom_complet', 'Accompagnement'),
                Sight::make('scoreglobal', 'Score global'),
                Sight::make('commentaire', 'Commentaire'),
                Sight::make('diagnostictype.titre', 'Profil émotionnel'),
                Sight::make('diagnosticstatut.titre', 'Statut du diagnostic'),
                Sight::make('spotlight', 'Spotlight')->render(fn($diagnostic) => $diagnostic->spotlight ? '✅ Actif' : '❌ Inactif'),
                Sight::make('etat', 'État')->render(fn($diagnostic) => $diagnostic->etat ? '✅ Actif' : '❌ Inactif'),
                Sight::make('created_at', 'Créé le'),
                Sight::make('updated_at', 'Modifié le'),
            ]),
        ];
    }
}
