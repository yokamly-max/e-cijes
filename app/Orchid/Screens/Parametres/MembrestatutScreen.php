<?php

namespace App\Orchid\Screens\Parametres;

use Orchid\Screen\Screen;
use Orchid\Screen\Fields\Input;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Actions\ModalToggle;

use App\Models\Membrestatut;
use Illuminate\Http\Request;

use Orchid\Screen\TD;
use Orchid\Screen\Actions\Button;

use Illuminate\Support\Facades\Redirect; // si tu veux rediriger après

class MembrestatutScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            'membrestatuts' => Membrestatut::latest()->paginate(20),
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Liste des statuts de membres';
    }

    /**
     * Displays a description on the user's screen
     * directly under the heading.
     */
    public function description(): ?string
    {
        return "Paramètres";
    }

    public function asyncMembrestatut(Membrestatut $membrestatut): iterable
    {
        return [
            'membrestatut' => $membrestatut
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
            ModalToggle::make('Ajouter un statut de membre')
                ->modal('membrestatutModal')
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
            Layout::table('membrestatuts', [
                TD::make('titre'),

                TD::make('etat', 'État')
                    ->render(function (Membrestatut $membrestatut) {
                        return Button::make($membrestatut->etat ? 'Désactiver' : 'Activer')
                            ->method('toggleEtat', [
                                'membrestatut' => $membrestatut->id,
                            ])
                            ->icon($membrestatut->etat ? 'toggle-on' : 'toggle-off')
                            ->class($membrestatut->etat ? 'btn btn-success' : 'btn btn-secondary');
                    }),

                TD::make('Actions')
                    ->alignRight()
                    ->render(function (Membrestatut $membrestatut) {
                        return ModalToggle::make('Modifier')
                                ->modal('editMembrestatutModal')
                                ->modalTitle('Modifier le statut de membre')
                                ->method('update')
                                ->asyncParameters([
                                    'membrestatut' => $membrestatut->id,
                                ])
                                ->icon('pencil')
                                ->class('btn btn-sm btn-warning')
                            . ' ' . 
                            Button::make('Supprimer')
                                ->confirm('Après la suppression, le statut de membre disparaîtra définitivement.')
                                ->method('delete', ['membrestatut' => $membrestatut->id])
                                ->icon('trash')
                                ->class('btn btn-sm btn-danger');
                    }),

            ]),

            Layout::modal('membrestatutModal', Layout::rows([
                Input::make('membrestatut.titre')
                    ->title('Titre')
                    ->placeholder('Entrez le nom du statut de membre')
                    ->help('Le nom du statut de membre à créer.'),
            ]))
                ->title('Créer un statut de membre')
                ->applyButton('Ajouter un statut de membre'),


            Layout::modal('editMembrestatutModal', Layout::rows([
                Input::make('membrestatut.id')->type('hidden'),

                Input::make('membrestatut.titre')
                    ->title('Titre')
                    ->required(),
            ]))
                ->async('asyncMembrestatut')
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
        // Validate form data, save membrestatut to database, etc.
        $request->validate([
            'membrestatut.titre' => 'required|max:255',
        ]);

        $membrestatut = new Membrestatut();
        $membrestatut->titre = $request->input('membrestatut.titre');
        $membrestatut->save();
    }

    /**
     * @param Membrestatut $membrestatut
     *
     * @return void
     */
    public function delete(Membrestatut $membrestatut)
    {
        $membrestatut->delete();
    }



    public function toggleEtat(Request $request)
    {
        $membrestatut = Membrestatut::findOrFail($request->input('membrestatut'));
        $membrestatut->etat = !$membrestatut->etat;
        $membrestatut->save();
    }

    public function update(Request $request)
    {
        $request->validate([
            'membrestatut.titre' => 'required|max:255',
        ]);

        $membrestatut = Membrestatut::findOrFail($request->input('membrestatut.id'));
        $membrestatut->titre = $request->input('membrestatut.titre');
        $membrestatut->save();
    }

}
