<?php

namespace App\Orchid\Screens\Faq;

use App\Models\Faq;
use App\Models\Pays;
use App\Models\Langue;

use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Sight;
use Illuminate\Support\HtmlString;

class ShowScreen extends Screen
{
    public function query(Faq $faq): iterable
    {
        //$faq->load(['langue']);

        // Charger les pays et langues depuis Supabase
        $paysList = collect((new Pays())->all())->keyBy('id');
        $langueList = collect((new Langue())->all())->keyBy('id');

        // Récupérer le pays depuis Supabase
        $pays = $paysList->get($faq->pays_id);
        $faq->pays_nom = is_object($pays) ? ($pays->name ?? 'Non défini') : 'Non défini';

        // Récupérer la langue depuis Supabase
        $langue = $langueList->get($faq->langue_id);
        $faq->langue_nom = is_object($langue) ? ($langue->name ?? 'Non défini') : 'Non défini';

        return [
            'faq' => $faq,
        ];
    }

    public function name(): ?string
    {
        return 'Détail de la question';
    }

    public function description(): ?string
    {
        return 'Fiche complète de la question sélectionnée';
    }

    public function layout(): iterable
    {
        return [
            Layout::legend('faq', [
                Sight::make('question', 'Question'),
                Sight::make('reponse', 'Reponse')->render(function ($faq) {
                    return new HtmlString($faq->reponse); // ✅ Affiche HTML sans échapper
                }),
                Sight::make('langue_nom', 'Langue'),
                Sight::make('pays_nom', 'Pays'),
                Sight::make('spotlight', 'Spotlight')->render(fn($faq) => $faq->spotlight ? '✅ Actif' : '❌ Inactif'),
                Sight::make('etat', 'État')->render(fn($faq) => $faq->etat ? '✅ Actif' : '❌ Inactif'),
                Sight::make('created_at', 'Créé le'),
                Sight::make('updated_at', 'Modifié le'),
            ]),
        ];
    }
}
