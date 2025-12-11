<?php

namespace App\Orchid\Screens\Contact;

use App\Models\Contact;
use App\Models\Pays;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Sight;
use Illuminate\Support\HtmlString;

class ShowScreen extends Screen
{
    public function query(Contact $contact): iterable
    {
        $contact->load(['contacttype']);

        // Charger tous les pays depuis Supabase
        $paysModel = new Pays();
        $paysList = collect($paysModel->all())->keyBy('id');

        // Trouver le pays correspondant
        $pays = $paysList[$contact->pays_id] ?? null;

        // Ajouter une propriété pour l'affichage
        $contact->pays_nom = is_array($pays)
            ? ($pays['name'] ?? 'Non défini')
            : ($pays->name ?? 'Non défini');

        return [
            'contact' => $contact,
        ];
    }

    public function name(): ?string
    {
        return 'Détail du contact';
    }

    public function description(): ?string
    {
        return 'Fiche complète du contact sélectionnée';
    }

    public function layout(): iterable
    {
        return [
            Layout::legend('contact', [
                Sight::make('nom', 'Nom et prénom(s)'),
                Sight::make('email', 'Email'),
                Sight::make('message', 'Message'),
                Sight::make('contacttype.titre', 'Type'),
                Sight::make('pays_nom', 'Pays'),
                Sight::make('etat', 'État')->render(fn($contact) => $contact->etat ? '✅ Actif' : '❌ Inactif'),
                Sight::make('created_at', 'Créé le'),
                Sight::make('updated_at', 'Modifié le'),
            ]),
        ];
    }
}
