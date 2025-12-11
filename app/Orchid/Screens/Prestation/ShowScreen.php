<?php

namespace App\Orchid\Screens\Prestation;

use App\Models\Prestation;
use App\Models\Pays;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Sight;
use Illuminate\Support\HtmlString;

class ShowScreen extends Screen
{
    public function query(Prestation $prestation): iterable
    {
        $prestation->load(['entreprise', 'prestationtype']);

        // Charger tous les pays depuis Supabase
        $paysModel = new Pays();
        $paysList = collect($paysModel->all())->keyBy('id');

        // Trouver le pays correspondant
        $pays = $paysList[$prestation->pays_id] ?? null;

        // Ajouter une propriété pour l'affichage
        $prestation->pays_nom = is_array($pays)
            ? ($pays['name'] ?? 'Non défini')
            : ($pays->name ?? 'Non défini');

        return [
            'prestation' => $prestation,
        ];
    }

    public function name(): ?string
    {
        return 'Détail de la prestation';
    }

    public function description(): ?string
    {
        return 'Fiche complète de la prestation sélectionnée';
    }

    public function layout(): iterable
    {
        return [
            Layout::legend('prestation', [
                Sight::make('titre', 'Titre'),
                Sight::make('prix', 'Prix'),
                Sight::make('duree', 'Durée'),
                Sight::make('description', 'Description'),
                Sight::make('prestationtype.titre', 'Type de la prestation'),
                Sight::make('entreprise.nom', 'Entreprise'),
                Sight::make('pays_nom', 'Pays'),
                Sight::make('spotlight', 'Spotlight')->render(fn($prestation) => $prestation->spotlight ? '✅ Actif' : '❌ Inactif'),
                Sight::make('etat', 'État')->render(fn($prestation) => $prestation->etat ? '✅ Actif' : '❌ Inactif'),
                Sight::make('created_at', 'Créé le'),
                Sight::make('updated_at', 'Modifié le'),
            ]),
        ];
    }
}
