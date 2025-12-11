<?php

namespace App\Orchid\Screens\Piece;

use App\Models\Piece;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Sight;
use Illuminate\Support\HtmlString;

class ShowScreen extends Screen
{
    public function query(Piece $piece): iterable
    {
        $piece->load(['piecetype', 'entreprise']); 

        return [
            'piece' => $piece,
        ];
    }

    public function name(): ?string
    {
        return 'Détail d\'une pièce';
    }

    public function description(): ?string
    {
        return 'Fiche complète du pièce sélectionnée';
    }

    public function layout(): iterable
    {
        return [
            Layout::legend('piece', [
                Sight::make('datepiece', 'Date'),
                Sight::make('titre', 'Titre'),
                Sight::make('piecetype.titre', 'Type de la pièce'),
                Sight::make('fichier', 'Fichier')->render(function ($piece) {
                    if (!$piece->fichier) return '—';
                    return "<a href='" . asset($piece->fichier) . "' class='btn btn-outline-primary btn-sm' download style='display: inline;'>📄 Télécharger</a>";
                }),
                Sight::make('entreprise.nom', 'Entreprise'),
                Sight::make('spotlight', 'Spotlight')->render(fn($piece) => $piece->spotlight ? '✅ Actif' : '❌ Inactif'),
                Sight::make('etat', 'État')->render(fn($piece) => $piece->etat ? '✅ Actif' : '❌ Inactif'),
                Sight::make('created_at', 'Créé le'),
                Sight::make('updated_at', 'Modifié le'),
            ]),
        ];
    }
}
