<?php

namespace App\Orchid\Screens\Parametres;

use Orchid\Screen\Screen;
use Orchid\Screen\Fields\Input;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Actions\ModalToggle;

use App\Models\Veilletype;
use Illuminate\Http\Request;

use Orchid\Screen\TD;
use Orchid\Screen\Actions\Button;

use Illuminate\Support\Facades\Redirect; // si tu veux rediriger après

class VeilletypeScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            'veilletypes' => Veilletype::latest()->paginate(20),
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Liste des types de veilles';
    }

    /**
     * Displays a description on the user's screen
     * directly under the heading.
     */
    public function description(): ?string
    {
        return "Paramètres";
    }

    public function asyncVeilletype(Veilletype $veilletype): iterable
    {
        return [
            'veilletype' => $veilletype
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
            ModalToggle::make('Ajouter un type de veille')
                ->modal('veilletypeModal')
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
            Layout::table('veilletypes', [
                TD::make('titre'),

                TD::make('etat', 'État')
                    ->render(function (Veilletype $veilletype) {
                        return Button::make($veilletype->etat ? 'Désactiver' : 'Activer')
                            ->method('toggleEtat', [
                                'veilletype' => $veilletype->id,
                            ])
                            ->icon($veilletype->etat ? 'toggle-on' : 'toggle-off')
                            ->class($veilletype->etat ? 'btn btn-success' : 'btn btn-secondary');
                    }),

                TD::make('Actions')
                    ->alignRight()
                    ->render(function (Veilletype $veilletype) {
                        return ModalToggle::make('Modifier')
                                ->modal('editVeilletypeModal')
                                ->modalTitle('Modifier le type de veille')
                                ->method('update')
                                ->asyncParameters([
                                    'veilletype' => $veilletype->id,
                                ])
                                ->icon('pencil')
                                ->class('btn btn-sm btn-warning')
                            . ' ' . 
                            Button::make('Supprimer')
                                ->confirm('Après la suppression, le type de veille disparaîtra définitivement.')
                                ->method('delete', ['veilletype' => $veilletype->id])
                                ->icon('trash')
                                ->class('btn btn-sm btn-danger');
                    }),

            ]),

            Layout::modal('veilletypeModal', Layout::rows([
                Input::make('veilletype.titre')
                    ->title('Titre')
                    ->placeholder('Entrez le nom du type de veille')
                    ->help('Le nom du type de veille à créer.'),
            ]))
                ->title('Créer un type de veille')
                ->applyButton('Ajouter un type de veille'),


            Layout::modal('editVeilletypeModal', Layout::rows([
                Input::make('veilletype.id')->type('hidden'),

                Input::make('veilletype.titre')
                    ->title('Titre')
                    ->required(),
            ]))
                ->async('asyncVeilletype')
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
        // Validate form data, save veilletype to database, etc.
        $request->validate([
            'veilletype.titre' => 'required|max:255',
        ]);

        $veilletype = new Veilletype();
        $veilletype->titre = $request->input('veilletype.titre');
        $veilletype->save();
    }

    /**
     * @param Veilletype $veilletype
     *
     * @return void
     */
    public function delete(Veilletype $veilletype)
    {
        $veilletype->delete();
    }



    public function toggleEtat(Request $request)
    {
        $veilletype = Veilletype::findOrFail($request->input('veilletype'));
        $veilletype->etat = !$veilletype->etat;
        $veilletype->save();
    }

    public function update(Request $request)
    {
        $request->validate([
            'veilletype.titre' => 'required|max:255',
        ]);

        $veilletype = Veilletype::findOrFail($request->input('veilletype.id'));
        $veilletype->titre = $request->input('veilletype.titre');
        $veilletype->save();
    }

}
