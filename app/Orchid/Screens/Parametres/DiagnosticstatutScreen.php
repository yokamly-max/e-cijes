<?php

namespace App\Orchid\Screens\Parametres;

use Orchid\Screen\Screen;
use Orchid\Screen\Fields\Input;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Actions\ModalToggle;

use App\Models\Diagnosticstatut;
use Illuminate\Http\Request;

use Orchid\Screen\TD;
use Orchid\Screen\Actions\Button;

use Illuminate\Support\Facades\Redirect; // si tu veux rediriger après

class DiagnosticstatutScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            'diagnosticstatuts' => Diagnosticstatut::latest()->paginate(20),
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Liste des statuts des diagnostics';
    }

    /**
     * Displays a description on the user's screen
     * directly under the heading.
     */
    public function description(): ?string
    {
        return "Paramètres";
    }

    public function asyncDiagnosticstatut(Diagnosticstatut $diagnosticstatut): iterable
    {
        return [
            'diagnosticstatut' => $diagnosticstatut
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
            ModalToggle::make('Ajouter un statut du diagnostic')
                ->modal('diagnosticstatutModal')
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
            Layout::table('diagnosticstatuts', [
                TD::make('titre'),

                TD::make('etat', 'État')
                    ->render(function (Diagnosticstatut $diagnosticstatut) {
                        return Button::make($diagnosticstatut->etat ? 'Désactiver' : 'Activer')
                            ->method('toggleEtat', [
                                'diagnosticstatut' => $diagnosticstatut->id,
                            ])
                            ->icon($diagnosticstatut->etat ? 'toggle-on' : 'toggle-off')
                            ->class($diagnosticstatut->etat ? 'btn btn-success' : 'btn btn-secondary');
                    }),

                TD::make('Actions')
                    ->alignRight()
                    ->render(function (Diagnosticstatut $diagnosticstatut) {
                        return ModalToggle::make('Modifier')
                                ->modal('editDiagnosticstatutModal')
                                ->modalTitle('Modifier le statut du diagnostic')
                                ->method('update')
                                ->asyncParameters([
                                    'diagnosticstatut' => $diagnosticstatut->id,
                                ])
                                ->icon('pencil')
                                ->class('btn btn-sm btn-warning')
                            . ' ' . 
                            Button::make('Supprimer')
                                ->confirm('Après la suppression, le statut du diagnostic disparaîtra définitivement.')
                                ->method('delete', ['diagnosticstatut' => $diagnosticstatut->id])
                                ->icon('trash')
                                ->class('btn btn-sm btn-danger');
                    }),

            ]),

            Layout::modal('diagnosticstatutModal', Layout::rows([
                Input::make('diagnosticstatut.titre')
                    ->title('Titre')
                    ->placeholder('Entrez le nom du statut du diagnostic')
                    ->help('Le nom du statut du diagnostic à créer.'),
            ]))
                ->title('Créer un statut du diagnostic')
                ->applyButton('Ajouter un statut du diagnostic'),


            Layout::modal('editDiagnosticstatutModal', Layout::rows([
                Input::make('diagnosticstatut.id')->type('hidden'),

                Input::make('diagnosticstatut.titre')
                    ->title('Titre')
                    ->required(),
            ]))
                ->async('asyncDiagnosticstatut')
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
        // Validate form data, save diagnosticstatut to database, etc.
        $request->validate([
            'diagnosticstatut.titre' => 'required|max:255',
        ]);

        $diagnosticstatut = new Diagnosticstatut();
        $diagnosticstatut->titre = $request->input('diagnosticstatut.titre');
        $diagnosticstatut->save();
    }

    /**
     * @param Diagnosticstatut $diagnosticstatut
     *
     * @return void
     */
    public function delete(Diagnosticstatut $diagnosticstatut)
    {
        $diagnosticstatut->delete();
    }



    public function toggleEtat(Request $request)
    {
        $diagnosticstatut = Diagnosticstatut::findOrFail($request->input('diagnosticstatut'));
        $diagnosticstatut->etat = !$diagnosticstatut->etat;
        $diagnosticstatut->save();
    }

    public function update(Request $request)
    {
        $request->validate([
            'diagnosticstatut.titre' => 'required|max:255',
        ]);

        $diagnosticstatut = Diagnosticstatut::findOrFail($request->input('diagnosticstatut.id'));
        $diagnosticstatut->titre = $request->input('diagnosticstatut.titre');
        $diagnosticstatut->save();
    }

}
