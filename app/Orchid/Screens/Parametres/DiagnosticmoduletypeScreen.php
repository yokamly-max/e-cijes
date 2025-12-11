<?php

namespace App\Orchid\Screens\Parametres;

use Orchid\Screen\Screen;
use Orchid\Screen\Fields\Input;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Actions\ModalToggle;

use App\Models\Diagnosticmoduletype;
use Illuminate\Http\Request;

use Orchid\Screen\TD;
use Orchid\Screen\Actions\Button;

use Illuminate\Support\Facades\Redirect; // si tu veux rediriger après

class DiagnosticmoduletypeScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            'diagnosticmoduletypes' => Diagnosticmoduletype::latest()->paginate(20),
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Liste des types du module du diagnostics';
    }

    /**
     * Displays a description on the user's screen
     * directly under the heading.
     */
    public function description(): ?string
    {
        return "Paramètres";
    }

    public function asyncDiagnosticmoduletype(Diagnosticmoduletype $diagnosticmoduletype): iterable
    {
        return [
            'diagnosticmoduletype' => $diagnosticmoduletype
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
            ModalToggle::make('Ajouter un type du module du diagnostic')
                ->modal('diagnosticmoduletypeModal')
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
            Layout::table('diagnosticmoduletypes', [
                TD::make('titre'),

                TD::make('etat', 'État')
                    ->render(function (Diagnosticmoduletype $diagnosticmoduletype) {
                        return Button::make($diagnosticmoduletype->etat ? 'Désactiver' : 'Activer')
                            ->method('toggleEtat', [
                                'diagnosticmoduletype' => $diagnosticmoduletype->id,
                            ])
                            ->icon($diagnosticmoduletype->etat ? 'toggle-on' : 'toggle-off')
                            ->class($diagnosticmoduletype->etat ? 'btn btn-success' : 'btn btn-secondary');
                    }),

                TD::make('Actions')
                    ->alignRight()
                    ->render(function (Diagnosticmoduletype $diagnosticmoduletype) {
                        return ModalToggle::make('Modifier')
                                ->modal('editDiagnosticmoduletypeModal')
                                ->modalTitle('Modifier le type du module du diagnostic')
                                ->method('update')
                                ->asyncParameters([
                                    'diagnosticmoduletype' => $diagnosticmoduletype->id,
                                ])
                                ->icon('pencil')
                                ->class('btn btn-sm btn-warning')
                            . ' ' . 
                            Button::make('Supprimer')
                                ->confirm('Après la suppression, le type du module du diagnostic disparaîtra définitivement.')
                                ->method('delete', ['diagnosticmoduletype' => $diagnosticmoduletype->id])
                                ->icon('trash')
                                ->class('btn btn-sm btn-danger');
                    }),

            ]),

            Layout::modal('diagnosticmoduletypeModal', Layout::rows([
                Input::make('diagnosticmoduletype.titre')
                    ->title('Titre')
                    ->placeholder('Entrez le nom du type')
                    ->help('Le nom du type à créer.'),
            ]))
                ->title('Créer un type')
                ->applyButton('Ajouter un type'),


            Layout::modal('editDiagnosticmoduletypeModal', Layout::rows([
                Input::make('diagnosticmoduletype.id')->type('hidden'),

                Input::make('diagnosticmoduletype.titre')
                    ->title('Titre')
                    ->required(),
            ]))
                ->async('asyncDiagnosticmoduletype')
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
        // Validate form data, save diagnosticmoduletype to database, etc.
        $request->validate([
            'diagnosticmoduletype.titre' => 'required|max:255',
        ]);

        $diagnosticmoduletype = new Diagnosticmoduletype();
        $diagnosticmoduletype->titre = $request->input('diagnosticmoduletype.titre');
        $diagnosticmoduletype->save();
    }

    /**
     * @param Diagnosticmoduletype $diagnosticmoduletype
     *
     * @return void
     */
    public function delete(Diagnosticmoduletype $diagnosticmoduletype)
    {
        $diagnosticmoduletype->delete();
    }



    public function toggleEtat(Request $request)
    {
        $diagnosticmoduletype = Diagnosticmoduletype::findOrFail($request->input('diagnosticmoduletype'));
        $diagnosticmoduletype->etat = !$diagnosticmoduletype->etat;
        $diagnosticmoduletype->save();
    }

    public function update(Request $request)
    {
        $request->validate([
            'diagnosticmoduletype.titre' => 'required|max:255',
        ]);

        $diagnosticmoduletype = Diagnosticmoduletype::findOrFail($request->input('diagnosticmoduletype.id'));
        $diagnosticmoduletype->titre = $request->input('diagnosticmoduletype.titre');
        $diagnosticmoduletype->save();
    }

}
