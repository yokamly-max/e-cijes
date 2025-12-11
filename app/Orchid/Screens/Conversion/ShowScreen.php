<?php

namespace App\Orchid\Screens\Conversion;

use App\Models\Conversion;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Sight;
use Illuminate\Support\HtmlString;

class ShowScreen extends Screen
{
    public function query(Conversion $conversion): iterable
    {
        $conversion->load(['membre', 'entreprise', 'ressourcetransactionsource', 'ressourcetransactioncible']); 

        return [
            'conversion' => $conversion,
        ];
    }

    public function name(): ?string
    {
        return 'Détail de la conversion';
    }

    public function description(): ?string
    {
        return 'Fiche complète de la conversion sélectionnée';
    }

    public function layout(): iterable
    {
        return [
            Layout::legend('conversion', [
                Sight::make('membre.nom_complet', 'Membre'),
                Sight::make('entreprise.nom', 'Entreprise'),
                Sight::make('taux', 'Taux'),
                Sight::make('ressourcetransactionsource.reference', 'Transaction Source'),
                Sight::make('ressourcetransactioncible.reference', 'Transaction Cible'),
                Sight::make('spotlight', 'Spotlight')->render(fn($conversion) => $conversion->spotlight ? '✅ Actif' : '❌ Inactif'),
                Sight::make('etat', 'État')->render(fn($conversion) => $conversion->etat ? '✅ Actif' : '❌ Inactif'),
                Sight::make('created_at', 'Créé le'),
                Sight::make('updated_at', 'Modifié le'),
            ]),
        ];
    }
}
