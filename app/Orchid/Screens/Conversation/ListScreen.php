<?php

namespace App\Orchid\Screens\Conversation;

use App\Models\Conversation;
use Orchid\Screen\Screen;
use Illuminate\Http\Request;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Alert;
use Orchid\Screen\Actions\Link;

class ListScreen extends Screen
{
    public function query(): iterable
    {
        return [
            'conversations' => Conversation::all(),
        ];
    }

    public function name(): ?string
    {
        return 'Liste des conversations';
    }

    public function description(): ?string
    {
        return 'Toutes les conversations enregistrées';
    }

    /**
     * Barre d'action (boutons en haut)
     */
    public function commandBar(): iterable
    {
        return [
            Link::make('Créer une conversation')
                ->icon('plus')
                ->route('platform.conversation.edit'),
        ];
    }

    public function layout(): iterable
    {
        return [
            Layout::view('screens.conversation.list'), 
        ];
    }

    public function toggleEtat(Request $request)
    {
        $conversation = Conversation::findOrFail($request->input('id'));
        $conversation->etat = !$conversation->etat;
        $conversation->save();

        Alert::info("État modifié.");
        return redirect()->back();
    }

    public function toggleSpotlight(Request $request)
    {
        $conversation = Conversation::findOrFail($request->input('id'));
        $conversation->spotlight = !$conversation->spotlight;
        $conversation->save();

        Alert::info("Spotlight modifié.");
        return redirect()->back();
    }

    public function delete(Request $request)
    {
        $conversation = Conversation::findOrFail($request->input('conversation'));
        $conversation->delete();

        Alert::info("Conversation supprimée.");
        return redirect()->back();
    }
}
