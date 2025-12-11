<?php

namespace App\Orchid\Screens\Sujet;

use App\Models\Sujet;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Sight;
use Illuminate\Support\HtmlString;

class ShowScreen extends Screen
{
    public function query(Sujet $sujet): iterable
    {
        $sujet->load(['forum', 'membre']); 

        return [
            'sujet' => $sujet,
        ];
    }

    public function name(): ?string
    {
        return 'Détail du sujet';
    }

    public function description(): ?string
    {
        return 'Fiche complète du sujet sélectionnée';
    }

    public function layout(): iterable
    {
        return [
            Layout::legend('sujet', [
                Sight::make('titre', 'Titre'),
                Sight::make('resume', 'Résumé'),
                Sight::make('description', 'Description')->render(function ($sujet) {
                    return new HtmlString($sujet->description); // ✅ Affiche HTML sans échapper
                }),
                Sight::make('forum.titre', 'Forum'),
                Sight::make('vignette', 'Vignette')->render(function ($sujet) {
                    if (!$sujet->vignette) return '—';
                    return "<img src='" . asset($sujet->vignette) . "' width='80'>";
                }),
                Sight::make('membre.nom_complet', 'Membre'),
                Sight::make('spotlight', 'Spotlight')->render(fn($sujet) => $sujet->spotlight ? '✅ Actif' : '❌ Inactif'),
                Sight::make('etat', 'État')->render(fn($sujet) => $sujet->etat ? '✅ Actif' : '❌ Inactif'),
                Sight::make('created_at', 'Créé le'),
                Sight::make('updated_at', 'Modifié le'),
            ]),
        ];
    }
}
