<?php

namespace App\Orchid\Screens\Alerte;

use App\Models\Alerte;
use App\Models\Langue;

use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Sight;
use Illuminate\Support\HtmlString;

class ShowScreen extends Screen
{
    public function query(Alerte $alerte): iterable
    {
        $alerte->load(['alertetype', 'recompense', 'membre']); 

        // Charger les langues depuis Supabase
        $langueList = collect((new Langue())->all())->keyBy('id');

        // Récupérer la langue depuis Supabase
        $langue = $langueList->get($alerte->langue_id);
        $alerte->langue_nom = is_object($langue) ? ($langue->name ?? 'Non défini') : 'Non défini';

        return [
            'alerte' => $alerte,
        ];
    }

    public function name(): ?string
    {
        return 'Détail de l\'alerte';
    }

    public function description(): ?string
    {
        return 'Fiche complète de l\'alerte sélectionnée';
    }

    public function layout(): iterable
    {
        return [
            Layout::legend('alerte', [
                Sight::make('datealerte', 'Date de l\'alerte'),
                Sight::make('titre', 'Titre'),
                Sight::make('contenu', 'Contenu'),
                Sight::make('lienurl', 'Lien url'),
                Sight::make('alertetype.titre', 'Type de l\'alerte'),
                Sight::make('recompense.titre', 'Recompense'),
                Sight::make('langue_nom', 'Langue'),
                Sight::make('membre.nom_complet', 'Membre'),
                Sight::make('lu', 'Lu')->render(fn($alerte) => $alerte->lu ? '✅ Actif' : '❌ Inactif'),
                Sight::make('etat', 'État')->render(fn($alerte) => $alerte->etat ? '✅ Actif' : '❌ Inactif'),
                Sight::make('created_at', 'Créé le'),
                Sight::make('updated_at', 'Modifié le'),
            ]),
        ];
    }
}
