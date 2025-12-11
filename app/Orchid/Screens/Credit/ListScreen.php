<?php

namespace App\Orchid\Screens\Credit;

use App\Models\Credit;
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
        // 1. Charger les régions locales
        $credits = Credit::all();

        // 2. Récupérer les pays depuis Supabase
        $paysModel = new Pays();
        $payss = collect($paysModel->all()); // collection d'objets Supabase

        // 3. Associer chaque région avec son pays
        $credits->transform(function ($credit) use ($payss) {
            $credit->pays = $payss->firstWhere('id', $credit->pays_id);
            return $credit;
        });

        return [
            'credits' => $credits,
        ];
    }

    public function name(): ?string
    {
        return 'Liste des crédits';
    }

    public function description(): ?string
    {
        return 'Tous les crédits enregistrés';
    }

    /**
     * Barre d'action (boutons en haut)
     */
    public function commandBar(): iterable
    {
        return [
            Link::make('Créer un crédit')
                ->icon('plus')
                ->route('platform.credit.edit'),
        ];
    }

    public function layout(): iterable
    {
        return [
            Layout::view('screens.credit.list'), 
        ];
    }

    public function toggleEtat(Request $request)
    {
        $credit = Credit::findOrFail($request->input('id'));
        $credit->etat = !$credit->etat;
        $credit->save();

        Alert::info("État modifié.");
        return redirect()->back();
    }

    public function toggleSpotlight(Request $request)
    {
        $credit = Credit::findOrFail($request->input('id'));
        $credit->spotlight = !$credit->spotlight;
        $credit->save();

        Alert::info("Spotlight modifié.");
        return redirect()->back();
    }

    public function delete(Request $request)
    {
        $credit = Credit::findOrFail($request->input('credit'));
        $credit->delete();

        Alert::info("Crédit supprimé.");
        return redirect()->back();
    }
}
