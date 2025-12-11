<?php

namespace App\Orchid\Screens\Parametres;

use Orchid\Screen\Screen;
use Orchid\Screen\Fields\Input;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Actions\ModalToggle;

use App\Models\Recommandationtype;
use Illuminate\Http\Request;

use Orchid\Screen\TD;
use Orchid\Screen\Actions\Button;

use Illuminate\Support\Facades\Redirect; // si tu veux rediriger après

class RecommandationtypeScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            'recommandationtypes' => Recommandationtype::latest()->paginate(20),
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Liste des types de recommandations';
    }

    /**
     * Displays a description on the user's screen
     * directly under the heading.
     */
    public function description(): ?string
    {
        return "Paramètres";
    }

    public function asyncRecommandationtype(Recommandationtype $recommandationtype): iterable
    {
        return [
            'recommandationtype' => $recommandationtype
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
            ModalToggle::make('Ajouter un type de recommandation')
                ->modal('recommandationtypeModal')
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
            Layout::table('recommandationtypes', [
                TD::make('titre'),

                TD::make('etat', 'État')
                    ->render(function (Recommandationtype $recommandationtype) {
                        return Button::make($recommandationtype->etat ? 'Désactiver' : 'Activer')
                            ->method('toggleEtat', [
                                'recommandationtype' => $recommandationtype->id,
                            ])
                            ->icon($recommandationtype->etat ? 'toggle-on' : 'toggle-off')
                            ->class($recommandationtype->etat ? 'btn btn-success' : 'btn btn-secondary');
                    }),

                TD::make('Actions')
                    ->alignRight()
                    ->render(function (Recommandationtype $recommandationtype) {
                        return ModalToggle::make('Modifier')
                                ->modal('editRecommandationtypeModal')
                                ->modalTitle('Modifier le type de recommandation')
                                ->method('update')
                                ->asyncParameters([
                                    'recommandationtype' => $recommandationtype->id,
                                ])
                                ->icon('pencil')
                                ->class('btn btn-sm btn-warning')
                            . ' ' . 
                            Button::make('Supprimer')
                                ->confirm('Après la suppression, le type de recommandation disparaîtra définitivement.')
                                ->method('delete', ['recommandationtype' => $recommandationtype->id])
                                ->icon('trash')
                                ->class('btn btn-sm btn-danger');
                    }),

            ]),

            Layout::modal('recommandationtypeModal', Layout::rows([
                Input::make('recommandationtype.titre')
                    ->title('Titre')
                    ->placeholder('Entrez le nom du type de recommandation')
                    ->help('Le nom du type de recommandation à créer.'),
            ]))
                ->title('Créer un type de recommandation')
                ->applyButton('Ajouter un type de recommandation'),


            Layout::modal('editRecommandationtypeModal', Layout::rows([
                Input::make('recommandationtype.id')->type('hidden'),

                Input::make('recommandationtype.titre')
                    ->title('Titre')
                    ->required(),
            ]))
                ->async('asyncRecommandationtype')
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
        // Validate form data, save recommandationtype to database, etc.
        $request->validate([
            'recommandationtype.titre' => 'required|max:255',
        ]);

        $recommandationtype = new Recommandationtype();
        $recommandationtype->titre = $request->input('recommandationtype.titre');
        $recommandationtype->save();
    }

    /**
     * @param Recommandationtype $recommandationtype
     *
     * @return void
     */
    public function delete(Recommandationtype $recommandationtype)
    {
        $recommandationtype->delete();
    }



    public function toggleEtat(Request $request)
    {
        $recommandationtype = Recommandationtype::findOrFail($request->input('recommandationtype'));
        $recommandationtype->etat = !$recommandationtype->etat;
        $recommandationtype->save();
    }

    public function update(Request $request)
    {
        $request->validate([
            'recommandationtype.titre' => 'required|max:255',
        ]);

        $recommandationtype = Recommandationtype::findOrFail($request->input('recommandationtype.id'));
        $recommandationtype->titre = $request->input('recommandationtype.titre');
        $recommandationtype->save();
    }

}
