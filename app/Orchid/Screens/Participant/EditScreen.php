<?php

namespace App\Orchid\Screens\Participant;

use Orchid\Screen\Screen;

use App\Models\Participant;
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
     * @var Participant
     */
    public $participant;

    /**
     * Query data.
     *
     * @param Participant $participant
     *
     * @return array
     */
    public function query(Participant $participant): array
    {
        return [
            'participant' => $participant
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return $this->participant->exists ? 'Modification du participant' : 'Créer un participant';
    }

    /**
     * The description is displayed on the user's screen under the heading
     */
    public function description(): ?string
    {
        return "Tous les participants enregistrés";
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Button::make('Créer un participant')
                ->icon('pencil')
                ->method('createOrUpdate')
                ->canSee(!$this->participant->exists),

            Button::make('Modifier le participant')
                ->icon('note')
                ->method('createOrUpdate')
                ->canSee($this->participant->exists),

            Button::make('Supprimer')
                ->icon('trash')
                ->method('remove')
                ->canSee($this->participant->exists),
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
                DateTimer::make('participant.dateparticipant')
                    ->title('Date de participation')
                    ->format('Y-m-d'),

                Select::make('participant.membre_id')
                    ->title('Membre')
                    ->placeholder('Choisir le membre')
                    ->options(
                        \App\Models\Membre::all()
                            ->mapWithKeys(function ($membre) {
                                return [$membre->id => trim("{$membre->prenom} {$membre->nom}")];
                            })
                            ->toArray())
                    ->empty('Choisir', 0),

                Select::make('participant.formation_id')
                    ->title('Formation')
                    ->placeholder('Choisir la formation')
                    ->fromModel(\App\Models\Formation::class, 'titre')
                    ->empty('Choisir', 0),

                Select::make('participant.participantstatut_id')
                    ->title('Statut de la participation')
                    ->placeholder('Choisir le statut')
                    ->fromModel(\App\Models\Participantstatut::class, 'titre')
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
    $data = $request->get('participant');

    $this->participant->fill($data)->save();

    Alert::info('Participation enregistrée avec succès.');

    return redirect()->route('platform.participant.list');
}

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function remove()
    {
        $this->participant->delete();

        Alert::info('Vous avez supprimé la participation avec succès.');

        return redirect()->route('platform.participant.list');
    }

}
