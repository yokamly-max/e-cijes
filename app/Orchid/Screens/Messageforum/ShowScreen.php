<?php

namespace App\Orchid\Screens\Messageforum;

use App\Models\Messageforum;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Sight;
use Illuminate\Support\HtmlString;

class ShowScreen extends Screen
{
    public function query(Messageforum $messageforum): iterable
    {
        $messageforum->load(['sujet', 'membre']); 

        return [
            'messageforum' => $messageforum,
        ];
    }

    public function name(): ?string
    {
        return 'Détail du message';
    }

    public function description(): ?string
    {
        return 'Fiche complète du message sélectionnée';
    }

    public function layout(): iterable
    {
        return [
            Layout::legend('messageforum', [
                Sight::make('contenu', 'Contenu'),
                Sight::make('sujet.titre', 'Sujet'),
                Sight::make('membre.nom_complet', 'Membre'),
                Sight::make('spotlight', 'Spotlight')->render(fn($messageforum) => $messageforum->spotlight ? '✅ Actif' : '❌ Inactif'),
                Sight::make('etat', 'État')->render(fn($messageforum) => $messageforum->etat ? '✅ Actif' : '❌ Inactif'),
                Sight::make('created_at', 'Créé le'),
                Sight::make('updated_at', 'Modifié le'),
            ]),
        ];
    }
}
