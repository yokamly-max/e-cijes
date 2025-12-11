<?php

namespace App\Orchid\Screens\Espace;

use App\Models\Espace;
use App\Models\Pays;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Sight;
use Illuminate\Support\HtmlString;

class ShowScreen extends Screen
{
    public function query(Espace $espace): iterable
    {
        $espace->load(['espacetype']);

        // Charger tous les pays depuis Supabase
        $paysModel = new Pays();
        $paysList = collect($paysModel->all())->keyBy('id');

        // Trouver le pays correspondant
        $pays = $paysList[$espace->pays_id] ?? null;

        // Ajouter une propriété pour l'affichage
        $espace->pays_nom = is_array($pays)
            ? ($pays['name'] ?? 'Non défini')
            : ($pays->name ?? 'Non défini');

        return [
            'espace' => $espace,
        ];
    }

    public function name(): ?string
    {
        return 'Détail de l\'espace';
    }

    public function description(): ?string
    {
        return 'Fiche complète de l\'espace sélectionnée';
    }

    public function layout(): iterable
    {
        return [
            Layout::legend('espace', [
                Sight::make('titre', 'Titre'),
                Sight::make('capacite', 'Capacité'),
                Sight::make('resume', 'Résumé'),
                Sight::make('prix', 'Prix'),
                Sight::make('description', 'Description')->render(function ($espace) {
                    return new HtmlString($espace->description); // ✅ Affiche HTML sans échapper
                }),
                Sight::make('espacetype.titre', 'Type d\'espace'),
                Sight::make('vignette', 'Vignette')->render(function ($espace) {
                    if (!$espace->vignette) return '—';
                    return "<img src='" . asset($espace->vignette) . "' width='80'>";
                }),
                Sight::make('pays_nom', 'Pays'),
                Sight::make('spotlight', 'Spotlight')->render(fn($espace) => $espace->spotlight ? '✅ Actif' : '❌ Inactif'),
                Sight::make('etat', 'État')->render(fn($espace) => $espace->etat ? '✅ Actif' : '❌ Inactif'),
                Sight::make('created_at', 'Créé le'),
                Sight::make('updated_at', 'Modifié le'),
            ]),
        ];
    }
}
