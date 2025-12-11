<?php

namespace App\Orchid\Screens\Parametres;

use Orchid\Screen\Screen;
use Orchid\Screen\Fields\Input;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Actions\ModalToggle;

use App\Models\Alertetype;
use Illuminate\Http\Request;

use Orchid\Screen\TD;
use Orchid\Screen\Actions\Button;

use Illuminate\Support\Facades\Redirect; // si tu veux rediriger après

class AlertetypeScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            'alertetypes' => Alertetype::latest()->paginate(20),
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Liste des types d\'alertes';
    }

    /**
     * Displays a description on the user's screen
     * directly under the heading.
     */
    public function description(): ?string
    {
        return "Paramètres";
    }

    public function asyncAlertetype(Alertetype $alertetype): iterable
    {
        return [
            'alertetype' => $alertetype
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
            ModalToggle::make('Ajouter un type d\'alerte')
                ->modal('alertetypeModal')
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
            Layout::table('alertetypes', [
                TD::make('titre'),

                TD::make('etat', 'État')
                    ->render(function (Alertetype $alertetype) {
                        return Button::make($alertetype->etat ? 'Désactiver' : 'Activer')
                            ->method('toggleEtat', [
                                'alertetype' => $alertetype->id,
                            ])
                            ->icon($alertetype->etat ? 'toggle-on' : 'toggle-off')
                            ->class($alertetype->etat ? 'btn btn-success' : 'btn btn-secondary');
                    }),

                TD::make('Actions')
                    ->alignRight()
                    ->render(function (Alertetype $alertetype) {
                        return ModalToggle::make('Modifier')
                                ->modal('editAlertetypeModal')
                                ->modalTitle('Modifier le type d\'alerte')
                                ->method('update')
                                ->asyncParameters([
                                    'alertetype' => $alertetype->id,
                                ])
                                ->icon('pencil')
                                ->class('btn btn-sm btn-warning')
                            . ' ' . 
                            Button::make('Supprimer')
                                ->confirm('Après la suppression, le type d\'alerte disparaîtra définitivement.')
                                ->method('delete', ['alertetype' => $alertetype->id])
                                ->icon('trash')
                                ->class('btn btn-sm btn-danger');
                    }),

            ]),

            Layout::modal('alertetypeModal', Layout::rows([
                Input::make('alertetype.titre')
                    ->title('Titre')
                    ->placeholder('Entrez le nom du type d\'alerte')
                    ->help('Le nom du type d\'alerte à créer.'),
            ]))
                ->title('Créer un type d\'alerte')
                ->applyButton('Ajouter un type d\'alerte'),


            Layout::modal('editAlertetypeModal', Layout::rows([
                Input::make('alertetype.id')->type('hidden'),

                Input::make('alertetype.titre')
                    ->title('Titre')
                    ->required(),
            ]))
                ->async('asyncAlertetype')
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
        // Validate form data, save alertetype to database, etc.
        $request->validate([
            'alertetype.titre' => 'required|max:255',
        ]);

        $alertetype = new Alertetype();
        $alertetype->titre = $request->input('alertetype.titre');
        $alertetype->save();
    }

    /**
     * @param Alertetype $alertetype
     *
     * @return void
     */
    public function delete(Alertetype $alertetype)
    {
        $alertetype->delete();
    }



    public function toggleEtat(Request $request)
    {
        $alertetype = Alertetype::findOrFail($request->input('alertetype'));
        $alertetype->etat = !$alertetype->etat;
        $alertetype->save();
    }

    public function update(Request $request)
    {
        $request->validate([
            'alertetype.titre' => 'required|max:255',
        ]);

        $alertetype = Alertetype::findOrFail($request->input('alertetype.id'));
        $alertetype->titre = $request->input('alertetype.titre');
        $alertetype->save();
    }

}
