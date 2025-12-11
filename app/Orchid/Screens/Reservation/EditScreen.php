<?php

namespace App\Orchid\Screens\Reservation;

use Orchid\Screen\Screen;

use App\Models\Reservation;
use Illuminate\Http\Request;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\DateTimer;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Fields\Quill;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Actions\Button;
use Orchid\Support\Facades\Alert;

class EditScreen extends Screen
{
    /**
     * @var Reservation
     */
    public $reservation;

    /**
     * Query data.
     *
     * @param Reservation $reservation
     *
     * @return array
     */
    public function query(Reservation $reservation): array
    {
        return [
            'reservation' => $reservation
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return $this->reservation->exists ? 'Modification de la réservation' : 'Créer une réservation';
    }

    /**
     * The description is displayed on the user's screen under the heading
     */
    public function description(): ?string
    {
        return "Toutes les réservations enregistrées";
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Button::make('Créer une réservation')
                ->icon('pencil')
                ->method('createOrUpdate')
                ->canSee(!$this->reservation->exists),

            Button::make('Modifier la réservation')
                ->icon('note')
                ->method('createOrUpdate')
                ->canSee($this->reservation->exists),

            Button::make('Supprimer')
                ->icon('trash')
                ->method('remove')
                ->canSee($this->reservation->exists),
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
            Layout::rows([
                Select::make('reservation.membre_id')
                    ->title('Membre')
                    ->placeholder('Choisir le membre')
                    ->options(
                        \App\Models\Membre::all()
                            ->mapWithKeys(function ($membre) {
                                return [$membre->id => trim("{$membre->prenom} {$membre->nom}")];
                            })
                            ->toArray())
                    ->empty('Choisir', 0),

                DateTimer::make('reservation.datedebut')
                    ->title('Date de début')
                    ->required()
                    ->format('Y-m-d'),

                DateTimer::make('reservation.datefin')
                    ->title('Date de fin')
                    ->required()
                    ->format('Y-m-d'),

                TextArea::make('reservation.observation')
                    ->title('Observation')
                    ->placeholder('Saisir l\'observation'),

                Select::make('reservation.espace_id')
                    ->title('Espace')
                    ->placeholder('Choisir l\'espace')
                    ->fromModel(\App\Models\Espace::class, 'titre')
                    ->empty('Choisir', 0),

                Input::make('reservation.montant')
                    ->title('Montant')
                    ->placeholder('Saisir le montant'),

                Select::make('reservation.reservationstatut_id')
                    ->title('Statut de la reservation')
                    ->placeholder('Choisir le statut')
                    ->fromModel(\App\Models\Reservationstatut::class, 'titre')
                    ->empty('Choisir', 0),


            ])
        ];
    }
    

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function createOrUpdate(Request $request)
{
    $data = $request->get('reservation');

    $this->reservation->fill($data)->save();

    Alert::info('Réservation enregistrée avec succès.');

    return redirect()->route('platform.reservation.list');
}

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function remove()
    {
        $this->reservation->delete();

        Alert::info('Vous avez supprimé la réservation avec succès.');

        return redirect()->route('platform.reservation.list');
    }

}
