<?php

namespace App\Orchid\Screens\Piece;

use App\Models\Piece;
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
            'pieces' => Piece::all(),
        ];
    }

    public function name(): ?string
    {
        return 'Liste des pièces';
    }

    public function description(): ?string
    {
        return 'Toutes les pièces enregistrées';
    }

    /**
     * Barre d'action (boutons en haut)
     */
    public function commandBar(): iterable
    {
        return [
            Link::make('Créer une pièce')
                ->icon('plus')
                ->route('platform.piece.edit'),
        ];
    }

    public function layout(): iterable
    {
        return [
            Layout::view('screens.piece.list'), 
        ];
    }

    public function toggleEtat(Request $request)
    {
        $piece = Piece::findOrFail($request->input('id'));
        $piece->etat = !$piece->etat;
        $piece->save();

        Alert::info("État modifié.");
        return redirect()->back();
    }

    public function toggleSpotlight(Request $request)
    {
        $piece = Piece::findOrFail($request->input('id'));
        $piece->spotlight = !$piece->spotlight;
        $piece->save();

        Alert::info("Spotlight modifié.");
        return redirect()->back();
    }

    public function delete(Request $request)
    {
        $piece = Piece::findOrFail($request->input('piece'));
        $piece->delete();

        Alert::info("Pièce supprimé.");
        return redirect()->back();
    }
}
