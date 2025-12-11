<?php

namespace App\Orchid\Screens\Parametres;

use Orchid\Screen\Screen;
use Orchid\Screen\Fields\Input;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Actions\ModalToggle;

use App\Models\Evenementtype;
use Illuminate\Http\Request;

use Orchid\Screen\TD;
use Orchid\Screen\Actions\Button;

use Illuminate\Support\Facades\Redirect; // si tu veux rediriger après

class EvenementtypeScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            'evenementtypes' => Evenementtype::latest()->paginate(20),
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Liste des types d\'évènements';
    }

    /**
     * Displays a description on the user's screen
     * directly under the heading.
     */
    public function description(): ?string
    {
        return "Paramètres";
    }

    public function asyncEvenementtype(Evenementtype $evenementtype): iterable
    {
        return [
            'evenementtype' => $evenementtype
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
            ModalToggle::make('Ajouter un type d\'évènement')
                ->modal('evenementtypeModal')
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
            Layout::table('evenementtypes', [
                TD::make('titre'),

                TD::make('etat', 'État')
                    ->render(function (Evenementtype $evenementtype) {
                        return Button::make($evenementtype->etat ? 'Désactiver' : 'Activer')
                            ->method('toggleEtat', [
                                'evenementtype' => $evenementtype->id,
                            ])
                            ->icon($evenementtype->etat ? 'toggle-on' : 'toggle-off')
                            ->class($evenementtype->etat ? 'btn btn-success' : 'btn btn-secondary');
                    }),

                TD::make('Actions')
                    ->alignRight()
                    ->render(function (Evenementtype $evenementtype) {
                        return ModalToggle::make('Modifier')
                                ->modal('editEvenementtypeModal')
                                ->modalTitle('Modifier le type d\'évènement')
                                ->method('update')
                                ->asyncParameters([
                                    'evenementtype' => $evenementtype->id,
                                ])
                                ->icon('pencil')
                                ->class('btn btn-sm btn-warning')
                            . ' ' . 
                            Button::make('Supprimer')
                                ->confirm('Après la suppression, le type d\'évènement disparaîtra définitivement.')
                                ->method('delete', ['evenementtype' => $evenementtype->id])
                                ->icon('trash')
                                ->class('btn btn-sm btn-danger');
                    }),

            ]),

            Layout::modal('evenementtypeModal', Layout::rows([
                Input::make('evenementtype.titre')
                    ->title('Titre')
                    ->placeholder('Entrez le nom du type d\'évènement')
                    ->help('Le nom du type d\'évènement à créer.'),
            ]))
                ->title('Créer un type d\'évènement')
                ->applyButton('Ajouter un type d\'évènement'),


            Layout::modal('editEvenementtypeModal', Layout::rows([
                Input::make('evenementtype.id')->type('hidden'),

                Input::make('evenementtype.titre')
                    ->title('Titre')
                    ->required(),
            ]))
                ->async('asyncEvenementtype')
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
        // Validate form data, save evenementtype to database, etc.
        $request->validate([
            'evenementtype.titre' => 'required|max:255',
        ]);

        $evenementtype = new Evenementtype();
        $evenementtype->titre = $request->input('evenementtype.titre');
        $evenementtype->save();
    }

    /**
     * @param Evenementtype $evenementtype
     *
     * @return void
     */
    public function delete(Evenementtype $evenementtype)
    {
        $evenementtype->delete();
    }



    public function toggleEtat(Request $request)
    {
        $evenementtype = Evenementtype::findOrFail($request->input('evenementtype'));
        $evenementtype->etat = !$evenementtype->etat;
        $evenementtype->save();
    }

    public function update(Request $request)
    {
        $request->validate([
            'evenementtype.titre' => 'required|max:255',
        ]);

        $evenementtype = Evenementtype::findOrFail($request->input('evenementtype.id'));
        $evenementtype->titre = $request->input('evenementtype.titre');
        $evenementtype->save();
    }

}
