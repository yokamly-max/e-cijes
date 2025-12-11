<?php

namespace App\Orchid\Screens\Parametres;

use Orchid\Screen\Screen;
use Orchid\Screen\Fields\Input;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Actions\ModalToggle;

use App\Models\Espacetype;
use Illuminate\Http\Request;

use Orchid\Screen\TD;
use Orchid\Screen\Actions\Button;

use Illuminate\Support\Facades\Redirect; // si tu veux rediriger après

class EspacetypeScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            'espacetypes' => Espacetype::latest()->paginate(20),
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Liste des types d\'espaces';
    }

    /**
     * Displays a description on the user's screen
     * directly under the heading.
     */
    public function description(): ?string
    {
        return "Paramètres";
    }

    public function asyncEspacetype(Espacetype $espacetype): iterable
    {
        return [
            'espacetype' => $espacetype
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
            ModalToggle::make('Ajouter un type d\'espace')
                ->modal('espacetypeModal')
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
            Layout::table('espacetypes', [
                TD::make('titre'),

                TD::make('etat', 'État')
                    ->render(function (Espacetype $espacetype) {
                        return Button::make($espacetype->etat ? 'Désactiver' : 'Activer')
                            ->method('toggleEtat', [
                                'espacetype' => $espacetype->id,
                            ])
                            ->icon($espacetype->etat ? 'toggle-on' : 'toggle-off')
                            ->class($espacetype->etat ? 'btn btn-success' : 'btn btn-secondary');
                    }),

                TD::make('Actions')
                    ->alignRight()
                    ->render(function (Espacetype $espacetype) {
                        return ModalToggle::make('Modifier')
                                ->modal('editEspacetypeModal')
                                ->modalTitle('Modifier le type d\'espace')
                                ->method('update')
                                ->asyncParameters([
                                    'espacetype' => $espacetype->id,
                                ])
                                ->icon('pencil')
                                ->class('btn btn-sm btn-warning')
                            . ' ' . 
                            Button::make('Supprimer')
                                ->confirm('Après la suppression, le type d\'espace disparaîtra définitivement.')
                                ->method('delete', ['espacetype' => $espacetype->id])
                                ->icon('trash')
                                ->class('btn btn-sm btn-danger');
                    }),

            ]),

            Layout::modal('espacetypeModal', Layout::rows([
                Input::make('espacetype.titre')
                    ->title('Titre')
                    ->placeholder('Entrez le nom du type d\'espace')
                    ->help('Le nom du type d\'espace à créer.'),
            ]))
                ->title('Créer un type d\'espace')
                ->applyButton('Ajouter un type d\'espace'),


            Layout::modal('editEspacetypeModal', Layout::rows([
                Input::make('espacetype.id')->type('hidden'),

                Input::make('espacetype.titre')
                    ->title('Titre')
                    ->required(),
            ]))
                ->async('asyncEspacetype')
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
        // Validate form data, save espacetype to database, etc.
        $request->validate([
            'espacetype.titre' => 'required|max:255',
        ]);

        $espacetype = new Espacetype();
        $espacetype->titre = $request->input('espacetype.titre');
        $espacetype->save();
    }

    /**
     * @param Espacetype $espacetype
     *
     * @return void
     */
    public function delete(Espacetype $espacetype)
    {
        $espacetype->delete();
    }



    public function toggleEtat(Request $request)
    {
        $espacetype = Espacetype::findOrFail($request->input('espacetype'));
        $espacetype->etat = !$espacetype->etat;
        $espacetype->save();
    }

    public function update(Request $request)
    {
        $request->validate([
            'espacetype.titre' => 'required|max:255',
        ]);

        $espacetype = Espacetype::findOrFail($request->input('espacetype.id'));
        $espacetype->titre = $request->input('espacetype.titre');
        $espacetype->save();
    }

}
