<?php

namespace App\Orchid\Screens\Parametres;

use Orchid\Screen\Screen;
use Orchid\Screen\Fields\Input;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Actions\ModalToggle;

use App\Models\Bonstatut;
use Illuminate\Http\Request;

use Orchid\Screen\TD;
use Orchid\Screen\Actions\Button;

use Illuminate\Support\Facades\Redirect; // si tu veux rediriger après

class BonstatutScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            'bonstatuts' => Bonstatut::latest()->paginate(20),
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Liste des statuts de bons';
    }

    /**
     * Displays a description on the user's screen
     * directly under the heading.
     */
    public function description(): ?string
    {
        return "Paramètres";
    }

    public function asyncBonstatut(Bonstatut $bonstatut): iterable
    {
        return [
            'bonstatut' => $bonstatut
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
            ModalToggle::make('Ajouter un statut de bon')
                ->modal('bonstatutModal')
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
            Layout::table('bonstatuts', [
                TD::make('titre'),

                TD::make('etat', 'État')
                    ->render(function (Bonstatut $bonstatut) {
                        return Button::make($bonstatut->etat ? 'Désactiver' : 'Activer')
                            ->method('toggleEtat', [
                                'bonstatut' => $bonstatut->id,
                            ])
                            ->icon($bonstatut->etat ? 'toggle-on' : 'toggle-off')
                            ->class($bonstatut->etat ? 'btn btn-success' : 'btn btn-secondary');
                    }),

                TD::make('Actions')
                    ->alignRight()
                    ->render(function (Bonstatut $bonstatut) {
                        return ModalToggle::make('Modifier')
                                ->modal('editBonstatutModal')
                                ->modalTitle('Modifier le statut de bon')
                                ->method('update')
                                ->asyncParameters([
                                    'bonstatut' => $bonstatut->id,
                                ])
                                ->icon('pencil')
                                ->class('btn btn-sm btn-warning')
                            . ' ' . 
                            Button::make('Supprimer')
                                ->confirm('Après la suppression, le statut de bon disparaîtra définitivement.')
                                ->method('delete', ['bonstatut' => $bonstatut->id])
                                ->icon('trash')
                                ->class('btn btn-sm btn-danger');
                    }),

            ]),

            Layout::modal('bonstatutModal', Layout::rows([
                Input::make('bonstatut.titre')
                    ->title('Titre')
                    ->placeholder('Entrez le nom du statut de bon')
                    ->help('Le nom du statut de bon à créer.'),
            ]))
                ->title('Créer un statut de bon')
                ->applyButton('Ajouter un statut de bon'),


            Layout::modal('editBonstatutModal', Layout::rows([
                Input::make('bonstatut.id')->type('hidden'),

                Input::make('bonstatut.titre')
                    ->title('Titre')
                    ->required(),
            ]))
                ->async('asyncBonstatut')
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
        // Validate form data, save bonstatut to database, etc.
        $request->validate([
            'bonstatut.titre' => 'required|max:255',
        ]);

        $bonstatut = new Bonstatut();
        $bonstatut->titre = $request->input('bonstatut.titre');
        $bonstatut->save();
    }

    /**
     * @param Bonstatut $bonstatut
     *
     * @return void
     */
    public function delete(Bonstatut $bonstatut)
    {
        $bonstatut->delete();
    }



    public function toggleEtat(Request $request)
    {
        $bonstatut = Bonstatut::findOrFail($request->input('bonstatut'));
        $bonstatut->etat = !$bonstatut->etat;
        $bonstatut->save();
    }

    public function update(Request $request)
    {
        $request->validate([
            'bonstatut.titre' => 'required|max:255',
        ]);

        $bonstatut = Bonstatut::findOrFail($request->input('bonstatut.id'));
        $bonstatut->titre = $request->input('bonstatut.titre');
        $bonstatut->save();
    }

}
