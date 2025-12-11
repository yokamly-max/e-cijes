<?php

namespace App\Orchid\Screens\Parametres;

use Orchid\Screen\Screen;
use Orchid\Screen\Fields\Input;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Actions\ModalToggle;

use App\Models\Creditstatut;
use Illuminate\Http\Request;

use Orchid\Screen\TD;
use Orchid\Screen\Actions\Button;

use Illuminate\Support\Facades\Redirect; // si tu veux rediriger après

class CreditstatutScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            'creditstatuts' => Creditstatut::latest()->paginate(20),
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Liste des statuts de crédits';
    }

    /**
     * Displays a description on the user's screen
     * directly under the heading.
     */
    public function description(): ?string
    {
        return "Paramètres";
    }

    public function asyncCreditstatut(Creditstatut $creditstatut): iterable
    {
        return [
            'creditstatut' => $creditstatut
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
            ModalToggle::make('Ajouter un statut de crédit')
                ->modal('creditstatutModal')
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
            Layout::table('creditstatuts', [
                TD::make('titre'),

                TD::make('etat', 'État')
                    ->render(function (Creditstatut $creditstatut) {
                        return Button::make($creditstatut->etat ? 'Désactiver' : 'Activer')
                            ->method('toggleEtat', [
                                'creditstatut' => $creditstatut->id,
                            ])
                            ->icon($creditstatut->etat ? 'toggle-on' : 'toggle-off')
                            ->class($creditstatut->etat ? 'btn btn-success' : 'btn btn-secondary');
                    }),

                TD::make('Actions')
                    ->alignRight()
                    ->render(function (Creditstatut $creditstatut) {
                        return ModalToggle::make('Modifier')
                                ->modal('editCreditstatutModal')
                                ->modalTitle('Modifier le statut de crédit')
                                ->method('update')
                                ->asyncParameters([
                                    'creditstatut' => $creditstatut->id,
                                ])
                                ->icon('pencil')
                                ->class('btn btn-sm btn-warning')
                            . ' ' . 
                            Button::make('Supprimer')
                                ->confirm('Après la suppression, le statut de crédit disparaîtra définitivement.')
                                ->method('delete', ['creditstatut' => $creditstatut->id])
                                ->icon('trash')
                                ->class('btn btn-sm btn-danger');
                    }),

            ]),

            Layout::modal('creditstatutModal', Layout::rows([
                Input::make('creditstatut.titre')
                    ->title('Titre')
                    ->placeholder('Entrez le nom du statut de crédit')
                    ->help('Le nom du statut de crédit à créer.'),
            ]))
                ->title('Créer un statut de crédit')
                ->applyButton('Ajouter un statut de crédit'),


            Layout::modal('editCreditstatutModal', Layout::rows([
                Input::make('creditstatut.id')->type('hidden'),

                Input::make('creditstatut.titre')
                    ->title('Titre')
                    ->required(),
            ]))
                ->async('asyncCreditstatut')
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
        // Validate form data, save creditstatut to database, etc.
        $request->validate([
            'creditstatut.titre' => 'required|max:255',
        ]);

        $creditstatut = new Creditstatut();
        $creditstatut->titre = $request->input('creditstatut.titre');
        $creditstatut->save();
    }

    /**
     * @param Creditstatut $creditstatut
     *
     * @return void
     */
    public function delete(Creditstatut $creditstatut)
    {
        $creditstatut->delete();
    }



    public function toggleEtat(Request $request)
    {
        $creditstatut = Creditstatut::findOrFail($request->input('creditstatut'));
        $creditstatut->etat = !$creditstatut->etat;
        $creditstatut->save();
    }

    public function update(Request $request)
    {
        $request->validate([
            'creditstatut.titre' => 'required|max:255',
        ]);

        $creditstatut = Creditstatut::findOrFail($request->input('creditstatut.id'));
        $creditstatut->titre = $request->input('creditstatut.titre');
        $creditstatut->save();
    }

}
