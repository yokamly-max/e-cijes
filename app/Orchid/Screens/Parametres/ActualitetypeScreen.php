<?php

namespace App\Orchid\Screens\Parametres;

use Orchid\Screen\Screen;
use Orchid\Screen\Fields\Input;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Actions\ModalToggle;

use App\Models\Actualitetype;
use Illuminate\Http\Request;

use Orchid\Screen\TD;
use Orchid\Screen\Actions\Button;

use Illuminate\Support\Facades\Redirect; // si tu veux rediriger après

class ActualitetypeScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            'actualitetypes' => Actualitetype::latest()->paginate(20),
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Liste des types d\'actualites';
    }

    /**
     * Displays a description on the user's screen
     * directly under the heading.
     */
    public function description(): ?string
    {
        return "Paramètres";
    }

    public function asyncActualitetype(Actualitetype $actualitetype): iterable
    {
        return [
            'actualitetype' => $actualitetype
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
            ModalToggle::make('Ajouter un type d\'actualite')
                ->modal('actualitetypeModal')
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
            Layout::table('actualitetypes', [
                TD::make('titre'),

                TD::make('etat', 'État')
                    ->render(function (Actualitetype $actualitetype) {
                        return Button::make($actualitetype->etat ? 'Désactiver' : 'Activer')
                            ->method('toggleEtat', [
                                'actualitetype' => $actualitetype->id,
                            ])
                            ->icon($actualitetype->etat ? 'toggle-on' : 'toggle-off')
                            ->class($actualitetype->etat ? 'btn btn-success' : 'btn btn-secondary');
                    }),

                TD::make('Actions')
                    ->alignRight()
                    ->render(function (Actualitetype $actualitetype) {
                        return ModalToggle::make('Modifier')
                                ->modal('editActualitetypeModal')
                                ->modalTitle('Modifier le type d\'actualite')
                                ->method('update')
                                ->asyncParameters([
                                    'actualitetype' => $actualitetype->id,
                                ])
                                ->icon('pencil')
                                ->class('btn btn-sm btn-warning')
                            . ' ' . 
                            Button::make('Supprimer')
                                ->confirm('Après la suppression, le type d\'actualite disparaîtra définitivement.')
                                ->method('delete', ['actualitetype' => $actualitetype->id])
                                ->icon('trash')
                                ->class('btn btn-sm btn-danger');
                    }),

            ]),

            Layout::modal('actualitetypeModal', Layout::rows([
                Input::make('actualitetype.titre')
                    ->title('Titre')
                    ->placeholder('Entrez le nom du type d\'actualite')
                    ->help('Le nom du type d\'actualite à créer.'),
            ]))
                ->title('Créer un type d\'actualite')
                ->applyButton('Ajouter un type d\'actualite'),


            Layout::modal('editActualitetypeModal', Layout::rows([
                Input::make('actualitetype.id')->type('hidden'),

                Input::make('actualitetype.titre')
                    ->title('Titre')
                    ->required(),
            ]))
                ->async('asyncActualitetype')
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
        // Validate form data, save actualitetype to database, etc.
        $request->validate([
            'actualitetype.titre' => 'required|max:255',
        ]);

        $actualitetype = new Actualitetype();
        $actualitetype->titre = $request->input('actualitetype.titre');
        $actualitetype->save();
    }

    /**
     * @param Actualitetype $actualitetype
     *
     * @return void
     */
    public function delete(Actualitetype $actualitetype)
    {
        $actualitetype->delete();
    }



    public function toggleEtat(Request $request)
    {
        $actualitetype = Actualitetype::findOrFail($request->input('actualitetype'));
        $actualitetype->etat = !$actualitetype->etat;
        $actualitetype->save();
    }

    public function update(Request $request)
    {
        $request->validate([
            'actualitetype.titre' => 'required|max:255',
        ]);

        $actualitetype = Actualitetype::findOrFail($request->input('actualitetype.id'));
        $actualitetype->titre = $request->input('actualitetype.titre');
        $actualitetype->save();
    }

}
