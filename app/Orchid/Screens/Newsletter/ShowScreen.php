<?php

namespace App\Orchid\Screens\Newsletter;

use App\Models\Newsletter;
use App\Models\Pays;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Sight;
use Illuminate\Support\HtmlString;

class ShowScreen extends Screen
{
    public function query(Newsletter $newsletter): iterable
    {
        $newsletter->load(['newslettertype']);

        // Charger tous les pays depuis Supabase
        $paysModel = new Pays();
        $paysList = collect($paysModel->all())->keyBy('id');

        // Trouver le pays correspondant
        $pays = $paysList[$newsletter->pays_id] ?? null;

        // Ajouter une propriété pour l'affichage
        $newsletter->pays_nom = is_array($pays)
            ? ($pays['name'] ?? 'Non défini')
            : ($pays->name ?? 'Non défini');

        return [
            'newsletter' => $newsletter,
        ];
    }

    public function name(): ?string
    {
        return 'Détail de la newsletter';
    }

    public function description(): ?string
    {
        return 'Fiche complète de la newsletter sélectionnée';
    }

    public function layout(): iterable
    {
        return [
            Layout::legend('newsletter', [
                Sight::make('nom', 'Nom et prénom.s'),
                Sight::make('email', 'Email'),
                Sight::make('pays_nom', 'Pays'),
                Sight::make('pays.indicatif', 'Pays'),
                Sight::make('newslettertype.titre', 'Type de la newsletter'),
                Sight::make('spotlight', 'Spotlight')->render(fn($newsletter) => $newsletter->spotlight ? '✅ Actif' : '❌ Inactif'),
                Sight::make('etat', 'État')->render(fn($newsletter) => $newsletter->etat ? '✅ Actif' : '❌ Inactif'),
                Sight::make('created_at', 'Créé le'),
                Sight::make('updated_at', 'Modifié le'),
            ]),
        ];
    }
}
