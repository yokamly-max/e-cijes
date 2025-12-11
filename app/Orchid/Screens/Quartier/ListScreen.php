<?php

namespace App\Orchid\Screens\Quartier;

use App\Models\Quartier;
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
            'quartiers' => Quartier::with('commune')->get(),
        ];
    }

    public function name(): ?string
    {
        return 'Liste des quartiers';
    }

    public function description(): ?string
    {
        return 'Toutes les quartiers enregistrés';
    }

    /**
     * Barre d'action (boutons en haut)
     */
    public function commandBar(): iterable
    {
        return [
            Link::make('Créer un quartier')
                ->icon('plus')
                ->route('platform.quartier.edit'),
        ];
    }

    public function layout(): iterable
    {
        return [
            Layout::view('screens.quartier.list'), // ✅ CORRECT : Utilise Layout::view()
        ];
    }

    public function toggleEtat(Request $request)
    {
        $quartier = Quartier::findOrFail($request->input('id'));
        $quartier->etat = !$quartier->etat;
        $quartier->save();

        Alert::info("État modifié.");
        return redirect()->back();
    }

    public function delete(Request $request)
    {
        $quartier = Quartier::findOrFail($request->input('quartier'));
        $quartier->delete();

        Alert::info("Quartier supprimé.");
        return redirect()->back();
    }
}
