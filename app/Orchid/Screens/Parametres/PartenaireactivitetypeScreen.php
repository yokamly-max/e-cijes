<?php

namespace App\Orchid\Screens\Parametres;

use Orchid\Screen\Screen;
use Orchid\Screen\Fields\Input;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Actions\ModalToggle;

use App\Models\Partenaireactivitetype;
use Illuminate\Http\Request;

use Orchid\Screen\TD;
use Orchid\Screen\Actions\Button;

use Illuminate\Support\Facades\Redirect; // si tu veux rediriger après

class PartenaireactivitetypeScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            'partenaireactivitetypes' => Partenaireactivitetype::latest()->paginate(20),
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Liste des types d\'activités des partenaires';
    }

    /**
     * Displays a description on the user's screen
     * directly under the heading.
     */
    public function description(): ?string
    {
        return "Paramètres";
    }

    public function asyncPartenaireactivitetype(Partenaireactivitetype $partenaireactivitetype): iterable
    {
        return [
            'partenaireactivitetype' => $partenaireactivitetype
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
            ModalToggle::make('Ajouter un type d\'activité du partenaire')
                ->modal('partenaireactivitetypeModal')
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
            Layout::table('partenaireactivitetypes', [
                TD::make('titre'),

                TD::make('etat', 'État')
                    ->render(function (Partenaireactivitetype $partenaireactivitetype) {
                        return Button::make($partenaireactivitetype->etat ? 'Désactiver' : 'Activer')
                            ->method('toggleEtat', [
                                'partenaireactivitetype' => $partenaireactivitetype->id,
                            ])
                            ->icon($partenaireactivitetype->etat ? 'toggle-on' : 'toggle-off')
                            ->class($partenaireactivitetype->etat ? 'btn btn-success' : 'btn btn-secondary');
                    }),

                TD::make('Actions')
                    ->alignRight()
                    ->render(function (Partenaireactivitetype $partenaireactivitetype) {
                        return ModalToggle::make('Modifier')
                                ->modal('editPartenaireactivitetypeModal')
                                ->modalTitle('Modifier le type d\'activité du partenaire')
                                ->method('update')
                                ->asyncParameters([
                                    'partenaireactivitetype' => $partenaireactivitetype->id,
                                ])
                                ->icon('pencil')
                                ->class('btn btn-sm btn-warning')
                            . ' ' . 
                            Button::make('Supprimer')
                                ->confirm('Après la suppression, le type d\'activité du partenaire disparaîtra définitivement.')
                                ->method('delete', ['partenaireactivitetype' => $partenaireactivitetype->id])
                                ->icon('trash')
                                ->class('btn btn-sm btn-danger');
                    }),

            ]),

            Layout::modal('partenaireactivitetypeModal', Layout::rows([
                Input::make('partenaireactivitetype.titre')
                    ->title('Titre')
                    ->placeholder('Entrez le nom du type d\'activité du partenaire')
                    ->help('Le nom du type d\'activité du partenaire à créer.'),
            ]))
                ->title('Créer un type d\'activité du partenaire')
                ->applyButton('Ajouter un type d\'activité du partenaire'),


            Layout::modal('editPartenaireactivitetypeModal', Layout::rows([
                Input::make('partenaireactivitetype.id')->type('hidden'),

                Input::make('partenaireactivitetype.titre')
                    ->title('Titre')
                    ->required(),
            ]))
                ->async('asyncPartenaireactivitetype')
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
        // Validate form data, save partenaireactivitetype to database, etc.
        $request->validate([
            'partenaireactivitetype.titre' => 'required|max:255',
        ]);

        $partenaireactivitetype = new Partenaireactivitetype();
        $partenaireactivitetype->titre = $request->input('partenaireactivitetype.titre');
        $partenaireactivitetype->save();
    }

    /**
     * @param Partenaireactivitetype $partenaireactivitetype
     *
     * @return void
     */
    public function delete(Partenaireactivitetype $partenaireactivitetype)
    {
        $partenaireactivitetype->delete();
    }



    public function toggleEtat(Request $request)
    {
        $partenaireactivitetype = Partenaireactivitetype::findOrFail($request->input('partenaireactivitetype'));
        $partenaireactivitetype->etat = !$partenaireactivitetype->etat;
        $partenaireactivitetype->save();
    }

    public function update(Request $request)
    {
        $request->validate([
            'partenaireactivitetype.titre' => 'required|max:255',
        ]);

        $partenaireactivitetype = Partenaireactivitetype::findOrFail($request->input('partenaireactivitetype.id'));
        $partenaireactivitetype->titre = $request->input('partenaireactivitetype.titre');
        $partenaireactivitetype->save();
    }

}
