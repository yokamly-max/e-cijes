<?php

namespace App\Orchid\Screens\Conversation;

use App\Models\Conversation;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Sight;
use Illuminate\Support\HtmlString;

class ShowScreen extends Screen
{
    public function query(Conversation $conversation): iterable
    {
        $conversation->load(['membre1', 'membre2']); 

        return [
            'conversation' => $conversation,
        ];
    }

    public function name(): ?string
    {
        return 'Détail de la conversation';
    }

    public function description(): ?string
    {
        return 'Fiche complète de la conversation sélectionnée';
    }

    public function layout(): iterable
    {
        return [
            Layout::legend('conversation', [
                Sight::make('membre1.nom', 'Membre'),
                Sight::make('membre2.nom', 'Membre'),
                Sight::make('spotlight', 'Spotlight')->render(fn($conversation) => $conversation->spotlight ? '✅ Actif' : '❌ Inactif'),
                Sight::make('etat', 'État')->render(fn($conversation) => $conversation->etat ? '✅ Actif' : '❌ Inactif'),
                Sight::make('created_at', 'Créé le'),
                Sight::make('updated_at', 'Modifié le'),
            ]),
        ];
    }
}
