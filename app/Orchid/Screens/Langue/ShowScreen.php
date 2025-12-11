<?php

namespace App\Orchid\Screens\Langue;

use App\Models\Langue;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Sight;

class ShowScreen extends Screen
{
    public function query(Langue $langue): iterable
    {
        return [
            'langue' => $langue,
        ];
    }

    public function name(): ?string
    {
        return 'Détail du langue';
    }

    public function description(): ?string
    {
        return 'Fiche complète du langue sélectionné';
    }

    public function layout(): iterable
    {
        return [
            Layout::legend('langue', [
                Sight::make('nom', 'Nom'),
                Sight::make('code', 'Code'),
                Sight::make('indicatif', 'Indicatif'),
                Sight::make('monnaie', 'Monnaie'),
                Sight::make('etat', 'État')->render(fn($langue) => $langue->etat ? '✅ Actif' : '❌ Inactif'),
                Sight::make('drapeau', 'Drapeau')->render(function ($langue) {
                    if (!$langue->drapeau) return '—';
                    return "<img src='" . asset($langue->drapeau) . "' width='80'>";
                }),
                Sight::make('created_at', 'Créé le'),
                Sight::make('updated_at', 'Modifié le'),
            ]),
        ];
    }
}
