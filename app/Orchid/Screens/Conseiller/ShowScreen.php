<?php

namespace App\Orchid\Screens\Conseiller;

use App\Models\Conseiller;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Sight;
use Illuminate\Support\HtmlString;

class ShowScreen extends Screen
{
    public function query(Conseiller $conseiller): iterable
    {
        $conseiller->load(['conseillervalide', 'conseillertype', 'membre']); 

        return [
            'conseiller' => $conseiller,
        ];
    }

    public function name(): ?string
    {
        return 'Détail du conseiller';
    }

    public function description(): ?string
    {
        return 'Fiche complète du conseiller sélectionnée';
    }

    public function layout(): iterable
    {
        return [
            Layout::legend('conseiller', [
                Sight::make('membre.nom_complet', 'Membre'),
                Sight::make('fonction', 'Fonctions de conseillers')->render(function ($conseiller) {
                    return new HtmlString($conseiller->fonction); // ✅ Affiche HTML sans échapper
                }),
                Sight::make('conseillertype.titre', 'Type du conseiller'),
                Sight::make('conseillervalide.titre', 'Validation de conseiller'),
                Sight::make('spotlight', 'Spotlight')->render(fn($conseiller) => $conseiller->spotlight ? '✅ Actif' : '❌ Inactif'),
                Sight::make('etat', 'État')->render(fn($conseiller) => $conseiller->etat ? '✅ Actif' : '❌ Inactif'),
                Sight::make('created_at', 'Créé le'),
                Sight::make('updated_at', 'Modifié le'),
            ]),
        ];
    }
}
