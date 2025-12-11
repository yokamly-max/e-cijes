<?php

namespace App\Orchid\Screens\Parametres;

use Orchid\Screen\Screen;
use Orchid\Screen\Fields\Input;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Actions\ModalToggle;

use App\Models\Diagnostictype;
use Illuminate\Http\Request;

use Orchid\Screen\TD;
use Orchid\Screen\Actions\Button;

use Illuminate\Support\Facades\Redirect; // si tu veux rediriger après

class DiagnostictypeScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            'diagnostictypes' => Diagnostictype::latest()->paginate(20),
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Liste des profils émotionnels';
    }

    /**
     * Displays a description on the user's screen
     * directly under the heading.
     */
    public function description(): ?string
    {
        return "Paramètres";
    }

    public function asyncDiagnostictype(Diagnostictype $diagnostictype): iterable
    {
        return [
            'diagnostictype' => $diagnostictype
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
            ModalToggle::make('Ajouter un profil émotionnel')
                ->modal('diagnostictypeModal')
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
            Layout::table('diagnostictypes', [
                TD::make('titre'),

                TD::make('etat', 'État')
                    ->render(function (Diagnostictype $diagnostictype) {
                        return Button::make($diagnostictype->etat ? 'Désactiver' : 'Activer')
                            ->method('toggleEtat', [
                                'diagnostictype' => $diagnostictype->id,
                            ])
                            ->icon($diagnostictype->etat ? 'toggle-on' : 'toggle-off')
                            ->class($diagnostictype->etat ? 'btn btn-success' : 'btn btn-secondary');
                    }),

                TD::make('Actions')
                    ->alignRight()
                    ->render(function (Diagnostictype $diagnostictype) {
                        return ModalToggle::make('Modifier')
                                ->modal('editDiagnostictypeModal')
                                ->modalTitle('Modifier le profil émotionnel')
                                ->method('update')
                                ->asyncParameters([
                                    'diagnostictype' => $diagnostictype->id,
                                ])
                                ->icon('pencil')
                                ->class('btn btn-sm btn-warning')
                            . ' ' . 
                            Button::make('Supprimer')
                                ->confirm('Après la suppression, le profil émotionnel disparaîtra définitivement.')
                                ->method('delete', ['diagnostictype' => $diagnostictype->id])
                                ->icon('trash')
                                ->class('btn btn-sm btn-danger');
                    }),

            ]),

            Layout::modal('diagnostictypeModal', Layout::rows([
                Input::make('diagnostictype.titre')
                    ->title('Titre')
                    ->placeholder('Entrez le nom du profil émotionnel')
                    ->help('Le nom du profil émotionnel à créer.'),
            ]))
                ->title('Créer un profil émotionnel')
                ->applyButton('Ajouter un profil émotionnel'),


            Layout::modal('editDiagnostictypeModal', Layout::rows([
                Input::make('diagnostictype.id')->type('hidden'),

                Input::make('diagnostictype.titre')
                    ->title('Titre')
                    ->required(),
            ]))
                ->async('asyncDiagnostictype')
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
        // Validate form data, save diagnostictype to database, etc.
        $request->validate([
            'diagnostictype.titre' => 'required|max:255',
        ]);

        $diagnostictype = new Diagnostictype();
        $diagnostictype->titre = $request->input('diagnostictype.titre');
        $diagnostictype->save();
    }

    /**
     * @param Diagnostictype $diagnostictype
     *
     * @return void
     */
    public function delete(Diagnostictype $diagnostictype)
    {
        $diagnostictype->delete();
    }



    public function toggleEtat(Request $request)
    {
        $diagnostictype = Diagnostictype::findOrFail($request->input('diagnostictype'));
        $diagnostictype->etat = !$diagnostictype->etat;
        $diagnostictype->save();
    }

    public function update(Request $request)
    {
        $request->validate([
            'diagnostictype.titre' => 'required|max:255',
        ]);

        $diagnostictype = Diagnostictype::findOrFail($request->input('diagnostictype.id'));
        $diagnostictype->titre = $request->input('diagnostictype.titre');
        $diagnostictype->save();
    }

}
