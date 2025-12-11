<?php

namespace App\Orchid\Screens\Commentaire;

use App\Models\Commentaire;
use App\Models\Pays;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Sight;
use Illuminate\Support\HtmlString;

class ShowScreen extends Screen
{
    public function query(Commentaire $commentaire): iterable
    {
        $commentaire->load(['actualite']);

        // Charger tous les pays depuis Supabase
        $paysModel = new Pays();
        $paysList = collect($paysModel->all())->keyBy('id');

        // Trouver le pays correspondant
        $pays = $paysList[$commentaire->pays_id] ?? null;

        // Ajouter une propriété pour l'affichage
        $commentaire->pays_nom = is_array($pays)
            ? ($pays['name'] ?? 'Non défini')
            : ($pays->name ?? 'Non défini');

        return [
            'commentaire' => $commentaire,
        ];
    }

    public function name(): ?string
    {
        return 'Détail du commentaire';
    }

    public function description(): ?string
    {
        return 'Fiche complète du commentaire sélectionnée';
    }

    public function layout(): iterable
    {
        return [
            Layout::legend('commentaire', [
                Sight::make('nom', 'Nom et prénom(s)'),
                Sight::make('email', 'Email'),
                Sight::make('message', 'Message'),
                Sight::make('actualite.titre', 'Actualité'),
                Sight::make('pays_nom', 'Pays'),
                Sight::make('etat', 'État')->render(fn($commentaire) => $commentaire->etat ? '✅ Actif' : '❌ Inactif'),
                Sight::make('created_at', 'Créé le'),
                Sight::make('updated_at', 'Modifié le'),
            ]),
        ];
    }
}
