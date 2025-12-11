<?php

namespace App\Orchid\Screens\Parametres;

use Orchid\Screen\Screen;
use Orchid\Screen\Fields\Input;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Actions\ModalToggle;

use App\Models\Forumtype;
use Illuminate\Http\Request;

use Orchid\Screen\TD;
use Orchid\Screen\Actions\Button;

use Illuminate\Support\Facades\Redirect; // si tu veux rediriger après

class ForumtypeScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            'forumtypes' => Forumtype::latest()->paginate(20),
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Liste des types de forums';
    }

    /**
     * Displays a description on the user's screen
     * directly under the heading.
     */
    public function description(): ?string
    {
        return "Paramètres";
    }

    public function asyncForumtype(Forumtype $forumtype): iterable
    {
        return [
            'forumtype' => $forumtype
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
            ModalToggle::make('Ajouter un type de forum')
                ->modal('forumtypeModal')
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
            Layout::table('forumtypes', [
                TD::make('titre'),

                TD::make('etat', 'État')
                    ->render(function (Forumtype $forumtype) {
                        return Button::make($forumtype->etat ? 'Désactiver' : 'Activer')
                            ->method('toggleEtat', [
                                'forumtype' => $forumtype->id,
                            ])
                            ->icon($forumtype->etat ? 'toggle-on' : 'toggle-off')
                            ->class($forumtype->etat ? 'btn btn-success' : 'btn btn-secondary');
                    }),

                TD::make('Actions')
                    ->alignRight()
                    ->render(function (Forumtype $forumtype) {
                        return ModalToggle::make('Modifier')
                                ->modal('editForumtypeModal')
                                ->modalTitle('Modifier le type de forum')
                                ->method('update')
                                ->asyncParameters([
                                    'forumtype' => $forumtype->id,
                                ])
                                ->icon('pencil')
                                ->class('btn btn-sm btn-warning')
                            . ' ' . 
                            Button::make('Supprimer')
                                ->confirm('Après la suppression, le type de forum disparaîtra définitivement.')
                                ->method('delete', ['forumtype' => $forumtype->id])
                                ->icon('trash')
                                ->class('btn btn-sm btn-danger');
                    }),

            ]),

            Layout::modal('forumtypeModal', Layout::rows([
                Input::make('forumtype.titre')
                    ->title('Titre')
                    ->placeholder('Entrez le nom du type de forum')
                    ->help('Le nom du type de forum à créer.'),
            ]))
                ->title('Créer un type de forum')
                ->applyButton('Ajouter un type de forum'),


            Layout::modal('editForumtypeModal', Layout::rows([
                Input::make('forumtype.id')->type('hidden'),

                Input::make('forumtype.titre')
                    ->title('Titre')
                    ->required(),
            ]))
                ->async('asyncForumtype')
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
        // Validate form data, save forumtype to database, etc.
        $request->validate([
            'forumtype.titre' => 'required|max:255',
        ]);

        $forumtype = new Forumtype();
        $forumtype->titre = $request->input('forumtype.titre');
        $forumtype->save();
    }

    /**
     * @param Forumtype $forumtype
     *
     * @return void
     */
    public function delete(Forumtype $forumtype)
    {
        $forumtype->delete();
    }



    public function toggleEtat(Request $request)
    {
        $forumtype = Forumtype::findOrFail($request->input('forumtype'));
        $forumtype->etat = !$forumtype->etat;
        $forumtype->save();
    }

    public function update(Request $request)
    {
        $request->validate([
            'forumtype.titre' => 'required|max:255',
        ]);

        $forumtype = Forumtype::findOrFail($request->input('forumtype.id'));
        $forumtype->titre = $request->input('forumtype.titre');
        $forumtype->save();
    }

}
