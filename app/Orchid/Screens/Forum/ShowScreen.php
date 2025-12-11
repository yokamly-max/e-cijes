<?php

namespace App\Orchid\Screens\Forum;

use App\Models\Forum;
use App\Models\Pays;
use App\Models\Langue;

use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Sight;
use Illuminate\Support\HtmlString;

class ShowScreen extends Screen
{
    public function query(Forum $forum): iterable
    {
        $forum->load(['forumtype', 'secteur']);

        // Charger les pays et langues depuis Supabase
        $paysList = collect((new Pays())->all())->keyBy('id');
        $langueList = collect((new Langue())->all())->keyBy('id');

        // Récupérer le pays depuis Supabase
        $pays = $paysList->get($forum->pays_id);
        $forum->pays_nom = is_object($pays) ? ($pays->name ?? 'Non défini') : 'Non défini';

        // Récupérer la langue depuis Supabase
        $langue = $langueList->get($forum->langue_id);
        $forum->langue_nom = is_object($langue) ? ($langue->name ?? 'Non défini') : 'Non défini';

        return [
            'forum' => $forum,
        ];
    }

    public function name(): ?string
    {
        return 'Détail du forum';
    }

    public function description(): ?string
    {
        return 'Fiche complète du forum sélectionnée';
    }

    public function layout(): iterable
    {
        return [
            Layout::legend('forum', [
                Sight::make('dateforum', 'Date du forum'),
                Sight::make('titre', 'Titre'),
                Sight::make('resume', 'Résumé'),
                Sight::make('description', 'Description')->render(function ($forum) {
                    return new HtmlString($forum->description); // ✅ Affiche HTML sans échapper
                }),
                Sight::make('forumtype.titre', 'Type du forum'),
                Sight::make('secteur.titre', 'Secteur'),
                Sight::make('vignette', 'Vignette')->render(function ($forum) {
                    if (!$forum->vignette) return '—';
                    return "<img src='" . asset($forum->vignette) . "' width='80'>";
                }),
                Sight::make('langue_nom', 'Langue'),
                Sight::make('pays_nom', 'Pays'),
                Sight::make('spotlight', 'Spotlight')->render(fn($forum) => $forum->spotlight ? '✅ Actif' : '❌ Inactif'),
                Sight::make('etat', 'État')->render(fn($forum) => $forum->etat ? '✅ Actif' : '❌ Inactif'),
                Sight::make('created_at', 'Créé le'),
                Sight::make('updated_at', 'Modifié le'),
            ]),
        ];
    }
}
