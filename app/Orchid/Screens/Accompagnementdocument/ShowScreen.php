<?php

namespace App\Orchid\Screens\Accompagnementdocument;

use App\Models\Accompagnementdocument;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Sight;
use Illuminate\Support\HtmlString;

class ShowScreen extends Screen
{
    public function query(Accompagnementdocument $accompagnementdocument): iterable
    {
        $accompagnementdocument->load(['document', 'accompagnement']); 

        return [
            'accompagnementdocument' => $accompagnementdocument,
        ];
    }

    public function name(): ?string
    {
        return 'Détail du document';
    }

    public function description(): ?string
    {
        return 'Fiche complète du document d\'accompagnement sélectionnée';
    }

    public function layout(): iterable
    {
        return [
            Layout::legend('accompagnementdocument', [
                Sight::make('accompagnement.nom_complet', 'Accompagnement'),
                Sight::make('document.titre', 'Document'),
                Sight::make('spotlight', 'Spotlight')->render(fn($accompagnementdocument) => $accompagnementdocument->spotlight ? '✅ Actif' : '❌ Inactif'),
                Sight::make('etat', 'État')->render(fn($accompagnementdocument) => $accompagnementdocument->etat ? '✅ Actif' : '❌ Inactif'),
                Sight::make('created_at', 'Créé le'),
                Sight::make('updated_at', 'Modifié le'),
            ]),
        ];
    }
}
