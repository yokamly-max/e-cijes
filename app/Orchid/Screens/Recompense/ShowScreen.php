<?php

namespace App\Orchid\Screens\Recompense;

use App\Models\Recompense;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Sight;
use Illuminate\Support\HtmlString;

class ShowScreen extends Screen
{
    public function query(Recompense $recompense): iterable
    {
        $recompense->load(['action', 'ressourcetype', 'membre']); 

        return [
            'recompense' => $recompense,
        ];
    }

    public function name(): ?string
    {
        return 'Détail de la récompense';
    }

    public function description(): ?string
    {
        return 'Fiche complète de la récompense sélectionnée';
    }

    public function layout(): iterable
    {
        return [
            Layout::legend('recompense', [
                Sight::make('membre.nom_complet', 'Membre'),
                Sight::make('entreprise.nom', 'Entreprise'),
                Sight::make('source_id', 'Source'),
                Sight::make('action.titre', 'Action'),
                Sight::make('valeur', 'Valeur'),
                Sight::make('commentaire', 'Commentaire'),
                Sight::make('ressourcetype.titre', 'Type de ressource'),
                Sight::make('spotlight', 'Spotlight')->render(fn($recompense) => $recompense->spotlight ? '✅ Actif' : '❌ Inactif'),
                Sight::make('etat', 'État')->render(fn($recompense) => $recompense->etat ? '✅ Actif' : '❌ Inactif'),
                Sight::make('created_at', 'Créé le'),
                Sight::make('updated_at', 'Modifié le'),
            ]),
        ];
    }
}
