<?php

namespace App\Orchid\Screens\Parametres;

use Orchid\Screen\Screen;
use Orchid\Screen\Fields\Input;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Actions\ModalToggle;

use App\Models\Jour;
use Illuminate\Http\Request;

use Orchid\Screen\TD;
use Orchid\Screen\Actions\Button;

use Illuminate\Support\Facades\Redirect; // si tu veux rediriger après

class JourScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            'jours' => Jour::latest()->paginate(20),
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Liste des jours';
    }

    /**
     * Displays a description on the user's screen
     * directly under the heading.
     */
    public function description(): ?string
    {
        return "Paramètres";
    }

    public function asyncJour(Jour $jour): iterable
    {
        return [
            'jour' => $jour
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
            ModalToggle::make('Ajouter un jour')
                ->modal('jourModal')
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
            Layout::table('jours', [
                TD::make('titre'),

                TD::make('etat', 'État')
                    ->render(function (Jour $jour) {
                        return Button::make($jour->etat ? 'Désactiver' : 'Activer')
                            ->method('toggleEtat', [
                                'jour' => $jour->id,
                            ])
                            ->icon($jour->etat ? 'toggle-on' : 'toggle-off')
                            ->class($jour->etat ? 'btn btn-success' : 'btn btn-secondary');
                    }),

                TD::make('Actions')
                    ->alignRight()
                    ->render(function (Jour $jour) {
                        return ModalToggle::make('Modifier')
                                ->modal('editJourModal')
                                ->modalTitle('Modifier le jour')
                                ->method('update')
                                ->asyncParameters([
                                    'jour' => $jour->id,
                                ])
                                ->icon('pencil')
                                ->class('btn btn-sm btn-warning')
                            . ' ' . 
                            Button::make('Supprimer')
                                ->confirm('Après la suppression, le jour disparaîtra définitivement.')
                                ->method('delete', ['jour' => $jour->id])
                                ->icon('trash')
                                ->class('btn btn-sm btn-danger');
                    }),

            ]),

            Layout::modal('jourModal', Layout::rows([
                Input::make('jour.titre')
                    ->title('Titre')
                    ->placeholder('Entrez le nom du jour')
                    ->help('Le nom du jour à créer.'),
            ]))
                ->title('Créer un jour')
                ->applyButton('Ajouter un jour'),


            Layout::modal('editJourModal', Layout::rows([
                Input::make('jour.id')->type('hidden'),

                Input::make('jour.titre')
                    ->title('Titre')
                    ->required(),
            ]))
                ->async('asyncJour')
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
        // Validate form data, save jour to database, etc.
        $request->validate([
            'jour.titre' => 'required|max:255',
        ]);

        $jour = new Jour();
        $jour->titre = $request->input('jour.titre');
        $jour->save();
    }

    /**
     * @param Jour $jour
     *
     * @return void
     */
    public function delete(Jour $jour)
    {
        $jour->delete();
    }



    public function toggleEtat(Request $request)
    {
        $jour = Jour::findOrFail($request->input('jour'));
        $jour->etat = !$jour->etat;
        $jour->save();
    }

    public function update(Request $request)
    {
        $request->validate([
            'jour.titre' => 'required|max:255',
        ]);

        $jour = Jour::findOrFail($request->input('jour.id'));
        $jour->titre = $request->input('jour.titre');
        $jour->save();
    }

}
