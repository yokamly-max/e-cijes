<?php

namespace App\Orchid\Screens\Formation;

use App\Models\Formation;
use App\Models\Pays;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Sight;
use Illuminate\Support\HtmlString;

class ShowScreen extends Screen
{
    public function query(Formation $formation): iterable
    {
        $formation->load(['expert', 'formationniveau', 'formationtype']);

        // Charger tous les pays depuis Supabase
        $paysModel = new Pays();
        $paysList = collect($paysModel->all())->keyBy('id');

        // Trouver le pays correspondant
        $pays = $paysList[$formation->pays_id] ?? null;

        // Ajouter une propriété pour l'affichage
        $formation->pays_nom = is_array($pays)
            ? ($pays['name'] ?? 'Non défini')
            : ($pays->name ?? 'Non défini');

        return [
            'formation' => $formation,
        ];
    }

    public function name(): ?string
    {
        return 'Détail de la formation';
    }

    public function description(): ?string
    {
        return 'Fiche complète de la formation sélectionnée';
    }

    public function layout(): iterable
    {
        return [
            Layout::legend('formation', [
                Sight::make('titre', 'Titre'),
                Sight::make('datedebut', 'Date début'),
                Sight::make('datefin', 'Date fin'),
                Sight::make('prix', 'Prix'),
                Sight::make('description', 'Description'),
                Sight::make('formationtype.titre', 'Type de la formation'),
                Sight::make('formationniveau.titre', 'Niveau de la formation'),
                Sight::make('expert.membre.nom_complet', 'Expert'),
                Sight::make('pays_nom', 'Pays'),
                Sight::make('spotlight', 'Spotlight')->render(fn($formation) => $formation->spotlight ? '✅ Actif' : '❌ Inactif'),
                Sight::make('etat', 'État')->render(fn($formation) => $formation->etat ? '✅ Actif' : '❌ Inactif'),
                Sight::make('created_at', 'Créé le'),
                Sight::make('updated_at', 'Modifié le'),
            ]),
        ];
    }
}
