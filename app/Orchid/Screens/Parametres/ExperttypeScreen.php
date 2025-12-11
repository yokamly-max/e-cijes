<?php

namespace App\Orchid\Screens\Parametres;

use Orchid\Screen\Screen;
use Orchid\Screen\Fields\Input;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Actions\ModalToggle;

use App\Models\Experttype;
use Illuminate\Http\Request;

use Orchid\Screen\TD;
use Orchid\Screen\Actions\Button;

use Illuminate\Support\Facades\Redirect; // si tu veux rediriger après

class ExperttypeScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            'experttypes' => Experttype::latest()->paginate(20),
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Liste des types d\'experts';
    }

    /**
     * Displays a description on the user's screen
     * directly under the heading.
     */
    public function description(): ?string
    {
        return "Paramètres";
    }

    public function asyncExperttype(Experttype $experttype): iterable
    {
        return [
            'experttype' => $experttype
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
            ModalToggle::make('Ajouter un type d\'expert')
                ->modal('experttypeModal')
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
            Layout::table('experttypes', [
                TD::make('titre'),

                TD::make('etat', 'État')
                    ->render(function (Experttype $experttype) {
                        return Button::make($experttype->etat ? 'Désactiver' : 'Activer')
                            ->method('toggleEtat', [
                                'experttype' => $experttype->id,
                            ])
                            ->icon($experttype->etat ? 'toggle-on' : 'toggle-off')
                            ->class($experttype->etat ? 'btn btn-success' : 'btn btn-secondary');
                    }),

                TD::make('Actions')
                    ->alignRight()
                    ->render(function (Experttype $experttype) {
                        return ModalToggle::make('Modifier')
                                ->modal('editExperttypeModal')
                                ->modalTitle('Modifier le type d\'expert')
                                ->method('update')
                                ->asyncParameters([
                                    'experttype' => $experttype->id,
                                ])
                                ->icon('pencil')
                                ->class('btn btn-sm btn-warning')
                            . ' ' . 
                            Button::make('Supprimer')
                                ->confirm('Après la suppression, le type d\'expert disparaîtra définitivement.')
                                ->method('delete', ['experttype' => $experttype->id])
                                ->icon('trash')
                                ->class('btn btn-sm btn-danger');
                    }),

            ]),

            Layout::modal('experttypeModal', Layout::rows([
                Input::make('experttype.titre')
                    ->title('Titre')
                    ->placeholder('Entrez le nom du type d\'expert')
                    ->help('Le nom du type d\'expert à créer.'),
            ]))
                ->title('Créer un type d\'expert')
                ->applyButton('Ajouter un type d\'expert'),


            Layout::modal('editExperttypeModal', Layout::rows([
                Input::make('experttype.id')->type('hidden'),

                Input::make('experttype.titre')
                    ->title('Titre')
                    ->required(),
            ]))
                ->async('asyncExperttype')
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
        // Validate form data, save experttype to database, etc.
        $request->validate([
            'experttype.titre' => 'required|max:255',
        ]);

        $experttype = new Experttype();
        $experttype->titre = $request->input('experttype.titre');
        $experttype->save();
    }

    /**
     * @param Experttype $experttype
     *
     * @return void
     */
    public function delete(Experttype $experttype)
    {
        $experttype->delete();
    }



    public function toggleEtat(Request $request)
    {
        $experttype = Experttype::findOrFail($request->input('experttype'));
        $experttype->etat = !$experttype->etat;
        $experttype->save();
    }

    public function update(Request $request)
    {
        $request->validate([
            'experttype.titre' => 'required|max:255',
        ]);

        $experttype = Experttype::findOrFail($request->input('experttype.id'));
        $experttype->titre = $request->input('experttype.titre');
        $experttype->save();
    }

}
