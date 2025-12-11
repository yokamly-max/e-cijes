<?php

namespace App\Orchid\Screens\Parametres;

use Orchid\Screen\Screen;
use Orchid\Screen\Fields\Input;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Actions\ModalToggle;

use App\Models\Diagnosticquestiontype;
use Illuminate\Http\Request;

use Orchid\Screen\TD;
use Orchid\Screen\Actions\Button;

use Illuminate\Support\Facades\Redirect; // si tu veux rediriger après

class DiagnosticquestiontypeScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            'diagnosticquestiontypes' => Diagnosticquestiontype::latest()->paginate(20),
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Liste des types de la question du diagnostics';
    }

    /**
     * Displays a description on the user's screen
     * directly under the heading.
     */
    public function description(): ?string
    {
        return "Paramètres";
    }

    public function asyncDiagnosticquestiontype(Diagnosticquestiontype $diagnosticquestiontype): iterable
    {
        return [
            'diagnosticquestiontype' => $diagnosticquestiontype
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
            ModalToggle::make('Ajouter un type de la question du diagnostic')
                ->modal('diagnosticquestiontypeModal')
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
            Layout::table('diagnosticquestiontypes', [
                TD::make('titre'),

                TD::make('etat', 'État')
                    ->render(function (Diagnosticquestiontype $diagnosticquestiontype) {
                        return Button::make($diagnosticquestiontype->etat ? 'Désactiver' : 'Activer')
                            ->method('toggleEtat', [
                                'diagnosticquestiontype' => $diagnosticquestiontype->id,
                            ])
                            ->icon($diagnosticquestiontype->etat ? 'toggle-on' : 'toggle-off')
                            ->class($diagnosticquestiontype->etat ? 'btn btn-success' : 'btn btn-secondary');
                    }),

                TD::make('Actions')
                    ->alignRight()
                    ->render(function (Diagnosticquestiontype $diagnosticquestiontype) {
                        return ModalToggle::make('Modifier')
                                ->modal('editDiagnosticquestiontypeModal')
                                ->modalTitle('Modifier le type de la question du diagnostic')
                                ->method('update')
                                ->asyncParameters([
                                    'diagnosticquestiontype' => $diagnosticquestiontype->id,
                                ])
                                ->icon('pencil')
                                ->class('btn btn-sm btn-warning')
                            . ' ' . 
                            Button::make('Supprimer')
                                ->confirm('Après la suppression, le type de la question du diagnostic disparaîtra définitivement.')
                                ->method('delete', ['diagnosticquestiontype' => $diagnosticquestiontype->id])
                                ->icon('trash')
                                ->class('btn btn-sm btn-danger');
                    }),

            ]),

            Layout::modal('diagnosticquestiontypeModal', Layout::rows([
                Input::make('diagnosticquestiontype.titre')
                    ->title('Titre')
                    ->placeholder('Entrez le nom du type')
                    ->help('Le nom du type à créer.'),
            ]))
                ->title('Créer un type')
                ->applyButton('Ajouter un type'),


            Layout::modal('editDiagnosticquestiontypeModal', Layout::rows([
                Input::make('diagnosticquestiontype.id')->type('hidden'),

                Input::make('diagnosticquestiontype.titre')
                    ->title('Titre')
                    ->required(),
            ]))
                ->async('asyncDiagnosticquestiontype')
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
        // Validate form data, save diagnosticquestiontype to database, etc.
        $request->validate([
            'diagnosticquestiontype.titre' => 'required|max:255',
        ]);

        $diagnosticquestiontype = new Diagnosticquestiontype();
        $diagnosticquestiontype->titre = $request->input('diagnosticquestiontype.titre');
        $diagnosticquestiontype->save();
    }

    /**
     * @param Diagnosticquestiontype $diagnosticquestiontype
     *
     * @return void
     */
    public function delete(Diagnosticquestiontype $diagnosticquestiontype)
    {
        $diagnosticquestiontype->delete();
    }



    public function toggleEtat(Request $request)
    {
        $diagnosticquestiontype = Diagnosticquestiontype::findOrFail($request->input('diagnosticquestiontype'));
        $diagnosticquestiontype->etat = !$diagnosticquestiontype->etat;
        $diagnosticquestiontype->save();
    }

    public function update(Request $request)
    {
        $request->validate([
            'diagnosticquestiontype.titre' => 'required|max:255',
        ]);

        $diagnosticquestiontype = Diagnosticquestiontype::findOrFail($request->input('diagnosticquestiontype.id'));
        $diagnosticquestiontype->titre = $request->input('diagnosticquestiontype.titre');
        $diagnosticquestiontype->save();
    }

}
