<?php

namespace App\Orchid\Screens\Entreprisemembre;

use App\Models\Entreprisemembre;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Sight;
use Illuminate\Support\HtmlString;

class ShowScreen extends Screen
{
    public function query(Entreprisemembre $entreprisemembre): iterable
    {
        $entreprisemembre->load(['membre', 'entreprise']); 

        return [
            'entreprisemembre' => $entreprisemembre,
        ];
    }

    public function name(): ?string
    {
        return 'Détail du membre de l\'entreprise';
    }

    public function description(): ?string
    {
        return 'Fiche complète du membre de l\'entreprise sélectionnée';
    }

    public function layout(): iterable
    {
        return [
            Layout::legend('entreprisemembre', [
                Sight::make('fonction', 'Fonction'),
                Sight::make('bio', 'Bio'),
                Sight::make('membre.nom_complet', 'Membre'),
                Sight::make('entreprise.nom', 'Entreprise'),
                Sight::make('spotlight', 'Spotlight')->render(fn($entreprisemembre) => $entreprisemembre->spotlight ? '✅ Actif' : '❌ Inactif'),
                Sight::make('etat', 'État')->render(fn($entreprisemembre) => $entreprisemembre->etat ? '✅ Actif' : '❌ Inactif'),
                Sight::make('created_at', 'Créé le'),
                Sight::make('updated_at', 'Modifié le'),
            ]),
        ];
    }
}
