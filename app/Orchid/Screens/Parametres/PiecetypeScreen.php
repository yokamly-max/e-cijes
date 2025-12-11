<?php

namespace App\Orchid\Screens\Parametres;

use Orchid\Screen\Screen;
use Orchid\Screen\Fields\Input;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Actions\ModalToggle;

use App\Models\Piecetype;
use Illuminate\Http\Request;

use Orchid\Screen\TD;
use Orchid\Screen\Actions\Button;

use Illuminate\Support\Facades\Redirect; // si tu veux rediriger après

class PiecetypeScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            'piecetypes' => Piecetype::latest()->paginate(20),
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Liste des types de pieces';
    }

    /**
     * Displays a description on the user's screen
     * directly under the heading.
     */
    public function description(): ?string
    {
        return "Paramètres";
    }

    public function asyncPiecetype(Piecetype $piecetype): iterable
    {
        return [
            'piecetype' => $piecetype
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
            ModalToggle::make('Ajouter un type de piece')
                ->modal('piecetypeModal')
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
            Layout::table('piecetypes', [
                TD::make('titre'),

                TD::make('etat', 'État')
                    ->render(function (Piecetype $piecetype) {
                        return Button::make($piecetype->etat ? 'Désactiver' : 'Activer')
                            ->method('toggleEtat', [
                                'piecetype' => $piecetype->id,
                            ])
                            ->icon($piecetype->etat ? 'toggle-on' : 'toggle-off')
                            ->class($piecetype->etat ? 'btn btn-success' : 'btn btn-secondary');
                    }),

                TD::make('Actions')
                    ->alignRight()
                    ->render(function (Piecetype $piecetype) {
                        return ModalToggle::make('Modifier')
                                ->modal('editPiecetypeModal')
                                ->modalTitle('Modifier le type de piece')
                                ->method('update')
                                ->asyncParameters([
                                    'piecetype' => $piecetype->id,
                                ])
                                ->icon('pencil')
                                ->class('btn btn-sm btn-warning')
                            . ' ' . 
                            Button::make('Supprimer')
                                ->confirm('Après la suppression, le type de piece disparaîtra définitivement.')
                                ->method('delete', ['piecetype' => $piecetype->id])
                                ->icon('trash')
                                ->class('btn btn-sm btn-danger');
                    }),

            ]),

            Layout::modal('piecetypeModal', Layout::rows([
                Input::make('piecetype.titre')
                    ->title('Titre')
                    ->placeholder('Entrez le nom du type de piece')
                    ->help('Le nom du type de piece à créer.'),
            ]))
                ->title('Créer un type de piece')
                ->applyButton('Ajouter un type de piece'),


            Layout::modal('editPiecetypeModal', Layout::rows([
                Input::make('piecetype.id')->type('hidden'),

                Input::make('piecetype.titre')
                    ->title('Titre')
                    ->required(),
            ]))
                ->async('asyncPiecetype')
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
        // Validate form data, save piecetype to database, etc.
        $request->validate([
            'piecetype.titre' => 'required|max:255',
        ]);

        $piecetype = new Piecetype();
        $piecetype->titre = $request->input('piecetype.titre');
        $piecetype->save();
    }

    /**
     * @param Piecetype $piecetype
     *
     * @return void
     */
    public function delete(Piecetype $piecetype)
    {
        $piecetype->delete();
    }



    public function toggleEtat(Request $request)
    {
        $piecetype = Piecetype::findOrFail($request->input('piecetype'));
        $piecetype->etat = !$piecetype->etat;
        $piecetype->save();
    }

    public function update(Request $request)
    {
        $request->validate([
            'piecetype.titre' => 'required|max:255',
        ]);

        $piecetype = Piecetype::findOrFail($request->input('piecetype.id'));
        $piecetype->titre = $request->input('piecetype.titre');
        $piecetype->save();
    }

}
