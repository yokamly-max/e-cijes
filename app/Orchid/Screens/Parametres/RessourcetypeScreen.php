<?php

namespace App\Orchid\Screens\Parametres;

use Orchid\Screen\Screen;
use Orchid\Screen\Fields\Input;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Actions\ModalToggle;

use App\Models\Ressourcetype;
use Illuminate\Http\Request;

use Orchid\Screen\TD;
use Orchid\Screen\Actions\Button;

use Illuminate\Support\Facades\Redirect; // si tu veux rediriger après

class RessourcetypeScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            'ressourcetypes' => Ressourcetype::latest()->paginate(20),
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Liste des types de ressources';
    }

    /**
     * Displays a description on the user's screen
     * directly under the heading.
     */
    public function description(): ?string
    {
        return "Paramètres";
    }

    public function asyncRessourcetype(Ressourcetype $ressourcetype): iterable
    {
        return [
            'ressourcetype' => $ressourcetype
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
            ModalToggle::make('Ajouter un type de ressource')
                ->modal('ressourcetypeModal')
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
            Layout::table('ressourcetypes', [
                TD::make('titre'),

                TD::make('etat', 'État')
                    ->render(function (Ressourcetype $ressourcetype) {
                        return Button::make($ressourcetype->etat ? 'Désactiver' : 'Activer')
                            ->method('toggleEtat', [
                                'ressourcetype' => $ressourcetype->id,
                            ])
                            ->icon($ressourcetype->etat ? 'toggle-on' : 'toggle-off')
                            ->class($ressourcetype->etat ? 'btn btn-success' : 'btn btn-secondary');
                    }),

                TD::make('Actions')
                    ->alignRight()
                    ->render(function (Ressourcetype $ressourcetype) {
                        return ModalToggle::make('Modifier')
                                ->modal('editRessourcetypeModal')
                                ->modalTitle('Modifier le type de ressource')
                                ->method('update')
                                ->asyncParameters([
                                    'ressourcetype' => $ressourcetype->id,
                                ])
                                ->icon('pencil')
                                ->class('btn btn-sm btn-warning')
                            . ' ' . 
                            Button::make('Supprimer')
                                ->confirm('Après la suppression, le type de ressource disparaîtra définitivement.')
                                ->method('delete', ['ressourcetype' => $ressourcetype->id])
                                ->icon('trash')
                                ->class('btn btn-sm btn-danger');
                    }),

            ]),

            Layout::modal('ressourcetypeModal', Layout::rows([
                Input::make('ressourcetype.titre')
                    ->title('Titre')
                    ->placeholder('Entrez le nom du type de ressource')
                    ->help('Le nom du type de ressource à créer.'),
            ]))
                ->title('Créer un type de ressource')
                ->applyButton('Ajouter un type de ressource'),


            Layout::modal('editRessourcetypeModal', Layout::rows([
                Input::make('ressourcetype.id')->type('hidden'),

                Input::make('ressourcetype.titre')
                    ->title('Titre')
                    ->required(),
            ]))
                ->async('asyncRessourcetype')
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
        // Validate form data, save ressourcetype to database, etc.
        $request->validate([
            'ressourcetype.titre' => 'required|max:255',
        ]);

        $ressourcetype = new Ressourcetype();
        $ressourcetype->titre = $request->input('ressourcetype.titre');
        $ressourcetype->save();
    }

    /**
     * @param Ressourcetype $ressourcetype
     *
     * @return void
     */
    public function delete(Ressourcetype $ressourcetype)
    {
        $ressourcetype->delete();
    }



    public function toggleEtat(Request $request)
    {
        $ressourcetype = Ressourcetype::findOrFail($request->input('ressourcetype'));
        $ressourcetype->etat = !$ressourcetype->etat;
        $ressourcetype->save();
    }

    public function update(Request $request)
    {
        $request->validate([
            'ressourcetype.titre' => 'required|max:255',
        ]);

        $ressourcetype = Ressourcetype::findOrFail($request->input('ressourcetype.id'));
        $ressourcetype->titre = $request->input('ressourcetype.titre');
        $ressourcetype->save();
    }

}
