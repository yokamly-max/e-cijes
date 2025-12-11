<?php

namespace App\Orchid\Screens\Credit;

use App\Models\Credit;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Sight;
use Illuminate\Support\HtmlString;

class ShowScreen extends Screen
{
    public function query(Credit $credit): iterable
    {
        $credit->load(['creditstatut', 'credittype', 'entreprise', 'partenaire', 'user']); 

        // Charger tous les pays depuis Supabase
        $paysModel = new Pays();
        $paysList = collect($paysModel->all())->keyBy('id');

        // Trouver le pays correspondant
        $pays = $paysList[$credit->pays_id] ?? null;

        // Ajouter une propriété pour l'affichage
        $credit->pays_nom = is_array($pays)
            ? ($pays['name'] ?? 'Non défini')
            : ($pays->name ?? 'Non défini');

        return [
            'credit' => $credit,
        ];
    }

    public function name(): ?string
    {
        return 'Détail du crédit';
    }

    public function description(): ?string
    {
        return 'Fiche complète du crédit sélectionnée';
    }

    public function layout(): iterable
    {
        return [
            Layout::legend('credit', [
                Sight::make('entreprise.nom', 'Entreprise'),
                Sight::make('credittype.titre', 'Type du crédit'),
                Sight::make('montanttotal', 'Montant total'),
                Sight::make('montantutilise', 'Montant utilisé'),
                Sight::make('datecredit', 'Date du crédit'),
                Sight::make('creditstatut.titre', 'Statut du crédit'),
                Sight::make('pays_nom', 'Pays'),
                Sight::make('partenaire.titre', 'Partenaire'),
                Sight::make('user.name', 'Utilisateur'),
                Sight::make('spotlight', 'Spotlight')->render(fn($credit) => $credit->spotlight ? '✅ Actif' : '❌ Inactif'),
                Sight::make('etat', 'État')->render(fn($credit) => $credit->etat ? '✅ Actif' : '❌ Inactif'),
                Sight::make('created_at', 'Créé le'),
                Sight::make('updated_at', 'Modifié le'),
            ]),
        ];
    }
}
