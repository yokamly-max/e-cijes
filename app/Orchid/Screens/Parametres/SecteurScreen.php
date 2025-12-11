<?php

namespace App\Orchid\Screens\Parametres;

use Orchid\Screen\Screen;
use Orchid\Screen\Fields\Input;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Actions\ModalToggle;

use App\Models\Secteur;
use Illuminate\Http\Request;

use Orchid\Screen\TD;
use Orchid\Screen\Actions\Button;

use Illuminate\Support\Facades\Redirect; // si tu veux rediriger après

class SecteurScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            'secteurs' => Secteur::latest()->paginate(20),
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Liste des secteurs';
    }

    /**
     * Displays a description on the user's screen
     * directly under the heading.
     */
    public function description(): ?string
    {
        return "Paramètres";
    }

    public function asyncSecteur(Secteur $secteur): iterable
    {
        return [
            'secteur' => $secteur
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
            ModalToggle::make('Ajouter un secteur')
                ->modal('secteurModal')
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
            Layout::table('secteurs', [
                TD::make('titre'),

                TD::make('etat', 'État')
                    ->render(function (Secteur $secteur) {
                        return Button::make($secteur->etat ? 'Désactiver' : 'Activer')
                            ->method('toggleEtat', [
                                'secteur' => $secteur->id,
                            ])
                            ->icon($secteur->etat ? 'toggle-on' : 'toggle-off')
                            ->class($secteur->etat ? 'btn btn-success' : 'btn btn-secondary');
                    }),

                TD::make('Actions')
                    ->alignRight()
                    ->render(function (Secteur $secteur) {
                        return ModalToggle::make('Modifier')
                                ->modal('editSecteurModal')
                                ->modalTitle('Modifier le secteur')
                                ->method('update')
                                ->asyncParameters([
                                    'secteur' => $secteur->id,
                                ])
                                ->icon('pencil')
                                ->class('btn btn-sm btn-warning')
                            . ' ' . 
                            Button::make('Supprimer')
                                ->confirm('Après la suppression, le secteur disparaîtra définitivement.')
                                ->method('delete', ['secteur' => $secteur->id])
                                ->icon('trash')
                                ->class('btn btn-sm btn-danger');
                    }),

            ]),

            Layout::modal('secteurModal', Layout::rows([
                Input::make('secteur.titre')
                    ->title('Titre')
                    ->placeholder('Entrez le nom du secteur')
                    ->help('Le nom du secteur à créer.'),
            ]))
                ->title('Créer un secteur')
                ->applyButton('Ajouter un secteur'),


            Layout::modal('editSecteurModal', Layout::rows([
                Input::make('secteur.id')->type('hidden'),

                Input::make('secteur.titre')
                    ->title('Titre')
                    ->required(),
            ]))
                ->async('asyncSecteur')
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
        // Validate form data, save secteur to database, etc.
        $request->validate([
            'secteur.titre' => 'required|max:255',
        ]);

        $secteur = new Secteur();
        $secteur->titre = $request->input('secteur.titre');
        $secteur->save();
    }

    /**
     * @param Secteur $secteur
     *
     * @return void
     */
    public function delete(Secteur $secteur)
    {
        $secteur->delete();
    }



    public function toggleEtat(Request $request)
    {
        $secteur = Secteur::findOrFail($request->input('secteur'));
        $secteur->etat = !$secteur->etat;
        $secteur->save();
    }

    public function update(Request $request)
    {
        $request->validate([
            'secteur.titre' => 'required|max:255',
        ]);

        $secteur = Secteur::findOrFail($request->input('secteur.id'));
        $secteur->titre = $request->input('secteur.titre');
        $secteur->save();
    }

}
