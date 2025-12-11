<?php

namespace App\Orchid\Screens\Parametres;

use Orchid\Screen\Screen;
use Orchid\Screen\Fields\Input;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Actions\ModalToggle;

use App\Models\Membretype;
use Illuminate\Http\Request;

use Orchid\Screen\TD;
use Orchid\Screen\Actions\Button;

use Illuminate\Support\Facades\Redirect; // si tu veux rediriger après

class MembretypeScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            'membretypes' => Membretype::latest()->paginate(20),
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Liste des types de membres';
    }

    /**
     * Displays a description on the user's screen
     * directly under the heading.
     */
    public function description(): ?string
    {
        return "Paramètres";
    }

    public function asyncMembretype(Membretype $membretype): iterable
    {
        return [
            'membretype' => $membretype
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
            ModalToggle::make('Ajouter un type de membre')
                ->modal('membretypeModal')
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
            Layout::table('membretypes', [
                TD::make('titre'),

                TD::make('etat', 'État')
                    ->render(function (Membretype $membretype) {
                        return Button::make($membretype->etat ? 'Désactiver' : 'Activer')
                            ->method('toggleEtat', [
                                'membretype' => $membretype->id,
                            ])
                            ->icon($membretype->etat ? 'toggle-on' : 'toggle-off')
                            ->class($membretype->etat ? 'btn btn-success' : 'btn btn-secondary');
                    }),

                TD::make('Actions')
                    ->alignRight()
                    ->render(function (Membretype $membretype) {
                        return ModalToggle::make('Modifier')
                                ->modal('editMembretypeModal')
                                ->modalTitle('Modifier le type de membre')
                                ->method('update')
                                ->asyncParameters([
                                    'membretype' => $membretype->id,
                                ])
                                ->icon('pencil')
                                ->class('btn btn-sm btn-warning')
                            . ' ' . 
                            Button::make('Supprimer')
                                ->confirm('Après la suppression, le type de membre disparaîtra définitivement.')
                                ->method('delete', ['membretype' => $membretype->id])
                                ->icon('trash')
                                ->class('btn btn-sm btn-danger');
                    }),

            ]),

            Layout::modal('membretypeModal', Layout::rows([
                Input::make('membretype.titre')
                    ->title('Titre')
                    ->placeholder('Entrez le nom du type de membre')
                    ->help('Le nom du type de membre à créer.'),
            ]))
                ->title('Créer un type de membre')
                ->applyButton('Ajouter un type de membre'),


            Layout::modal('editMembretypeModal', Layout::rows([
                Input::make('membretype.id')->type('hidden'),

                Input::make('membretype.titre')
                    ->title('Titre')
                    ->required(),
            ]))
                ->async('asyncMembretype')
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
        // Validate form data, save membretype to database, etc.
        $request->validate([
            'membretype.titre' => 'required|max:255',
        ]);

        $membretype = new Membretype();
        $membretype->titre = $request->input('membretype.titre');
        $membretype->save();
    }

    /**
     * @param Membretype $membretype
     *
     * @return void
     */
    public function delete(Membretype $membretype)
    {
        $membretype->delete();
    }



    public function toggleEtat(Request $request)
    {
        $membretype = Membretype::findOrFail($request->input('membretype'));
        $membretype->etat = !$membretype->etat;
        $membretype->save();
    }

    public function update(Request $request)
    {
        $request->validate([
            'membretype.titre' => 'required|max:255',
        ]);

        $membretype = Membretype::findOrFail($request->input('membretype.id'));
        $membretype->titre = $request->input('membretype.titre');
        $membretype->save();
    }

}
