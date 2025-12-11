<?php

namespace App\Orchid\Screens\Parametres;

use Orchid\Screen\Screen;
use Orchid\Screen\Fields\Input;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Actions\ModalToggle;

use App\Models\Dossierstatut;
use Illuminate\Http\Request;

use Orchid\Screen\TD;
use Orchid\Screen\Actions\Button;

use Illuminate\Support\Facades\Redirect; // si tu veux rediriger après

class DossierstatutScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            'dossierstatuts' => Dossierstatut::latest()->paginate(20),
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Liste des statuts des dossiers';
    }

    /**
     * Displays a description on the user's screen
     * directly under the heading.
     */
    public function description(): ?string
    {
        return "Paramètres";
    }

    public function asyncDossierstatut(Dossierstatut $dossierstatut): iterable
    {
        return [
            'dossierstatut' => $dossierstatut
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
            ModalToggle::make('Ajouter un statut du dossier')
                ->modal('dossierstatutModal')
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
            Layout::table('dossierstatuts', [
                TD::make('titre'),

                TD::make('etat', 'État')
                    ->render(function (Dossierstatut $dossierstatut) {
                        return Button::make($dossierstatut->etat ? 'Désactiver' : 'Activer')
                            ->method('toggleEtat', [
                                'dossierstatut' => $dossierstatut->id,
                            ])
                            ->icon($dossierstatut->etat ? 'toggle-on' : 'toggle-off')
                            ->class($dossierstatut->etat ? 'btn btn-success' : 'btn btn-secondary');
                    }),

                TD::make('Actions')
                    ->alignRight()
                    ->render(function (Dossierstatut $dossierstatut) {
                        return ModalToggle::make('Modifier')
                                ->modal('editDossierstatutModal')
                                ->modalTitle('Modifier le statut du dossier')
                                ->method('update')
                                ->asyncParameters([
                                    'dossierstatut' => $dossierstatut->id,
                                ])
                                ->icon('pencil')
                                ->class('btn btn-sm btn-warning')
                            . ' ' . 
                            Button::make('Supprimer')
                                ->confirm('Après la suppression, le statut du dossier disparaîtra définitivement.')
                                ->method('delete', ['dossierstatut' => $dossierstatut->id])
                                ->icon('trash')
                                ->class('btn btn-sm btn-danger');
                    }),

            ]),

            Layout::modal('dossierstatutModal', Layout::rows([
                Input::make('dossierstatut.titre')
                    ->title('Titre')
                    ->placeholder('Entrez le nom du statut du dossier')
                    ->help('Le nom du statut du dossier à créer.'),
            ]))
                ->title('Créer un statut du dossier')
                ->applyButton('Ajouter un statut du dossier'),


            Layout::modal('editDossierstatutModal', Layout::rows([
                Input::make('dossierstatut.id')->type('hidden'),

                Input::make('dossierstatut.titre')
                    ->title('Titre')
                    ->required(),
            ]))
                ->async('asyncDossierstatut')
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
        // Validate form data, save dossierstatut to database, etc.
        $request->validate([
            'dossierstatut.titre' => 'required|max:255',
        ]);

        $dossierstatut = new Dossierstatut();
        $dossierstatut->titre = $request->input('dossierstatut.titre');
        $dossierstatut->save();
    }

    /**
     * @param Dossierstatut $dossierstatut
     *
     * @return void
     */
    public function delete(Dossierstatut $dossierstatut)
    {
        $dossierstatut->delete();
    }



    public function toggleEtat(Request $request)
    {
        $dossierstatut = Dossierstatut::findOrFail($request->input('dossierstatut'));
        $dossierstatut->etat = !$dossierstatut->etat;
        $dossierstatut->save();
    }

    public function update(Request $request)
    {
        $request->validate([
            'dossierstatut.titre' => 'required|max:255',
        ]);

        $dossierstatut = Dossierstatut::findOrFail($request->input('dossierstatut.id'));
        $dossierstatut->titre = $request->input('dossierstatut.titre');
        $dossierstatut->save();
    }

}
