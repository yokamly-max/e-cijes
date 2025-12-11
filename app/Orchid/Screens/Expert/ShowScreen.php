<?php

namespace App\Orchid\Screens\Expert;

use App\Models\Expert;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Sight;
use Illuminate\Support\HtmlString;

class ShowScreen extends Screen
{
    public function query(Expert $expert): iterable
    {
        $expert->load(['expertvalide', 'experttype', 'membre']); 

        return [
            'expert' => $expert,
        ];
    }

    public function name(): ?string
    {
        return 'Détail de l\'expert';
    }

    public function description(): ?string
    {
        return 'Fiche complète de l\'expert sélectionnée';
    }

    public function layout(): iterable
    {
        return [
            Layout::legend('expert', [
                Sight::make('membre.nom_complet', 'Membre'),
                Sight::make('domaine', 'Domaines d\'expertises')->render(function ($expert) {
                    return new HtmlString($expert->domaine); // ✅ Affiche HTML sans échapper
                }),
                Sight::make('experttype.titre', 'Type de l\'expert'),
                Sight::make('expertvalide.titre', 'Validation d\'expert'),
                Sight::make('fichier', 'Fichier')->render(function ($expert) {
                    if (!$expert->fichier) return '—';
                    return "<a href='" . asset($expert->fichier) . "' class='btn btn-outline-primary btn-sm' download style='display: inline;'>📄 Télécharger</a>";
                }),
                Sight::make('spotlight', 'Spotlight')->render(fn($expert) => $expert->spotlight ? '✅ Actif' : '❌ Inactif'),
                Sight::make('etat', 'État')->render(fn($expert) => $expert->etat ? '✅ Actif' : '❌ Inactif'),
                Sight::make('created_at', 'Créé le'),
                Sight::make('updated_at', 'Modifié le'),
            ]),
        ];
    }
}
