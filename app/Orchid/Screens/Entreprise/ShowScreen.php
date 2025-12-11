<?php

namespace App\Orchid\Screens\Entreprise;

use App\Models\Entreprise;
use App\Models\Pays;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Sight;
use Illuminate\Support\HtmlString;

class ShowScreen extends Screen
{
    public function query(Entreprise $entreprise): iterable
    {
        $entreprise->load(['secteur', 'entreprisetype']);

        // Charger tous les pays depuis Supabase
        $paysModel = new Pays();
        $paysList = collect($paysModel->all())->keyBy('id');

        // Trouver le pays correspondant
        $pays = $paysList[$entreprise->pays_id] ?? null;

        // Ajouter une propriété pour l'affichage
        $entreprise->pays_nom = is_array($pays)
            ? ($pays['name'] ?? 'Non défini')
            : ($pays->name ?? 'Non défini');

        return [
            'entreprise' => $entreprise,
        ];
    }

    public function name(): ?string
    {
        return 'Détail de l\'entreprise';
    }

    public function description(): ?string
    {
        return 'Fiche complète de l\'entreprise sélectionnée';
    }

    public function layout(): iterable
    {
        return [
            Layout::legend('entreprise', [
                Sight::make('nom', 'Raison sociale'),
                Sight::make('email', 'Email'),
                Sight::make('pays_nom', 'Pays'),
                Sight::make('pays.indicatif', 'Pays'),
                Sight::make('telephone', 'Téléphone'),
                Sight::make('adresse', 'Adresse'),
                Sight::make('description', 'Description')->render(function ($entreprise) {
                    return new HtmlString($entreprise->description); // ✅ Affiche HTML sans échapper
                }),
                Sight::make('entreprisetype.titre', 'Type de l\'entreprise'),
                Sight::make('secteur.titre', 'Secteur'),
                Sight::make('vignette', 'Vignette')->render(function ($entreprise) {
                    if (!$entreprise->vignette) return '—';
                    return "<img src='" . asset($entreprise->vignette) . "' width='80'>";
                }),
                Sight::make('supabase_startup_id', 'Startup Id'),
                Sight::make('spotlight', 'Spotlight')->render(fn($entreprise) => $entreprise->spotlight ? '✅ Actif' : '❌ Inactif'),
                Sight::make('etat', 'État')->render(fn($entreprise) => $entreprise->etat ? '✅ Actif' : '❌ Inactif'),
                Sight::make('created_at', 'Créé le'),
                Sight::make('updated_at', 'Modifié le'),
            ]),
        ];
    }
}
