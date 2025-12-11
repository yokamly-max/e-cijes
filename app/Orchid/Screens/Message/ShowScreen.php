<?php

namespace App\Orchid\Screens\Message;

use App\Models\Message;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Sight;
use Illuminate\Support\HtmlString;

class ShowScreen extends Screen
{
    public function query(Message $message): iterable
    {
        $message->load(['conversation', 'membre']); 

        return [
            'message' => $message,
        ];
    }

    public function name(): ?string
    {
        return 'Détail du message';
    }

    public function description(): ?string
    {
        return 'Fiche complète du message sélectionnée';
    }

    public function layout(): iterable
    {
        return [
            Layout::legend('message', [
                Sight::make('contenu', 'Contenu'),
                Sight::make('conversation.membre.nom_complet', 'Conversation'),
                Sight::make('membre.nom_complet', 'Membre'),
                Sight::make('lu', 'Lu')->render(fn($message) => $message->lu ? '✅ Actif' : '❌ Inactif'),
                Sight::make('etat', 'État')->render(fn($message) => $message->etat ? '✅ Actif' : '❌ Inactif'),
                Sight::make('created_at', 'Créé le'),
                Sight::make('updated_at', 'Modifié le'),
            ]),
        ];
    }
}
