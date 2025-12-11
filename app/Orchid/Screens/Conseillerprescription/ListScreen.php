<?php

namespace App\Orchid\Screens\Conseillerprescription;

use App\Models\Conseillerprescription;
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
            'conseillerprescriptions' => Conseillerprescription::all(),
        ];
    }

    public function name(): ?string
    {
        return 'Liste des prescriptions des conseillers';
    }

    public function description(): ?string
    {
        return 'Toutes les prescriptions des conseillers enregistrées';
    }

    /**
     * Barre d'action (boutons en haut)
     */
    public function commandBar(): iterable
    {
        return [
            Link::make('Créer une prescription du conseiller')
                ->icon('plus')
                ->route('platform.conseillerprescription.edit'),
        ];
    }

    public function layout(): iterable
    {
        return [
            Layout::view('screens.conseillerprescription.list'), 
        ];
    }

    public function toggleEtat(Request $request)
    {
        $conseillerprescription = Conseillerprescription::findOrFail($request->input('id'));
        $conseillerprescription->etat = !$conseillerprescription->etat;
        $conseillerprescription->save();

        Alert::info("État modifié.");
        return redirect()->back();
    }

    public function toggleSpotlight(Request $request)
    {
        $conseillerprescription = Conseillerprescription::findOrFail($request->input('id'));
        $conseillerprescription->spotlight = !$conseillerprescription->spotlight;
        $conseillerprescription->save();

        Alert::info("Spotlight modifié.");
        return redirect()->back();
    }

    public function delete(Request $request)
    {
        $conseillerprescription = Conseillerprescription::findOrFail($request->input('conseillerprescription'));
        $conseillerprescription->delete();

        Alert::info("Prescription du conseiller supprimée.");
        return redirect()->back();
    }
}
