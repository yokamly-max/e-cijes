<?php

namespace App\Orchid\Screens\Parametres;

use Orchid\Screen\Screen;
use Orchid\Screen\Fields\Input;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Actions\ModalToggle;

use App\Models\Diagnosticquestioncategorie;
use Illuminate\Http\Request;

use Orchid\Screen\TD;
use Orchid\Screen\Actions\Button;

use Illuminate\Support\Facades\Redirect; // si tu veux rediriger après

class DiagnosticquestioncategorieScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            'diagnosticquestioncategories' => Diagnosticquestioncategorie::latest()->paginate(20),
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Liste des categories des questions du diagnostic ';
    }

    /**
     * Displays a description on the user's screen
     * directly under the heading.
     */
    public function description(): ?string
    {
        return "Paramètres";
    }

    public function asyncDiagnosticquestioncategorie(Diagnosticquestioncategorie $diagnosticquestioncategorie): iterable
    {
        return [
            'diagnosticquestioncategorie' => $diagnosticquestioncategorie
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
            ModalToggle::make('Ajouter une categorie de la question du diagnostic')
                ->modal('diagnosticquestioncategorieModal')
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
            Layout::table('diagnosticquestioncategories', [
                TD::make('titre'),

                TD::make('etat', 'État')
                    ->render(function (Diagnosticquestioncategorie $diagnosticquestioncategorie) {
                        return Button::make($diagnosticquestioncategorie->etat ? 'Désactiver' : 'Activer')
                            ->method('toggleEtat', [
                                'diagnosticquestioncategorie' => $diagnosticquestioncategorie->id,
                            ])
                            ->icon($diagnosticquestioncategorie->etat ? 'toggle-on' : 'toggle-off')
                            ->class($diagnosticquestioncategorie->etat ? 'btn btn-success' : 'btn btn-secondary');
                    }),

                TD::make('Actions')
                    ->alignRight()
                    ->render(function (Diagnosticquestioncategorie $diagnosticquestioncategorie) {
                        return ModalToggle::make('Modifier')
                                ->modal('editDiagnosticquestioncategorieModal')
                                ->modalTitle('Modifier la categorie de la question du diagnostic')
                                ->method('update')
                                ->asyncParameters([
                                    'diagnosticquestioncategorie' => $diagnosticquestioncategorie->id,
                                ])
                                ->icon('pencil')
                                ->class('btn btn-sm btn-warning')
                            . ' ' . 
                            Button::make('Supprimer')
                                ->confirm('Après la suppression, la categorie de la question du diagnostic disparaîtra définitivement.')
                                ->method('delete', ['diagnosticquestioncategorie' => $diagnosticquestioncategorie->id])
                                ->icon('trash')
                                ->class('btn btn-sm btn-danger');
                    }),

            ]),

            Layout::modal('diagnosticquestioncategorieModal', Layout::rows([
                Input::make('diagnosticquestioncategorie.titre')
                    ->title('Titre')
                    ->placeholder('Entrez le nom de la categorie')
                    ->help('Le nom de la categorie à créer.'),
            ]))
                ->title('Créer une categorie')
                ->applyButton('Ajouter une categorie'),


            Layout::modal('editDiagnosticquestioncategorieModal', Layout::rows([
                Input::make('diagnosticquestioncategorie.id')->categorie('hidden'),

                Input::make('diagnosticquestioncategorie.titre')
                    ->title('Titre')
                    ->required(),
            ]))
                ->async('asyncDiagnosticquestioncategorie')
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
        // Validate form data, save diagnosticquestioncategorie to database, etc.
        $request->validate([
            'diagnosticquestioncategorie.titre' => 'required|max:255',
        ]);

        $diagnosticquestioncategorie = new Diagnosticquestioncategorie();
        $diagnosticquestioncategorie->titre = $request->input('diagnosticquestioncategorie.titre');
        $diagnosticquestioncategorie->save();
    }

    /**
     * @param Diagnosticquestioncategorie $diagnosticquestioncategorie
     *
     * @return void
     */
    public function delete(Diagnosticquestioncategorie $diagnosticquestioncategorie)
    {
        $diagnosticquestioncategorie->delete();
    }



    public function toggleEtat(Request $request)
    {
        $diagnosticquestioncategorie = Diagnosticquestioncategorie::findOrFail($request->input('diagnosticquestioncategorie'));
        $diagnosticquestioncategorie->etat = !$diagnosticquestioncategorie->etat;
        $diagnosticquestioncategorie->save();
    }

    public function update(Request $request)
    {
        $request->validate([
            'diagnosticquestioncategorie.titre' => 'required|max:255',
        ]);

        $diagnosticquestioncategorie = Diagnosticquestioncategorie::findOrFail($request->input('diagnosticquestioncategorie.id'));
        $diagnosticquestioncategorie->titre = $request->input('diagnosticquestioncategorie.titre');
        $diagnosticquestioncategorie->save();
    }

}
