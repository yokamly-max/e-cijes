<?php

namespace App\Orchid\Screens\Parametres;

use Orchid\Screen\Screen;
use Orchid\Screen\Fields\Input;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Actions\ModalToggle;

use App\Models\Conseillertype;
use Illuminate\Http\Request;

use Orchid\Screen\TD;
use Orchid\Screen\Actions\Button;

use Illuminate\Support\Facades\Redirect; // si tu veux rediriger après

class ConseillertypeScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            'conseillertypes' => Conseillertype::latest()->paginate(20),
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Liste des types de conseillers';
    }

    /**
     * Displays a description on the user's screen
     * directly under the heading.
     */
    public function description(): ?string
    {
        return "Paramètres";
    }

    public function asyncConseillertype(Conseillertype $conseillertype): iterable
    {
        return [
            'conseillertype' => $conseillertype
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
            ModalToggle::make('Ajouter un type de conseiller')
                ->modal('conseillertypeModal')
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
            Layout::table('conseillertypes', [
                TD::make('titre'),

                TD::make('etat', 'État')
                    ->render(function (Conseillertype $conseillertype) {
                        return Button::make($conseillertype->etat ? 'Désactiver' : 'Activer')
                            ->method('toggleEtat', [
                                'conseillertype' => $conseillertype->id,
                            ])
                            ->icon($conseillertype->etat ? 'toggle-on' : 'toggle-off')
                            ->class($conseillertype->etat ? 'btn btn-success' : 'btn btn-secondary');
                    }),

                TD::make('Actions')
                    ->alignRight()
                    ->render(function (Conseillertype $conseillertype) {
                        return ModalToggle::make('Modifier')
                                ->modal('editConseillertypeModal')
                                ->modalTitle('Modifier le type de conseiller')
                                ->method('update')
                                ->asyncParameters([
                                    'conseillertype' => $conseillertype->id,
                                ])
                                ->icon('pencil')
                                ->class('btn btn-sm btn-warning')
                            . ' ' . 
                            Button::make('Supprimer')
                                ->confirm('Après la suppression, le type de conseiller disparaîtra définitivement.')
                                ->method('delete', ['conseillertype' => $conseillertype->id])
                                ->icon('trash')
                                ->class('btn btn-sm btn-danger');
                    }),

            ]),

            Layout::modal('conseillertypeModal', Layout::rows([
                Input::make('conseillertype.titre')
                    ->title('Titre')
                    ->placeholder('Entrez le nom du type de conseiller')
                    ->help('Le nom du type de conseiller à créer.'),
            ]))
                ->title('Créer un type de conseiller')
                ->applyButton('Ajouter un type de conseiller'),


            Layout::modal('editConseillertypeModal', Layout::rows([
                Input::make('conseillertype.id')->type('hidden'),

                Input::make('conseillertype.titre')
                    ->title('Titre')
                    ->required(),
            ]))
                ->async('asyncConseillertype')
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
        // Validate form data, save conseillertype to database, etc.
        $request->validate([
            'conseillertype.titre' => 'required|max:255',
        ]);

        $conseillertype = new Conseillertype();
        $conseillertype->titre = $request->input('conseillertype.titre');
        $conseillertype->save();
    }

    /**
     * @param Conseillertype $conseillertype
     *
     * @return void
     */
    public function delete(Conseillertype $conseillertype)
    {
        $conseillertype->delete();
    }



    public function toggleEtat(Request $request)
    {
        $conseillertype = Conseillertype::findOrFail($request->input('conseillertype'));
        $conseillertype->etat = !$conseillertype->etat;
        $conseillertype->save();
    }

    public function update(Request $request)
    {
        $request->validate([
            'conseillertype.titre' => 'required|max:255',
        ]);

        $conseillertype = Conseillertype::findOrFail($request->input('conseillertype.id'));
        $conseillertype->titre = $request->input('conseillertype.titre');
        $conseillertype->save();
    }

}
