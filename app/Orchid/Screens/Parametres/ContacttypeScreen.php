<?php

namespace App\Orchid\Screens\Parametres;

use Orchid\Screen\Screen;
use Orchid\Screen\Fields\Input;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Actions\ModalToggle;

use App\Models\Contacttype;
use Illuminate\Http\Request;

use Orchid\Screen\TD;
use Orchid\Screen\Actions\Button;

use Illuminate\Support\Facades\Redirect; // si tu veux rediriger après

class ContacttypeScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            'contacttypes' => Contacttype::latest()->paginate(20),
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Liste des types de contacts';
    }

    /**
     * Displays a description on the user's screen
     * directly under the heading.
     */
    public function description(): ?string
    {
        return "Paramètres";
    }

    public function asyncContacttype(Contacttype $contacttype): iterable
    {
        return [
            'contacttype' => $contacttype
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
            ModalToggle::make('Ajouter un type de contact')
                ->modal('contacttypeModal')
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
            Layout::table('contacttypes', [
                TD::make('titre'),

                TD::make('etat', 'État')
                    ->render(function (Contacttype $contacttype) {
                        return Button::make($contacttype->etat ? 'Désactiver' : 'Activer')
                            ->method('toggleEtat', [
                                'contacttype' => $contacttype->id,
                            ])
                            ->icon($contacttype->etat ? 'toggle-on' : 'toggle-off')
                            ->class($contacttype->etat ? 'btn btn-success' : 'btn btn-secondary');
                    }),

                TD::make('Actions')
                    ->alignRight()
                    ->render(function (Contacttype $contacttype) {
                        return ModalToggle::make('Modifier')
                                ->modal('editContacttypeModal')
                                ->modalTitle('Modifier le type de contact')
                                ->method('update')
                                ->asyncParameters([
                                    'contacttype' => $contacttype->id,
                                ])
                                ->icon('pencil')
                                ->class('btn btn-sm btn-warning')
                            . ' ' . 
                            Button::make('Supprimer')
                                ->confirm('Après la suppression, le type de contact disparaîtra définitivement.')
                                ->method('delete', ['contacttype' => $contacttype->id])
                                ->icon('trash')
                                ->class('btn btn-sm btn-danger');
                    }),

            ]),

            Layout::modal('contacttypeModal', Layout::rows([
                Input::make('contacttype.titre')
                    ->title('Titre')
                    ->placeholder('Entrez le nom du type de contact')
                    ->help('Le nom du type de contact à créer.'),
            ]))
                ->title('Créer un type de contact')
                ->applyButton('Ajouter un type de contact'),


            Layout::modal('editContacttypeModal', Layout::rows([
                Input::make('contacttype.id')->type('hidden'),

                Input::make('contacttype.titre')
                    ->title('Titre')
                    ->required(),
            ]))
                ->async('asyncContacttype')
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
        // Validate form data, save contacttype to database, etc.
        $request->validate([
            'contacttype.titre' => 'required|max:255',
        ]);

        $contacttype = new Contacttype();
        $contacttype->titre = $request->input('contacttype.titre');
        $contacttype->save();
    }

    /**
     * @param Contacttype $contacttype
     *
     * @return void
     */
    public function delete(Contacttype $contacttype)
    {
        $contacttype->delete();
    }



    public function toggleEtat(Request $request)
    {
        $contacttype = Contacttype::findOrFail($request->input('contacttype'));
        $contacttype->etat = !$contacttype->etat;
        $contacttype->save();
    }

    public function update(Request $request)
    {
        $request->validate([
            'contacttype.titre' => 'required|max:255',
        ]);

        $contacttype = Contacttype::findOrFail($request->input('contacttype.id'));
        $contacttype->titre = $request->input('contacttype.titre');
        $contacttype->save();
    }

}
