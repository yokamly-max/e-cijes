<?php

namespace App\Orchid\Screens\Parametres;

use Orchid\Screen\Screen;
use Orchid\Screen\Fields\Input;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Actions\ModalToggle;

use App\Models\Bontype;
use Illuminate\Http\Request;

use Orchid\Screen\TD;
use Orchid\Screen\Actions\Button;

use Illuminate\Support\Facades\Redirect; // si tu veux rediriger après

class BontypeScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            'bontypes' => Bontype::latest()->paginate(20),
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Liste des types de bons';
    }

    /**
     * Displays a description on the user's screen
     * directly under the heading.
     */
    public function description(): ?string
    {
        return "Paramètres";
    }

    public function asyncBontype(Bontype $bontype): iterable
    {
        return [
            'bontype' => $bontype
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
            ModalToggle::make('Ajouter un type de bon')
                ->modal('bontypeModal')
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
            Layout::table('bontypes', [
                TD::make('titre'),

                TD::make('etat', 'État')
                    ->render(function (Bontype $bontype) {
                        return Button::make($bontype->etat ? 'Désactiver' : 'Activer')
                            ->method('toggleEtat', [
                                'bontype' => $bontype->id,
                            ])
                            ->icon($bontype->etat ? 'toggle-on' : 'toggle-off')
                            ->class($bontype->etat ? 'btn btn-success' : 'btn btn-secondary');
                    }),

                TD::make('Actions')
                    ->alignRight()
                    ->render(function (Bontype $bontype) {
                        return ModalToggle::make('Modifier')
                                ->modal('editBontypeModal')
                                ->modalTitle('Modifier le type de bon')
                                ->method('update')
                                ->asyncParameters([
                                    'bontype' => $bontype->id,
                                ])
                                ->icon('pencil')
                                ->class('btn btn-sm btn-warning')
                            . ' ' . 
                            Button::make('Supprimer')
                                ->confirm('Après la suppression, le type de bon disparaîtra définitivement.')
                                ->method('delete', ['bontype' => $bontype->id])
                                ->icon('trash')
                                ->class('btn btn-sm btn-danger');
                    }),

            ]),

            Layout::modal('bontypeModal', Layout::rows([
                Input::make('bontype.titre')
                    ->title('Titre')
                    ->placeholder('Entrez le nom du type de bon')
                    ->help('Le nom du type de bon à créer.'),
            ]))
                ->title('Créer un type de bon')
                ->applyButton('Ajouter un type de bon'),


            Layout::modal('editBontypeModal', Layout::rows([
                Input::make('bontype.id')->type('hidden'),

                Input::make('bontype.titre')
                    ->title('Titre')
                    ->required(),
            ]))
                ->async('asyncBontype')
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
        // Validate form data, save bontype to database, etc.
        $request->validate([
            'bontype.titre' => 'required|max:255',
        ]);

        $bontype = new Bontype();
        $bontype->titre = $request->input('bontype.titre');
        $bontype->save();
    }

    /**
     * @param Bontype $bontype
     *
     * @return void
     */
    public function delete(Bontype $bontype)
    {
        $bontype->delete();
    }



    public function toggleEtat(Request $request)
    {
        $bontype = Bontype::findOrFail($request->input('bontype'));
        $bontype->etat = !$bontype->etat;
        $bontype->save();
    }

    public function update(Request $request)
    {
        $request->validate([
            'bontype.titre' => 'required|max:255',
        ]);

        $bontype = Bontype::findOrFail($request->input('bontype.id'));
        $bontype->titre = $request->input('bontype.titre');
        $bontype->save();
    }

}
