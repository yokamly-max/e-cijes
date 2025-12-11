<?php

namespace App\Orchid\Screens\Evenementinscription;

use App\Models\Evenementinscription;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Sight;
use Illuminate\Support\HtmlString;

class ShowScreen extends Screen
{
    public function query(Evenementinscription $evenementinscription): iterable
    {
        $evenementinscription->load(['membre', 'evenement', 'evenementinscriptiontype']); 

        return [
            'evenementinscription' => $evenementinscription,
        ];
    }

    public function name(): ?string
    {
        return 'Détail de l\'inscription à l\'évènement';
    }

    public function description(): ?string
    {
        return 'Fiche complète de l\'inscription à l\'évènement sélectionnée';
    }

    public function layout(): iterable
    {
        return [
            Layout::legend('evenementinscription', [
                Sight::make('membre.nom_complet', 'Membre'),
                Sight::make('dateevenementinscription', 'Date de l\'inscription à l\'évènement'),
                Sight::make('evenement.titre', 'Evènement'),
                Sight::make('evenementinscriptiontype.titre', 'Type de l\'inscription à l\'évènement'),
                Sight::make('spotlight', 'Spotlight')->render(fn($evenementinscription) => $evenementinscription->spotlight ? '✅ Actif' : '❌ Inactif'),
                Sight::make('etat', 'État')->render(fn($evenementinscription) => $evenementinscription->etat ? '✅ Actif' : '❌ Inactif'),
                Sight::make('created_at', 'Créé le'),
                Sight::make('updated_at', 'Modifié le'),
            ]),
        ];
    }
}
