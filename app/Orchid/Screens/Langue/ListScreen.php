<?php

namespace App\Orchid\Screens\Langue;

use App\Models\Langue;
use Orchid\Screen\Screen;
use Illuminate\Http\Request;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Alert;
use Orchid\Screen\Actions\Link;

class ListScreen extends Screen
{
    
    public function query(): iterable
    {
        $langueModel = new Langue();
        $langues = $langueModel->all(); // Appelle directement la table Supabase "countries"

        return [
            'langues' => $langues,
        ];
    }

    public function name(): ?string
    {
        return 'Liste des langue';
    }

    public function description(): ?string
    {
        return 'Tous les langue enregistrés';
    }

    /**
     * Barre d'action (boutons en haut)
     */
    /*public function commandBar(): iterable
    {
        return [
            Link::make('Créer un langue')
                ->icon('plus')
                ->route('platform.langue.edit'),
        ];
    }*/

    public function layout(): iterable
    {
        return [
            Layout::view('screens.langue.list'), // ✅ CORRECT : Utilise Layout::view()
        ];
    }

    public function toggleEtat(Request $request)
    {
        $langue = Langue::findOrFail($request->input('id'));
        $langue->etat = !$langue->etat;
        $langue->save();

        Alert::info("État modifié.");
        return redirect()->back();
    }

    public function delete(Request $request)
    {
        $langue = Langue::findOrFail($request->input('langue'));
        $langue->delete();

        Alert::info("Langue supprimé.");
        return redirect()->back();
    }
}
