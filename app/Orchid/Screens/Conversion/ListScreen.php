<?php

namespace App\Orchid\Screens\Conversion;

use App\Models\Conversion;
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
            'conversions' => Conversion::all(),
        ];
    }

    public function name(): ?string
    {
        return 'Liste des conversions';
    }

    public function description(): ?string
    {
        return 'Toutes les conversions enregistrées';
    }

    /**
     * Barre d'action (boutons en haut)
     */
    public function commandBar(): iterable
    {
        return [
            Link::make('Créer une conversion')
                ->icon('plus')
                ->route('platform.conversion.edit'),
        ];
    }

    public function layout(): iterable
    {
        return [
            Layout::view('screens.conversion.list'), 
        ];
    }

    public function toggleEtat(Request $request)
    {
        $conversion = Conversion::findOrFail($request->input('id'));
        $conversion->etat = !$conversion->etat;
        $conversion->save();

        Alert::info("État modifié.");
        return redirect()->back();
    }

    public function toggleSpotlight(Request $request)
    {
        $conversion = Conversion::findOrFail($request->input('id'));
        $conversion->spotlight = !$conversion->spotlight;
        $conversion->save();

        Alert::info("Spotlight modifié.");
        return redirect()->back();
    }

    public function delete(Request $request)
    {
        $conversion = Conversion::findOrFail($request->input('conversion'));
        $conversion->delete();

        Alert::info("Conversion supprimée.");
        return redirect()->back();
    }
}
