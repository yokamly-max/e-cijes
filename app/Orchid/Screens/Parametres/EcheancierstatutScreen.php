<?php

namespace App\Orchid\Screens\Parametres;

use Orchid\Screen\Screen;
use Orchid\Screen\Fields\Input;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Actions\ModalToggle;

use App\Models\Echeancierstatut;
use Illuminate\Http\Request;

use Orchid\Screen\TD;
use Orchid\Screen\Actions\Button;

use Illuminate\Support\Facades\Redirect; // si tu veux rediriger après

class EcheancierstatutScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            'echeancierstatuts' => Echeancierstatut::latest()->paginate(20),
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Liste des statuts d\'échéanciers';
    }

    /**
     * Displays a description on the user's screen
     * directly under the heading.
     */
    public function description(): ?string
    {
        return "Paramètres";
    }

    public function asyncEcheancierstatut(Echeancierstatut $echeancierstatut): iterable
    {
        return [
            'echeancierstatut' => $echeancierstatut
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
            ModalToggle::make('Ajouter un statut d\'échéancier')
                ->modal('echeancierstatutModal')
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
            Layout::table('echeancierstatuts', [
                TD::make('titre'),

                TD::make('etat', 'État')
                    ->render(function (Echeancierstatut $echeancierstatut) {
                        return Button::make($echeancierstatut->etat ? 'Désactiver' : 'Activer')
                            ->method('toggleEtat', [
                                'echeancierstatut' => $echeancierstatut->id,
                            ])
                            ->icon($echeancierstatut->etat ? 'toggle-on' : 'toggle-off')
                            ->class($echeancierstatut->etat ? 'btn btn-success' : 'btn btn-secondary');
                    }),

                TD::make('Actions')
                    ->alignRight()
                    ->render(function (Echeancierstatut $echeancierstatut) {
                        return ModalToggle::make('Modifier')
                                ->modal('editEcheancierstatutModal')
                                ->modalTitle('Modifier le statut d\'echeancier')
                                ->method('update')
                                ->asyncParameters([
                                    'echeancierstatut' => $echeancierstatut->id,
                                ])
                                ->icon('pencil')
                                ->class('btn btn-sm btn-warning')
                            . ' ' . 
                            Button::make('Supprimer')
                                ->confirm('Après la suppression, le statut d\'échéancier disparaîtra définitivement.')
                                ->method('delete', ['echeancierstatut' => $echeancierstatut->id])
                                ->icon('trash')
                                ->class('btn btn-sm btn-danger');
                    }),

            ]),

            Layout::modal('echeancierstatutModal', Layout::rows([
                Input::make('echeancierstatut.titre')
                    ->title('Titre')
                    ->placeholder('Entrez le nom du statut d\'échéancier')
                    ->help('Le nom du statut d\'échéancier à créer.'),
            ]))
                ->title('Créer un statut d\'échéancier')
                ->applyButton('Ajouter un statut d\'échéancier'),


            Layout::modal('editEcheancierstatutModal', Layout::rows([
                Input::make('echeancierstatut.id')->type('hidden'),

                Input::make('echeancierstatut.titre')
                    ->title('Titre')
                    ->required(),
            ]))
                ->async('asyncEcheancierstatut')
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
        // Validate form data, save echeancierstatut to database, etc.
        $request->validate([
            'echeancierstatut.titre' => 'required|max:255',
        ]);

        $echeancierstatut = new Echeancierstatut();
        $echeancierstatut->titre = $request->input('echeancierstatut.titre');
        $echeancierstatut->save();
    }

    /**
     * @param Echeancierstatut $echeancierstatut
     *
     * @return void
     */
    public function delete(Echeancierstatut $echeancierstatut)
    {
        $echeancierstatut->delete();
    }



    public function toggleEtat(Request $request)
    {
        $echeancierstatut = Echeancierstatut::findOrFail($request->input('echeancierstatut'));
        $echeancierstatut->etat = !$echeancierstatut->etat;
        $echeancierstatut->save();
    }

    public function update(Request $request)
    {
        $request->validate([
            'echeancierstatut.titre' => 'required|max:255',
        ]);

        $echeancierstatut = Echeancierstatut::findOrFail($request->input('echeancierstatut.id'));
        $echeancierstatut->titre = $request->input('echeancierstatut.titre');
        $echeancierstatut->save();
    }

}
