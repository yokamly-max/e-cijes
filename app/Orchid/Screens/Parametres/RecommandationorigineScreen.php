<?php

namespace App\Orchid\Screens\Parametres;

use Orchid\Screen\Screen;
use Orchid\Screen\Fields\Input;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Actions\ModalToggle;

use App\Models\Recommandationorigine;
use Illuminate\Http\Request;

use Orchid\Screen\TD;
use Orchid\Screen\Actions\Button;

use Illuminate\Support\Facades\Redirect; // si tu veux rediriger après

class RecommandationorigineScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            'recommandationorigines' => Recommandationorigine::latest()->paginate(20),
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Liste des origines des recommandations';
    }

    /**
     * Displays a description on the user's screen
     * directly under the heading.
     */
    public function description(): ?string
    {
        return "Paramètres";
    }

    public function asyncRecommandationorigine(Recommandationorigine $recommandationorigine): iterable
    {
        return [
            'recommandationorigine' => $recommandationorigine
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
            ModalToggle::make('Ajouter une origine de recommandation')
                ->modal('recommandationorigineModal')
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
            Layout::table('recommandationorigines', [
                TD::make('titre'),

                TD::make('etat', 'État')
                    ->render(function (Recommandationorigine $recommandationorigine) {
                        return Button::make($recommandationorigine->etat ? 'Désactiver' : 'Activer')
                            ->method('toggleEtat', [
                                'recommandationorigine' => $recommandationorigine->id,
                            ])
                            ->icon($recommandationorigine->etat ? 'toggle-on' : 'toggle-off')
                            ->class($recommandationorigine->etat ? 'btn btn-success' : 'btn btn-secondary');
                    }),

                TD::make('Actions')
                    ->alignRight()
                    ->render(function (Recommandationorigine $recommandationorigine) {
                        return ModalToggle::make('Modifier')
                                ->modal('editRecommandationorigineModal')
                                ->modalTitle('Modifier l\'origine de recommandation')
                                ->method('update')
                                ->asyncParameters([
                                    'recommandationorigine' => $recommandationorigine->id,
                                ])
                                ->icon('pencil')
                                ->class('btn btn-sm btn-warning')
                            . ' ' . 
                            Button::make('Supprimer')
                                ->confirm('Après la suppression, l\'origine de recommandation disparaîtra définitivement.')
                                ->method('delete', ['recommandationorigine' => $recommandationorigine->id])
                                ->icon('trash')
                                ->class('btn btn-sm btn-danger');
                    }),

            ]),

            Layout::modal('recommandationorigineModal', Layout::rows([
                Input::make('recommandationorigine.titre')
                    ->title('Titre')
                    ->placeholder('Entrez le nom d\'une origine de recommandation')
                    ->help('Le nom d\'une origine de recommandation à créer.'),
            ]))
                ->title('Créer une origine de recommandation')
                ->applyButton('Ajouter une origine de recommandation'),


            Layout::modal('editRecommandationorigineModal', Layout::rows([
                Input::make('recommandationorigine.id')->origine('hidden'),

                Input::make('recommandationorigine.titre')
                    ->title('Titre')
                    ->required(),
            ]))
                ->async('asyncRecommandationorigine')
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
        // Validate form data, save recommandationorigine to database, etc.
        $request->validate([
            'recommandationorigine.titre' => 'required|max:255',
        ]);

        $recommandationorigine = new Recommandationorigine();
        $recommandationorigine->titre = $request->input('recommandationorigine.titre');
        $recommandationorigine->save();
    }

    /**
     * @param Recommandationorigine $recommandationorigine
     *
     * @return void
     */
    public function delete(Recommandationorigine $recommandationorigine)
    {
        $recommandationorigine->delete();
    }



    public function toggleEtat(Request $request)
    {
        $recommandationorigine = Recommandationorigine::findOrFail($request->input('recommandationorigine'));
        $recommandationorigine->etat = !$recommandationorigine->etat;
        $recommandationorigine->save();
    }

    public function update(Request $request)
    {
        $request->validate([
            'recommandationorigine.titre' => 'required|max:255',
        ]);

        $recommandationorigine = Recommandationorigine::findOrFail($request->input('recommandationorigine.id'));
        $recommandationorigine->titre = $request->input('recommandationorigine.titre');
        $recommandationorigine->save();
    }

}
