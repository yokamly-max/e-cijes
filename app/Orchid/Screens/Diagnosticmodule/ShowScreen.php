<?php

namespace App\Orchid\Screens\Diagnosticmodule;

use App\Models\Diagnosticmodule;
use App\Models\Pays;
use App\Models\Langue;

use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Sight;
use Illuminate\Support\HtmlString;

class ShowScreen extends Screen
{
    public function query(Diagnosticmodule $diagnosticmodule): iterable
    {
        $diagnosticmodule->load(['diagnosticmoduletype']); 

        // Charger les pays et langues depuis Supabase
        $paysList = collect((new Pays())->all())->keyBy('id');
        $langueList = collect((new Langue())->all())->keyBy('id');

        // Récupérer le pays depuis Supabase
        $pays = $paysList->get($diagnosticmodule->pays_id);
        $diagnosticmodule->pays_nom = is_object($pays) ? ($pays->name ?? 'Non défini') : 'Non défini';

        // Récupérer la langue depuis Supabase
        $langue = $langueList->get($diagnosticmodule->langue_id);
        $diagnosticmodule->langue_nom = is_object($langue) ? ($langue->name ?? 'Non défini') : 'Non défini';

        return [
            'diagnosticmodule' => $diagnosticmodule,
        ];
    }

    public function name(): ?string
    {
        return 'Détail du module de diagnostic';
    }

    public function description(): ?string
    {
        return 'Fiche complète du module de diagnostic sélectionnée';
    }

    public function layout(): iterable
    {
        return [
            Layout::legend('diagnosticmodule', [
                Sight::make('titre', 'Titre'),
                Sight::make('position', 'Position'),
                Sight::make('description', 'Description')->render(function ($diagnosticmodule) {
                    return new HtmlString($diagnosticmodule->description); // ✅ Affiche HTML sans échapper
                }),
                Sight::make('diagnosticmoduletype.titre', 'Type'),
                Sight::make('moduleparent.titre', 'Module parent'),
                Sight::make('langue_nom', 'Langue'),
                Sight::make('pays_nom', 'Pays'),
                Sight::make('spotlight', 'Spotlight')->render(fn($diagnosticmodule) => $diagnosticmodule->spotlight ? '✅ Actif' : '❌ Inactif'),
                Sight::make('etat', 'État')->render(fn($diagnosticmodule) => $diagnosticmodule->etat ? '✅ Actif' : '❌ Inactif'),
                Sight::make('created_at', 'Créé le'),
                Sight::make('updated_at', 'Modifié le'),
            ]),
        ];
    }
}
