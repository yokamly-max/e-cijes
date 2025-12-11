<?php

namespace App\Orchid\Screens\Pays;

use App\Models\Pays;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Sight;

class ShowScreen extends Screen
{
    public function query(Pays $pays): iterable
    {
        return [
            'pays' => $pays,
        ];
    }

    public function name(): ?string
    {
        return 'Détail du pays';
    }

    public function description(): ?string
    {
        return 'Fiche complète du pays sélectionné';
    }

    public function layout(): iterable
    {
        return [
            Layout::legend('pays', [
                Sight::make('nom', 'Nom'),
                Sight::make('code', 'Code'),
                Sight::make('indicatif', 'Indicatif'),
                Sight::make('monnaie', 'Monnaie'),
                Sight::make('etat', 'État')->render(fn($pays) => $pays->etat ? '✅ Actif' : '❌ Inactif'),
                Sight::make('drapeau', 'Drapeau')->render(function ($pays) {
                    if (!$pays->drapeau) return '—';
                    return "<img src='" . asset($pays->drapeau) . "' width='80'>";
                }),
                Sight::make('created_at', 'Créé le'),
                Sight::make('updated_at', 'Modifié le'),
            ]),
        ];
    }
}
