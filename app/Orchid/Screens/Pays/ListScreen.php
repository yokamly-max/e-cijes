<?php

namespace App\Orchid\Screens\Pays;

use App\Models\Pays;
use Orchid\Screen\Screen;
use Illuminate\Http\Request;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Alert;
use Orchid\Screen\Actions\Link;

class ListScreen extends Screen
{
    
    public function query(): iterable
    {
        $paysModel = new Pays();
        $payss = $paysModel->all(); // Appelle directement la table Supabase "countries"

        return [
            'payss' => $payss,
        ];
    }

    public function name(): ?string
    {
        return 'Liste des pays';
    }

    public function description(): ?string
    {
        return 'Tous les pays enregistrés';
    }

    /**
     * Barre d'action (boutons en haut)
     */
    /*public function commandBar(): iterable
    {
        return [
            Link::make('Créer un pays')
                ->icon('plus')
                ->route('platform.pays.edit'),
        ];
    }*/

    public function layout(): iterable
    {
        return [
            Layout::view('screens.pays.list'), // ✅ CORRECT : Utilise Layout::view()
        ];
    }

    public function toggleEtat(Request $request)
    {
        $pays = Pays::findOrFail($request->input('id'));
        $pays->etat = !$pays->etat;
        $pays->save();

        Alert::info("État modifié.");
        return redirect()->back();
    }

    public function delete(Request $request)
    {
        $pays = Pays::findOrFail($request->input('pays'));
        $pays->delete();

        Alert::info("Pays supprimé.");
        return redirect()->back();
    }
}
