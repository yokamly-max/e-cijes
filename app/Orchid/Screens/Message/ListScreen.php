<?php

namespace App\Orchid\Screens\Message;

use App\Models\Message;
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
            'messages' => Message::all(),
        ];
    }

    public function name(): ?string
    {
        return 'Liste des messages';
    }

    public function description(): ?string
    {
        return 'Tous les messages enregistrés';
    }

    /**
     * Barre d'action (boutons en haut)
     */
    public function commandBar(): iterable
    {
        return [
            Link::make('Créer un message')
                ->icon('plus')
                ->route('platform.message.edit'),
        ];
    }

    public function layout(): iterable
    {
        return [
            Layout::view('screens.message.list'), 
        ];
    }

    public function toggleEtat(Request $request)
    {
        $message = Message::findOrFail($request->input('id'));
        $message->etat = !$message->etat;
        $message->save();

        Alert::info("État modifié.");
        return redirect()->back();
    }

    public function toggleLu(Request $request)
    {
        $message = Message::findOrFail($request->input('id'));
        $message->lu = !$message->lu;
        $message->save();

        Alert::info("Lu modifié.");
        return redirect()->back();
    }

    public function delete(Request $request)
    {
        $message = Message::findOrFail($request->input('message'));
        $message->delete();

        Alert::info("Message supprimé.");
        return redirect()->back();
    }
}
