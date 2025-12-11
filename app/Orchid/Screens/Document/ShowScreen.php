<?php

namespace App\Orchid\Screens\Document;

use App\Models\Document;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Sight;
use Illuminate\Support\HtmlString;

class ShowScreen extends Screen
{
    public function query(Document $document): iterable
    {
        $document->load(['documenttype', 'membre']); 

        return [
            'document' => $document,
        ];
    }

    public function name(): ?string
    {
        return 'Détail du document';
    }

    public function description(): ?string
    {
        return 'Fiche complète du document sélectionnée';
    }

    public function layout(): iterable
    {
        return [
            Layout::legend('document', [
                Sight::make('datedocument', 'Date du document'),
                Sight::make('titre', 'Titre'),
                Sight::make('documenttype.titre', 'Type du document'),
                Sight::make('fichier', 'Fichier')->render(function ($document) {
                    if (!$document->fichier) return '—';
                    return "<a href='" . asset($document->fichier) . "' class='btn btn-outline-primary btn-sm' download style='display: inline;'>📄 Télécharger</a>";
                }),
                Sight::make('membre.nom_complet', 'Membre'),
                Sight::make('spotlight', 'Spotlight')->render(fn($document) => $document->spotlight ? '✅ Actif' : '❌ Inactif'),
                Sight::make('etat', 'État')->render(fn($document) => $document->etat ? '✅ Actif' : '❌ Inactif'),
                Sight::make('created_at', 'Créé le'),
                Sight::make('updated_at', 'Modifié le'),
            ]),
        ];
    }
}
