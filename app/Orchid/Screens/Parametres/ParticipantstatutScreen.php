<?php

namespace App\Orchid\Screens\Parametres;

use Orchid\Screen\Screen;
use Orchid\Screen\Fields\Input;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Actions\ModalToggle;

use App\Models\Participantstatut;
use Illuminate\Http\Request;

use Orchid\Screen\TD;
use Orchid\Screen\Actions\Button;

use Illuminate\Support\Facades\Redirect; // si tu veux rediriger après

class ParticipantstatutScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            'participantstatuts' => Participantstatut::latest()->paginate(20),
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Liste des statuts des participants';
    }

    /**
     * Displays a description on the user's screen
     * directly under the heading.
     */
    public function description(): ?string
    {
        return "Paramètres";
    }

    public function asyncParticipantstatut(Participantstatut $participantstatut): iterable
    {
        return [
            'participantstatut' => $participantstatut
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
            ModalToggle::make('Ajouter un statut du participant')
                ->modal('participantstatutModal')
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
            Layout::table('participantstatuts', [
                TD::make('titre'),

                TD::make('etat', 'État')
                    ->render(function (Participantstatut $participantstatut) {
                        return Button::make($participantstatut->etat ? 'Désactiver' : 'Activer')
                            ->method('toggleEtat', [
                                'participantstatut' => $participantstatut->id,
                            ])
                            ->icon($participantstatut->etat ? 'toggle-on' : 'toggle-off')
                            ->class($participantstatut->etat ? 'btn btn-success' : 'btn btn-secondary');
                    }),

                TD::make('Actions')
                    ->alignRight()
                    ->render(function (Participantstatut $participantstatut) {
                        return ModalToggle::make('Modifier')
                                ->modal('editParticipantstatutModal')
                                ->modalTitle('Modifier le statut du participant')
                                ->method('update')
                                ->asyncParameters([
                                    'participantstatut' => $participantstatut->id,
                                ])
                                ->icon('pencil')
                                ->class('btn btn-sm btn-warning')
                            . ' ' . 
                            Button::make('Supprimer')
                                ->confirm('Après la suppression, le statut du participant disparaîtra définitivement.')
                                ->method('delete', ['participantstatut' => $participantstatut->id])
                                ->icon('trash')
                                ->class('btn btn-sm btn-danger');
                    }),

            ]),

            Layout::modal('participantstatutModal', Layout::rows([
                Input::make('participantstatut.titre')
                    ->title('Titre')
                    ->placeholder('Entrez le nom du statut du participant')
                    ->help('Le nom du statut du participant à créer.'),
            ]))
                ->title('Créer un statut du participant')
                ->applyButton('Ajouter un statut du participant'),


            Layout::modal('editParticipantstatutModal', Layout::rows([
                Input::make('participantstatut.id')->type('hidden'),

                Input::make('participantstatut.titre')
                    ->title('Titre')
                    ->required(),
            ]))
                ->async('asyncParticipantstatut')
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
        // Validate form data, save participantstatut to database, etc.
        $request->validate([
            'participantstatut.titre' => 'required|max:255',
        ]);

        $participantstatut = new Participantstatut();
        $participantstatut->titre = $request->input('participantstatut.titre');
        $participantstatut->save();
    }

    /**
     * @param Participantstatut $participantstatut
     *
     * @return void
     */
    public function delete(Participantstatut $participantstatut)
    {
        $participantstatut->delete();
    }



    public function toggleEtat(Request $request)
    {
        $participantstatut = Participantstatut::findOrFail($request->input('participantstatut'));
        $participantstatut->etat = !$participantstatut->etat;
        $participantstatut->save();
    }

    public function update(Request $request)
    {
        $request->validate([
            'participantstatut.titre' => 'required|max:255',
        ]);

        $participantstatut = Participantstatut::findOrFail($request->input('participantstatut.id'));
        $participantstatut->titre = $request->input('participantstatut.titre');
        $participantstatut->save();
    }

}
