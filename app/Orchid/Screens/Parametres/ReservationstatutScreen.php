<?php

namespace App\Orchid\Screens\Parametres;

use Orchid\Screen\Screen;
use Orchid\Screen\Fields\Input;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Actions\ModalToggle;

use App\Models\Reservationstatut;
use Illuminate\Http\Request;

use Orchid\Screen\TD;
use Orchid\Screen\Actions\Button;

use Illuminate\Support\Facades\Redirect; // si tu veux rediriger après

class ReservationstatutScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            'reservationstatuts' => Reservationstatut::latest()->paginate(20),
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Liste des statuts de la réservation';
    }

    /**
     * Displays a description on the user's screen
     * directly under the heading.
     */
    public function description(): ?string
    {
        return "Paramètres";
    }

    public function asyncReservationstatut(Reservationstatut $reservationstatut): iterable
    {
        return [
            'reservationstatut' => $reservationstatut
        ];
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            ModalToggle::make('Ajouter un statut de la réservation')
                ->modal('reservationstatutModal')
                ->method('create')
                ->icon('plus'),
        ];
    }

    /**
     * The screen's layout elements.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): iterable
    {
        return [
            Layout::table('reservationstatuts', [
                TD::make('titre'),

                TD::make('etat', 'État')
                    ->render(function (Reservationstatut $reservationstatut) {
                        return Button::make($reservationstatut->etat ? 'Désactiver' : 'Activer')
                            ->method('toggleEtat', [
                                'reservationstatut' => $reservationstatut->id,
                            ])
                            ->icon($reservationstatut->etat ? 'toggle-on' : 'toggle-off')
                            ->class($reservationstatut->etat ? 'btn btn-success' : 'btn btn-secondary');
                    }),

                TD::make('Actions')
                    ->alignRight()
                    ->render(function (Reservationstatut $reservationstatut) {
                        return ModalToggle::make('Modifier')
                                ->modal('editReservationstatutModal')
                                ->modalTitle('Modifier le statut de la réservation')
                                ->method('update')
                                ->asyncParameters([
                                    'reservationstatut' => $reservationstatut->id,
                                ])
                                ->icon('pencil')
                                ->class('btn btn-sm btn-warning')
                            . ' ' . 
                            Button::make('Supprimer')
                                ->confirm('Après la suppression, le statut de la réservation disparaîtra définitivement.')
                                ->method('delete', ['reservationstatut' => $reservationstatut->id])
                                ->icon('trash')
                                ->class('btn btn-sm btn-danger');
                    }),

            ]),

            Layout::modal('reservationstatutModal', Layout::rows([
                Input::make('reservationstatut.titre')
                    ->title('Titre')
                    ->placeholder('Entrez le nom du statut de la réservation')
                    ->help('Le nom du statut de la réservation à créer.'),
            ]))
                ->title('Créer un statut de la réservation')
                ->applyButton('Ajouter un statut de la réservation'),


            Layout::modal('editReservationstatutModal', Layout::rows([
                Input::make('reservationstatut.id')->type('hidden'),

                Input::make('reservationstatut.titre')
                    ->title('Titre')
                    ->required(),
            ]))
                ->async('asyncReservationstatut')
                ->applyButton('Mettre à jour'),

        ];
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return void
     */
    public function create(Request $request)
    {
        // Validate form data, save reservationstatut to database, etc.
        $request->validate([
            'reservationstatut.titre' => 'required|max:255',
        ]);

        $reservationstatut = new Reservationstatut();
        $reservationstatut->titre = $request->input('reservationstatut.titre');
        $reservationstatut->save();
    }

    /**
     * @param Reservationstatut $reservationstatut
     *
     * @return void
     */
    public function delete(Reservationstatut $reservationstatut)
    {
        $reservationstatut->delete();
    }



    public function toggleEtat(Request $request)
    {
        $reservationstatut = Reservationstatut::findOrFail($request->input('reservationstatut'));
        $reservationstatut->etat = !$reservationstatut->etat;
        $reservationstatut->save();
    }

    public function update(Request $request)
    {
        $request->validate([
            'reservationstatut.titre' => 'required|max:255',
        ]);

        $reservationstatut = Reservationstatut::findOrFail($request->input('reservationstatut.id'));
        $reservationstatut->titre = $request->input('reservationstatut.titre');
        $reservationstatut->save();
    }

}
