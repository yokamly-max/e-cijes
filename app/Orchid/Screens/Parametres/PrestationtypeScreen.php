<?php

namespace App\Orchid\Screens\Parametres;

use Orchid\Screen\Screen;
use Orchid\Screen\Fields\Input;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Actions\ModalToggle;

use App\Models\Prestationtype;
use Illuminate\Http\Request;

use Orchid\Screen\TD;
use Orchid\Screen\Actions\Button;

use Illuminate\Support\Facades\Redirect; // si tu veux rediriger après

class PrestationtypeScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            'prestationtypes' => Prestationtype::latest()->paginate(20),
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Liste des types de prestations';
    }

    /**
     * Displays a description on the user's screen
     * directly under the heading.
     */
    public function description(): ?string
    {
        return "Paramètres";
    }

    public function asyncPrestationtype(Prestationtype $prestationtype): iterable
    {
        return [
            'prestationtype' => $prestationtype
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
            ModalToggle::make('Ajouter un type de prestation')
                ->modal('prestationtypeModal')
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
            Layout::table('prestationtypes', [
                TD::make('titre'),

                TD::make('etat', 'État')
                    ->render(function (Prestationtype $prestationtype) {
                        return Button::make($prestationtype->etat ? 'Désactiver' : 'Activer')
                            ->method('toggleEtat', [
                                'prestationtype' => $prestationtype->id,
                            ])
                            ->icon($prestationtype->etat ? 'toggle-on' : 'toggle-off')
                            ->class($prestationtype->etat ? 'btn btn-success' : 'btn btn-secondary');
                    }),

                TD::make('Actions')
                    ->alignRight()
                    ->render(function (Prestationtype $prestationtype) {
                        return ModalToggle::make('Modifier')
                                ->modal('editPrestationtypeModal')
                                ->modalTitle('Modifier le type de prestation')
                                ->method('update')
                                ->asyncParameters([
                                    'prestationtype' => $prestationtype->id,
                                ])
                                ->icon('pencil')
                                ->class('btn btn-sm btn-warning')
                            . ' ' . 
                            Button::make('Supprimer')
                                ->confirm('Après la suppression, le type de prestation disparaîtra définitivement.')
                                ->method('delete', ['prestationtype' => $prestationtype->id])
                                ->icon('trash')
                                ->class('btn btn-sm btn-danger');
                    }),

            ]),

            Layout::modal('prestationtypeModal', Layout::rows([
                Input::make('prestationtype.titre')
                    ->title('Titre')
                    ->placeholder('Entrez le nom du type de prestation')
                    ->help('Le nom du type de prestation à créer.'),
            ]))
                ->title('Créer un type de prestation')
                ->applyButton('Ajouter un type de prestation'),


            Layout::modal('editPrestationtypeModal', Layout::rows([
                Input::make('prestationtype.id')->type('hidden'),

                Input::make('prestationtype.titre')
                    ->title('Titre')
                    ->required(),
            ]))
                ->async('asyncPrestationtype')
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
        // Validate form data, save prestationtype to database, etc.
        $request->validate([
            'prestationtype.titre' => 'required|max:255',
        ]);

        $prestationtype = new Prestationtype();
        $prestationtype->titre = $request->input('prestationtype.titre');
        $prestationtype->save();
    }

    /**
     * @param Prestationtype $prestationtype
     *
     * @return void
     */
    public function delete(Prestationtype $prestationtype)
    {
        $prestationtype->delete();
    }



    public function toggleEtat(Request $request)
    {
        $prestationtype = Prestationtype::findOrFail($request->input('prestationtype'));
        $prestationtype->etat = !$prestationtype->etat;
        $prestationtype->save();
    }

    public function update(Request $request)
    {
        $request->validate([
            'prestationtype.titre' => 'required|max:255',
        ]);

        $prestationtype = Prestationtype::findOrFail($request->input('prestationtype.id'));
        $prestationtype->titre = $request->input('prestationtype.titre');
        $prestationtype->save();
    }

}
