<?php

namespace App\Orchid\Screens\Prefecture;

use App\Models\Prefecture;
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
            'prefectures' => Prefecture::with('region')->get(),
        ];
    }

    public function name(): ?string
    {
        return 'Liste des préfectures';
    }

    public function description(): ?string
    {
        return 'Toutes les préfectures enregistrées';
    }

    /**
     * Barre d'action (boutons en haut)
     */
    public function commandBar(): iterable
    {
        return [
            Link::make('Créer une préfecture')
                ->icon('plus')
                ->route('platform.prefecture.edit'),
        ];
    }

    public function layout(): iterable
    {
        return [
            Layout::view('screens.prefecture.list'), // ✅ CORRECT : Utilise Layout::view()
        ];
    }

    public function toggleEtat(Request $request)
    {
        $prefecture = Prefecture::findOrFail($request->input('id'));
        $prefecture->etat = !$prefecture->etat;
        $prefecture->save();

        Alert::info("État modifié.");
        return redirect()->back();
    }

    public function delete(Request $request)
    {
        $prefecture = Prefecture::findOrFail($request->input('prefecture'));
        $prefecture->delete();

        Alert::info("Préfecture supprimée.");
        return redirect()->back();
    }
}
