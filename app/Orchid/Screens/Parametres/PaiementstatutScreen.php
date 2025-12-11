<?php

namespace App\Orchid\Screens\Parametres;

use Orchid\Screen\Screen;
use Orchid\Screen\Fields\Input;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Actions\ModalToggle;

use App\Models\Paiementstatut;
use Illuminate\Http\Request;

use Orchid\Screen\TD;
use Orchid\Screen\Actions\Button;

use Illuminate\Support\Facades\Redirect; // si tu veux rediriger après

class PaiementstatutScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            'paiementstatuts' => Paiementstatut::latest()->paginate(20),
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Liste des statuts du paiement';
    }

    /**
     * Displays a description on the user's screen
     * directly under the heading.
     */
    public function description(): ?string
    {
        return "Paramètres";
    }

    public function asyncPaiementstatut(Paiementstatut $paiementstatut): iterable
    {
        return [
            'paiementstatut' => $paiementstatut
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
            ModalToggle::make('Ajouter un statut du paiement')
                ->modal('paiementstatutModal')
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
            Layout::table('paiementstatuts', [
                TD::make('titre'),

                TD::make('etat', 'État')
                    ->render(function (Paiementstatut $paiementstatut) {
                        return Button::make($paiementstatut->etat ? 'Désactiver' : 'Activer')
                            ->method('toggleEtat', [
                                'paiementstatut' => $paiementstatut->id,
                            ])
                            ->icon($paiementstatut->etat ? 'toggle-on' : 'toggle-off')
                            ->class($paiementstatut->etat ? 'btn btn-success' : 'btn btn-secondary');
                    }),

                TD::make('Actions')
                    ->alignRight()
                    ->render(function (Paiementstatut $paiementstatut) {
                        return ModalToggle::make('Modifier')
                                ->modal('editPaiementstatutModal')
                                ->modalTitle('Modifier le statut du paiement')
                                ->method('update')
                                ->asyncParameters([
                                    'paiementstatut' => $paiementstatut->id,
                                ])
                                ->icon('pencil')
                                ->class('btn btn-sm btn-warning')
                            . ' ' . 
                            Button::make('Supprimer')
                                ->confirm('Après la suppression, le statut du paiement disparaîtra définitivement.')
                                ->method('delete', ['paiementstatut' => $paiementstatut->id])
                                ->icon('trash')
                                ->class('btn btn-sm btn-danger');
                    }),

            ]),

            Layout::modal('paiementstatutModal', Layout::rows([
                Input::make('paiementstatut.titre')
                    ->title('Titre')
                    ->placeholder('Entrez le nom du statut du paiement')
                    ->help('Le nom du statut du paiement à créer.'),
            ]))
                ->title('Créer un statut du paiement')
                ->applyButton('Ajouter un statut du paiement'),


            Layout::modal('editPaiementstatutModal', Layout::rows([
                Input::make('paiementstatut.id')->type('hidden'),

                Input::make('paiementstatut.titre')
                    ->title('Titre')
                    ->required(),
            ]))
                ->async('asyncPaiementstatut')
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
        // Validate form data, save paiementstatut to database, etc.
        $request->validate([
            'paiementstatut.titre' => 'required|max:255',
        ]);

        $paiementstatut = new Paiementstatut();
        $paiementstatut->titre = $request->input('paiementstatut.titre');
        $paiementstatut->save();
    }

    /**
     * @param Paiementstatut $paiementstatut
     *
     * @return void
     */
    public function delete(Paiementstatut $paiementstatut)
    {
        $paiementstatut->delete();
    }



    public function toggleEtat(Request $request)
    {
        $paiementstatut = Paiementstatut::findOrFail($request->input('paiementstatut'));
        $paiementstatut->etat = !$paiementstatut->etat;
        $paiementstatut->save();
    }

    public function update(Request $request)
    {
        $request->validate([
            'paiementstatut.titre' => 'required|max:255',
        ]);

        $paiementstatut = Paiementstatut::findOrFail($request->input('paiementstatut.id'));
        $paiementstatut->titre = $request->input('paiementstatut.titre');
        $paiementstatut->save();
    }

}
