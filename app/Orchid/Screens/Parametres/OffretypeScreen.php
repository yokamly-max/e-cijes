<?php

namespace App\Orchid\Screens\Parametres;

use Orchid\Screen\Screen;
use Orchid\Screen\Fields\Input;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Actions\ModalToggle;

use App\Models\Offretype;
use Illuminate\Http\Request;

use Orchid\Screen\TD;
use Orchid\Screen\Actions\Button;

use Illuminate\Support\Facades\Redirect; // si tu veux rediriger après

class OffretypeScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            'offretypes' => Offretype::latest()->paginate(20),
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Liste des types de offres';
    }

    /**
     * Displays a description on the user's screen
     * directly under the heading.
     */
    public function description(): ?string
    {
        return "Paramètres";
    }

    public function asyncOffretype(Offretype $offretype): iterable
    {
        return [
            'offretype' => $offretype
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
            ModalToggle::make('Ajouter un type de offre')
                ->modal('offretypeModal')
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
            Layout::table('offretypes', [
                TD::make('titre'),

                TD::make('etat', 'État')
                    ->render(function (Offretype $offretype) {
                        return Button::make($offretype->etat ? 'Désactiver' : 'Activer')
                            ->method('toggleEtat', [
                                'offretype' => $offretype->id,
                            ])
                            ->icon($offretype->etat ? 'toggle-on' : 'toggle-off')
                            ->class($offretype->etat ? 'btn btn-success' : 'btn btn-secondary');
                    }),

                TD::make('Actions')
                    ->alignRight()
                    ->render(function (Offretype $offretype) {
                        return ModalToggle::make('Modifier')
                                ->modal('editOffretypeModal')
                                ->modalTitle('Modifier le type de offre')
                                ->method('update')
                                ->asyncParameters([
                                    'offretype' => $offretype->id,
                                ])
                                ->icon('pencil')
                                ->class('btn btn-sm btn-warning')
                            . ' ' . 
                            Button::make('Supprimer')
                                ->confirm('Après la suppression, le type de offre disparaîtra définitivement.')
                                ->method('delete', ['offretype' => $offretype->id])
                                ->icon('trash')
                                ->class('btn btn-sm btn-danger');
                    }),

            ]),

            Layout::modal('offretypeModal', Layout::rows([
                Input::make('offretype.titre')
                    ->title('Titre')
                    ->placeholder('Entrez le nom du type de offre')
                    ->help('Le nom du type de offre à créer.'),
            ]))
                ->title('Créer un type de offre')
                ->applyButton('Ajouter un type de offre'),


            Layout::modal('editOffretypeModal', Layout::rows([
                Input::make('offretype.id')->type('hidden'),

                Input::make('offretype.titre')
                    ->title('Titre')
                    ->required(),
            ]))
                ->async('asyncOffretype')
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
        // Validate form data, save offretype to database, etc.
        $request->validate([
            'offretype.titre' => 'required|max:255',
        ]);

        $offretype = new Offretype();
        $offretype->titre = $request->input('offretype.titre');
        $offretype->save();
    }

    /**
     * @param Offretype $offretype
     *
     * @return void
     */
    public function delete(Offretype $offretype)
    {
        $offretype->delete();
    }



    public function toggleEtat(Request $request)
    {
        $offretype = Offretype::findOrFail($request->input('offretype'));
        $offretype->etat = !$offretype->etat;
        $offretype->save();
    }

    public function update(Request $request)
    {
        $request->validate([
            'offretype.titre' => 'required|max:255',
        ]);

        $offretype = Offretype::findOrFail($request->input('offretype.id'));
        $offretype->titre = $request->input('offretype.titre');
        $offretype->save();
    }

}
