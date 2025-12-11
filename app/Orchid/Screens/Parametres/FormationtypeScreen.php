<?php

namespace App\Orchid\Screens\Parametres;

use Orchid\Screen\Screen;
use Orchid\Screen\Fields\Input;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Actions\ModalToggle;

use App\Models\Formationtype;
use Illuminate\Http\Request;

use Orchid\Screen\TD;
use Orchid\Screen\Actions\Button;

use Illuminate\Support\Facades\Redirect; // si tu veux rediriger après

class FormationtypeScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            'formationtypes' => Formationtype::latest()->paginate(20),
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Liste des types des formations';
    }

    /**
     * Displays a description on the user's screen
     * directly under the heading.
     */
    public function description(): ?string
    {
        return "Paramètres";
    }

    public function asyncFormationtype(Formationtype $formationtype): iterable
    {
        return [
            'formationtype' => $formationtype
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
            ModalToggle::make('Ajouter un type de formation')
                ->modal('formationtypeModal')
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
            Layout::table('formationtypes', [
                TD::make('titre'),

                TD::make('etat', 'État')
                    ->render(function (Formationtype $formationtype) {
                        return Button::make($formationtype->etat ? 'Désactiver' : 'Activer')
                            ->method('toggleEtat', [
                                'formationtype' => $formationtype->id,
                            ])
                            ->icon($formationtype->etat ? 'toggle-on' : 'toggle-off')
                            ->class($formationtype->etat ? 'btn btn-success' : 'btn btn-secondary');
                    }),

                TD::make('Actions')
                    ->alignRight()
                    ->render(function (Formationtype $formationtype) {
                        return ModalToggle::make('Modifier')
                                ->modal('editFormationtypeModal')
                                ->modalTitle('Modifier le type de formation')
                                ->method('update')
                                ->asyncParameters([
                                    'formationtype' => $formationtype->id,
                                ])
                                ->icon('pencil')
                                ->class('btn btn-sm btn-warning')
                            . ' ' . 
                            Button::make('Supprimer')
                                ->confirm('Après la suppression, le type de formation disparaîtra définitivement.')
                                ->method('delete', ['formationtype' => $formationtype->id])
                                ->icon('trash')
                                ->class('btn btn-sm btn-danger');
                    }),

            ]),

            Layout::modal('formationtypeModal', Layout::rows([
                Input::make('formationtype.titre')
                    ->title('Titre')
                    ->placeholder('Entrez le nom du type de formation')
                    ->help('Le nom du type de formation à créer.'),
            ]))
                ->title('Créer un type de formation')
                ->applyButton('Ajouter un type de formation'),


            Layout::modal('editFormationtypeModal', Layout::rows([
                Input::make('formationtype.id')->type('hidden'),

                Input::make('formationtype.titre')
                    ->title('Titre')
                    ->required(),
            ]))
                ->async('asyncFormationtype')
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
        // Validate form data, save formationtype to database, etc.
        $request->validate([
            'formationtype.titre' => 'required|max:255',
        ]);

        $formationtype = new Formationtype();
        $formationtype->titre = $request->input('formationtype.titre');
        $formationtype->save();
    }

    /**
     * @param Formationtype $formationtype
     *
     * @return void
     */
    public function delete(Formationtype $formationtype)
    {
        $formationtype->delete();
    }



    public function toggleEtat(Request $request)
    {
        $formationtype = Formationtype::findOrFail($request->input('formationtype'));
        $formationtype->etat = !$formationtype->etat;
        $formationtype->save();
    }

    public function update(Request $request)
    {
        $request->validate([
            'formationtype.titre' => 'required|max:255',
        ]);

        $formationtype = Formationtype::findOrFail($request->input('formationtype.id'));
        $formationtype->titre = $request->input('formationtype.titre');
        $formationtype->save();
    }

}
