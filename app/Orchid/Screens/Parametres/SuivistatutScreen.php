<?php

namespace App\Orchid\Screens\Parametres;

use Orchid\Screen\Screen;
use Orchid\Screen\Fields\Input;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Actions\ModalToggle;

use App\Models\Suivistatut;
use Illuminate\Http\Request;

use Orchid\Screen\TD;
use Orchid\Screen\Actions\Button;

use Illuminate\Support\Facades\Redirect; // si tu veux rediriger après

class SuivistatutScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            'suivistatuts' => Suivistatut::latest()->paginate(20),
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Liste des statuts de suivis';
    }

    /**
     * Displays a description on the user's screen
     * directly under the heading.
     */
    public function description(): ?string
    {
        return "Paramètres";
    }

    public function asyncSuivistatut(Suivistatut $suivistatut): iterable
    {
        return [
            'suivistatut' => $suivistatut
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
            ModalToggle::make('Ajouter un statut de suivi')
                ->modal('suivistatutModal')
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
            Layout::table('suivistatuts', [
                TD::make('titre'),

                TD::make('etat', 'État')
                    ->render(function (Suivistatut $suivistatut) {
                        return Button::make($suivistatut->etat ? 'Désactiver' : 'Activer')
                            ->method('toggleEtat', [
                                'suivistatut' => $suivistatut->id,
                            ])
                            ->icon($suivistatut->etat ? 'toggle-on' : 'toggle-off')
                            ->class($suivistatut->etat ? 'btn btn-success' : 'btn btn-secondary');
                    }),

                TD::make('Actions')
                    ->alignRight()
                    ->render(function (Suivistatut $suivistatut) {
                        return ModalToggle::make('Modifier')
                                ->modal('editSuivistatutModal')
                                ->modalTitle('Modifier le statut de suivi')
                                ->method('update')
                                ->asyncParameters([
                                    'suivistatut' => $suivistatut->id,
                                ])
                                ->icon('pencil')
                                ->class('btn btn-sm btn-warning')
                            . ' ' . 
                            Button::make('Supprimer')
                                ->confirm('Après la suppression, le statut de suivi disparaîtra définitivement.')
                                ->method('delete', ['suivistatut' => $suivistatut->id])
                                ->icon('trash')
                                ->class('btn btn-sm btn-danger');
                    }),

            ]),

            Layout::modal('suivistatutModal', Layout::rows([
                Input::make('suivistatut.titre')
                    ->title('Titre')
                    ->placeholder('Entrez le nom du statut de suivi')
                    ->help('Le nom du statut de suivi à créer.'),
            ]))
                ->title('Créer un statut de suivi')
                ->applyButton('Ajouter un statut de suivi'),


            Layout::modal('editSuivistatutModal', Layout::rows([
                Input::make('suivistatut.id')->type('hidden'),

                Input::make('suivistatut.titre')
                    ->title('Titre')
                    ->required(),
            ]))
                ->async('asyncSuivistatut')
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
        // Validate form data, save suivistatut to database, etc.
        $request->validate([
            'suivistatut.titre' => 'required|max:255',
        ]);

        $suivistatut = new Suivistatut();
        $suivistatut->titre = $request->input('suivistatut.titre');
        $suivistatut->save();
    }

    /**
     * @param Suivistatut $suivistatut
     *
     * @return void
     */
    public function delete(Suivistatut $suivistatut)
    {
        $suivistatut->delete();
    }



    public function toggleEtat(Request $request)
    {
        $suivistatut = Suivistatut::findOrFail($request->input('suivistatut'));
        $suivistatut->etat = !$suivistatut->etat;
        $suivistatut->save();
    }

    public function update(Request $request)
    {
        $request->validate([
            'suivistatut.titre' => 'required|max:255',
        ]);

        $suivistatut = Suivistatut::findOrFail($request->input('suivistatut.id'));
        $suivistatut->titre = $request->input('suivistatut.titre');
        $suivistatut->save();
    }

}
