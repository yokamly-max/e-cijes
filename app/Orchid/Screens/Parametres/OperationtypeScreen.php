<?php

namespace App\Orchid\Screens\Parametres;

use Orchid\Screen\Screen;
use Orchid\Screen\Fields\Input;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Actions\ModalToggle;

use App\Models\Operationtype;
use Illuminate\Http\Request;

use Orchid\Screen\TD;
use Orchid\Screen\Actions\Button;

use Illuminate\Support\Facades\Redirect; // si tu veux rediriger après

class OperationtypeScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            'operationtypes' => Operationtype::latest()->paginate(20),
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Liste des types de operations';
    }

    /**
     * Displays a description on the user's screen
     * directly under the heading.
     */
    public function description(): ?string
    {
        return "Paramètres";
    }

    public function asyncOperationtype(Operationtype $operationtype): iterable
    {
        return [
            'operationtype' => $operationtype
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
            ModalToggle::make('Ajouter un type de operation')
                ->modal('operationtypeModal')
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
            Layout::table('operationtypes', [
                TD::make('titre'),

                TD::make('etat', 'État')
                    ->render(function (Operationtype $operationtype) {
                        return Button::make($operationtype->etat ? 'Désactiver' : 'Activer')
                            ->method('toggleEtat', [
                                'operationtype' => $operationtype->id,
                            ])
                            ->icon($operationtype->etat ? 'toggle-on' : 'toggle-off')
                            ->class($operationtype->etat ? 'btn btn-success' : 'btn btn-secondary');
                    }),

                TD::make('Actions')
                    ->alignRight()
                    ->render(function (Operationtype $operationtype) {
                        return ModalToggle::make('Modifier')
                                ->modal('editOperationtypeModal')
                                ->modalTitle('Modifier le type de operation')
                                ->method('update')
                                ->asyncParameters([
                                    'operationtype' => $operationtype->id,
                                ])
                                ->icon('pencil')
                                ->class('btn btn-sm btn-warning')
                            . ' ' . 
                            Button::make('Supprimer')
                                ->confirm('Après la suppression, le type de operation disparaîtra définitivement.')
                                ->method('delete', ['operationtype' => $operationtype->id])
                                ->icon('trash')
                                ->class('btn btn-sm btn-danger');
                    }),

            ]),

            Layout::modal('operationtypeModal', Layout::rows([
                Input::make('operationtype.titre')
                    ->title('Titre')
                    ->placeholder('Entrez le nom du type de operation')
                    ->help('Le nom du type de operation à créer.'),
            ]))
                ->title('Créer un type de operation')
                ->applyButton('Ajouter un type de operation'),


            Layout::modal('editOperationtypeModal', Layout::rows([
                Input::make('operationtype.id')->type('hidden'),

                Input::make('operationtype.titre')
                    ->title('Titre')
                    ->required(),
            ]))
                ->async('asyncOperationtype')
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
        // Validate form data, save operationtype to database, etc.
        $request->validate([
            'operationtype.titre' => 'required|max:255',
        ]);

        $operationtype = new Operationtype();
        $operationtype->titre = $request->input('operationtype.titre');
        $operationtype->save();
    }

    /**
     * @param Operationtype $operationtype
     *
     * @return void
     */
    public function delete(Operationtype $operationtype)
    {
        $operationtype->delete();
    }



    public function toggleEtat(Request $request)
    {
        $operationtype = Operationtype::findOrFail($request->input('operationtype'));
        $operationtype->etat = !$operationtype->etat;
        $operationtype->save();
    }

    public function update(Request $request)
    {
        $request->validate([
            'operationtype.titre' => 'required|max:255',
        ]);

        $operationtype = Operationtype::findOrFail($request->input('operationtype.id'));
        $operationtype->titre = $request->input('operationtype.titre');
        $operationtype->save();
    }

}
