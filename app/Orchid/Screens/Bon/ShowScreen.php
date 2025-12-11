<?php

namespace App\Orchid\Screens\Bon;

use App\Models\Bon;
use App\Models\Pays;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Sight;
use Illuminate\Support\HtmlString;

class ShowScreen extends Screen
{
    public function query(Bon $bon): iterable
    {
        $bon->load(['bonstatut', 'bontype', 'entreprise', 'user']);

        // Charger tous les pays depuis Supabase
        $paysModel = new Pays();
        $paysList = collect($paysModel->all())->keyBy('id');

        // Trouver le pays correspondant
        $pays = $paysList[$bon->pays_id] ?? null;

        // Ajouter une propriété pour l'affichage
        $bon->pays_nom = is_array($pays)
            ? ($pays['name'] ?? 'Non défini')
            : ($pays->name ?? 'Non défini');

        return [
            'bon' => $bon,
        ];
    }

    public function name(): ?string
    {
        return 'Détail du bon';
    }

    public function description(): ?string
    {
        return 'Fiche complète du bon sélectionnée';
    }

    public function layout(): iterable
    {
        return [
            Layout::legend('bon', [
                Sight::make('datebon', 'Date du bon'),
                Sight::make('montant', 'Montant'),
                Sight::make('bontype.titre', 'Type du bon'),
                Sight::make('bonstatut.titre', 'Statut du bon'),
                Sight::make('pays_nom', 'Pays'),
                Sight::make('entreprise.nom', 'Entreprise'),
                Sight::make('user.name', 'Utilisateur'),
                Sight::make('spotlight', 'Spotlight')->render(fn($bon) => $bon->spotlight ? '✅ Actif' : '❌ Inactif'),
                Sight::make('etat', 'État')->render(fn($bon) => $bon->etat ? '✅ Actif' : '❌ Inactif'),
                Sight::make('created_at', 'Créé le'),
                Sight::make('updated_at', 'Modifié le'),
            ]),
        ];
    }
}
