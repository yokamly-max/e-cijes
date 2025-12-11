<?php

namespace App\Orchid\Screens\Reservation;

use App\Models\Reservation;
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
            'reservations' => Reservation::all(),
        ];
    }

    public function name(): ?string
    {
        return 'Liste des réservations';
    }

    public function description(): ?string
    {
        return 'Toutes les réservations enregistrées';
    }

    /**
     * Barre d'action (boutons en haut)
     */
    public function commandBar(): iterable
    {
        return [
            Link::make('Créer une réservation')
                ->icon('plus')
                ->route('platform.reservation.edit'),
        ];
    }

    public function layout(): iterable
    {
        return [
            Layout::view('screens.reservation.list'), 
        ];
    }

    public function toggleEtat(Request $request)
    {
        $reservation = Reservation::findOrFail($request->input('id'));
        $reservation->etat = !$reservation->etat;
        $reservation->save();

        Alert::info("État modifié.");
        return redirect()->back();
    }

    public function toggleSpotlight(Request $request)
    {
        $reservation = Reservation::findOrFail($request->input('id'));
        $reservation->spotlight = !$reservation->spotlight;
        $reservation->save();

        Alert::info("Spotlight modifié.");
        return redirect()->back();
    }

    public function delete(Request $request)
    {
        $reservation = Reservation::findOrFail($request->input('reservation'));
        $reservation->delete();

        Alert::info("Réservation supprimée.");
        return redirect()->back();
    }
}
