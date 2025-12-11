<?php

namespace App\Orchid\Screens\Parametres;

use Orchid\Screen\Screen;
use Orchid\Screen\Fields\Input;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Actions\ModalToggle;

use App\Models\Prestationrealiseestatut;
use Illuminate\Http\Request;

use Orchid\Screen\TD;
use Orchid\Screen\Actions\Button;

use Illuminate\Support\Facades\Redirect; // si tu veux rediriger après

class PrestationrealiseestatutScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            'prestationrealiseestatuts' => Prestationrealiseestatut::latest()->paginate(20),
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Liste des statuts de la prestation realisée';
    }

    /**
     * Displays a description on the user's screen
     * directly under the heading.
     */
    public function description(): ?string
    {
        return "Paramètres";
    }

    public function asyncPrestationrealiseestatut(Prestationrealiseestatut $prestationrealiseestatut): iterable
    {
        return [
            'prestationrealiseestatut' => $prestationrealiseestatut
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
            ModalToggle::make('Ajouter un statut de la prestation realisée')
                ->modal('prestationrealiseestatutModal')
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
            Layout::table('prestationrealiseestatuts', [
                TD::make('titre'),

                TD::make('etat', 'État')
                    ->render(function (Prestationrealiseestatut $prestationrealiseestatut) {
                        return Button::make($prestationrealiseestatut->etat ? 'Désactiver' : 'Activer')
                            ->method('toggleEtat', [
                                'prestationrealiseestatut' => $prestationrealiseestatut->id,
                            ])
                            ->icon($prestationrealiseestatut->etat ? 'toggle-on' : 'toggle-off')
                            ->class($prestationrealiseestatut->etat ? 'btn btn-success' : 'btn btn-secondary');
                    }),

                TD::make('Actions')
                    ->alignRight()
                    ->render(function (Prestationrealiseestatut $prestationrealiseestatut) {
                        return ModalToggle::make('Modifier')
                                ->modal('editPrestationrealiseestatutModal')
                                ->modalTitle('Modifier le statut de la prestation realisée')
                                ->method('update')
                                ->asyncParameters([
                                    'prestationrealiseestatut' => $prestationrealiseestatut->id,
                                ])
                                ->icon('pencil')
                                ->class('btn btn-sm btn-warning')
                            . ' ' . 
                            Button::make('Supprimer')
                                ->confirm('Après la suppression, le statut de la prestation realisée disparaîtra définitivement.')
                                ->method('delete', ['prestationrealiseestatut' => $prestationrealiseestatut->id])
                                ->icon('trash')
                                ->class('btn btn-sm btn-danger');
                    }),

            ]),

            Layout::modal('prestationrealiseestatutModal', Layout::rows([
                Input::make('prestationrealiseestatut.titre')
                    ->title('Titre')
                    ->placeholder('Entrez le nom du statut de la prestation realisée')
                    ->help('Le nom du statut de la prestation realisée à créer.'),
            ]))
                ->title('Créer un statut de la prestation realisée')
                ->applyButton('Ajouter un statut de la prestation realisée'),


            Layout::modal('editPrestationrealiseestatutModal', Layout::rows([
                Input::make('prestationrealiseestatut.id')->type('hidden'),

                Input::make('prestationrealiseestatut.titre')
                    ->title('Titre')
                    ->required(),
            ]))
                ->async('asyncPrestationrealiseestatut')
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
        // Validate form data, save prestationrealiseestatut to database, etc.
        $request->validate([
            'prestationrealiseestatut.titre' => 'required|max:255',
        ]);

        $prestationrealiseestatut = new Prestationrealiseestatut();
        $prestationrealiseestatut->titre = $request->input('prestationrealiseestatut.titre');
        $prestationrealiseestatut->save();
    }

    /**
     * @param Prestationrealiseestatut $prestationrealiseestatut
     *
     * @return void
     */
    public function delete(Prestationrealiseestatut $prestationrealiseestatut)
    {
        $prestationrealiseestatut->delete();
    }



    public function toggleEtat(Request $request)
    {
        $prestationrealiseestatut = Prestationrealiseestatut::findOrFail($request->input('prestationrealiseestatut'));
        $prestationrealiseestatut->etat = !$prestationrealiseestatut->etat;
        $prestationrealiseestatut->save();
    }

    public function update(Request $request)
    {
        $request->validate([
            'prestationrealiseestatut.titre' => 'required|max:255',
        ]);

        $prestationrealiseestatut = Prestationrealiseestatut::findOrFail($request->input('prestationrealiseestatut.id'));
        $prestationrealiseestatut->titre = $request->input('prestationrealiseestatut.titre');
        $prestationrealiseestatut->save();
    }

}
