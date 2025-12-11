<?php

namespace App\Orchid\Screens\Membre;

use App\Models\Membre;
use App\Models\Pays;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Sight;
use Illuminate\Support\HtmlString;

class ShowScreen extends Screen
{
    public function query(Membre $membre): iterable
    {
        $membre->load(['membrestatut', 'membretype']);

        // Charger tous les pays depuis Supabase
        $paysModel = new Pays();
        $paysList = collect($paysModel->all())->keyBy('id');

        // Trouver le pays correspondant
        $pays = $paysList[$membre->pays_id] ?? null;

        // Ajouter une propriété pour l'affichage
        $membre->pays_nom = is_array($pays)
            ? ($pays['name'] ?? 'Non défini')
            : ($pays->name ?? 'Non défini');

        return [
            'membre' => $membre,
        ];
    }

    public function name(): ?string
    {
        return 'Détail du membre';
    }

    public function description(): ?string
    {
        return 'Fiche complète du membre sélectionnée';
    }

    public function layout(): iterable
    {
        return [
            Layout::legend('membre', [
                Sight::make('nom', 'Nom'),
                Sight::make('prenom', 'Prénom(s)'),
                Sight::make('user_id', 'User'),
                Sight::make('email', 'Email'),
                Sight::make('membretype.titre', 'Type du membre'),
                Sight::make('vignette', 'Vignette')->render(function ($membre) {
                    if (!$membre->vignette) return '—';
                    return "<img src='" . asset($membre->vignette) . "' width='80'>";
                }),
                Sight::make('membrestatut.titre', 'Statut du membre'),
                Sight::make('pays_nom', 'Pays'),
                Sight::make('telephone', 'Téléphone'),
                Sight::make('etat', 'État')->render(fn($membre) => $membre->etat ? '✅ Actif' : '❌ Inactif'),
                Sight::make('created_at', 'Créé le'),
                Sight::make('updated_at', 'Modifié le'),
            ]),
        ];
    }
}
