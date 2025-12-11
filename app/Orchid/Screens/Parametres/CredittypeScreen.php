<?php

namespace App\Orchid\Screens\Parametres;

use Orchid\Screen\Screen;
use Orchid\Screen\Fields\Input;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Actions\ModalToggle;

use App\Models\Credittype;
use Illuminate\Http\Request;

use Orchid\Screen\TD;
use Orchid\Screen\Actions\Button;

use Illuminate\Support\Facades\Redirect; // si tu veux rediriger après

class CredittypeScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            'credittypes' => Credittype::latest()->paginate(20),
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Liste des types de credits';
    }

    /**
     * Displays a description on the user's screen
     * directly under the heading.
     */
    public function description(): ?string
    {
        return "Paramètres";
    }

    public function asyncCredittype(Credittype $credittype): iterable
    {
        return [
            'credittype' => $credittype
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
            ModalToggle::make('Ajouter un type de credit')
                ->modal('credittypeModal')
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
            Layout::table('credittypes', [
                TD::make('titre'),

                TD::make('etat', 'État')
                    ->render(function (Credittype $credittype) {
                        return Button::make($credittype->etat ? 'Désactiver' : 'Activer')
                            ->method('toggleEtat', [
                                'credittype' => $credittype->id,
                            ])
                            ->icon($credittype->etat ? 'toggle-on' : 'toggle-off')
                            ->class($credittype->etat ? 'btn btn-success' : 'btn btn-secondary');
                    }),

                TD::make('Actions')
                    ->alignRight()
                    ->render(function (Credittype $credittype) {
                        return ModalToggle::make('Modifier')
                                ->modal('editCredittypeModal')
                                ->modalTitle('Modifier le type de credit')
                                ->method('update')
                                ->asyncParameters([
                                    'credittype' => $credittype->id,
                                ])
                                ->icon('pencil')
                                ->class('btn btn-sm btn-warning')
                            . ' ' . 
                            Button::make('Supprimer')
                                ->confirm('Après la suppression, le type de credit disparaîtra définitivement.')
                                ->method('delete', ['credittype' => $credittype->id])
                                ->icon('trash')
                                ->class('btn btn-sm btn-danger');
                    }),

            ]),

            Layout::modal('credittypeModal', Layout::rows([
                Input::make('credittype.titre')
                    ->title('Titre')
                    ->placeholder('Entrez le nom du type de credit')
                    ->help('Le nom du type de credit à créer.'),
            ]))
                ->title('Créer un type de credit')
                ->applyButton('Ajouter un type de credit'),


            Layout::modal('editCredittypeModal', Layout::rows([
                Input::make('credittype.id')->type('hidden'),

                Input::make('credittype.titre')
                    ->title('Titre')
                    ->required(),
            ]))
                ->async('asyncCredittype')
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
        // Validate form data, save credittype to database, etc.
        $request->validate([
            'credittype.titre' => 'required|max:255',
        ]);

        $credittype = new Credittype();
        $credittype->titre = $request->input('credittype.titre');
        $credittype->save();
    }

    /**
     * @param Credittype $credittype
     *
     * @return void
     */
    public function delete(Credittype $credittype)
    {
        $credittype->delete();
    }



    public function toggleEtat(Request $request)
    {
        $credittype = Credittype::findOrFail($request->input('credittype'));
        $credittype->etat = !$credittype->etat;
        $credittype->save();
    }

    public function update(Request $request)
    {
        $request->validate([
            'credittype.titre' => 'required|max:255',
        ]);

        $credittype = Credittype::findOrFail($request->input('credittype.id'));
        $credittype->titre = $request->input('credittype.titre');
        $credittype->save();
    }

}
