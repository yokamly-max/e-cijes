<?php

namespace App\Orchid\Screens\Parametres;

use Orchid\Screen\Screen;
use Orchid\Screen\Fields\Input;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Actions\ModalToggle;

use App\Models\Formationniveau;
use Illuminate\Http\Request;

use Orchid\Screen\TD;
use Orchid\Screen\Actions\Button;

use Illuminate\Support\Facades\Redirect; // si tu veux rediriger après

class FormationniveauScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            'formationniveaus' => Formationniveau::latest()->paginate(20),
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Liste des niveaux des formations';
    }

    /**
     * Displays a description on the user's screen
     * directly under the heading.
     */
    public function description(): ?string
    {
        return "Paramètres";
    }

    public function asyncFormationniveau(Formationniveau $formationniveau): iterable
    {
        return [
            'formationniveau' => $formationniveau
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
            ModalToggle::make('Ajouter un niveau de formation')
                ->modal('formationniveauModal')
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
            Layout::table('formationniveaus', [
                TD::make('titre'),

                TD::make('etat', 'État')
                    ->render(function (Formationniveau $formationniveau) {
                        return Button::make($formationniveau->etat ? 'Désactiver' : 'Activer')
                            ->method('toggleEtat', [
                                'formationniveau' => $formationniveau->id,
                            ])
                            ->icon($formationniveau->etat ? 'toggle-on' : 'toggle-off')
                            ->class($formationniveau->etat ? 'btn btn-success' : 'btn btn-secondary');
                    }),

                TD::make('Actions')
                    ->alignRight()
                    ->render(function (Formationniveau $formationniveau) {
                        return ModalToggle::make('Modifier')
                                ->modal('editFormationniveauModal')
                                ->modalTitle('Modifier le niveau de formation')
                                ->method('update')
                                ->asyncParameters([
                                    'formationniveau' => $formationniveau->id,
                                ])
                                ->icon('pencil')
                                ->class('btn btn-sm btn-warning')
                            . ' ' . 
                            Button::make('Supprimer')
                                ->confirm('Après la suppression, le niveau de formation disparaîtra définitivement.')
                                ->method('delete', ['formationniveau' => $formationniveau->id])
                                ->icon('trash')
                                ->class('btn btn-sm btn-danger');
                    }),

            ]),

            Layout::modal('formationniveauModal', Layout::rows([
                Input::make('formationniveau.titre')
                    ->title('Titre')
                    ->placeholder('Entrez le nom du niveau de formation')
                    ->help('Le nom du niveau de formation à créer.'),
            ]))
                ->title('Créer un niveau de formation')
                ->applyButton('Ajouter un niveau de formation'),


            Layout::modal('editFormationniveauModal', Layout::rows([
                Input::make('formationniveau.id')->type('hidden'),

                Input::make('formationniveau.titre')
                    ->title('Titre')
                    ->required(),
            ]))
                ->async('asyncFormationniveau')
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
        // Validate form data, save formationniveau to database, etc.
        $request->validate([
            'formationniveau.titre' => 'required|max:255',
        ]);

        $formationniveau = new Formationniveau();
        $formationniveau->titre = $request->input('formationniveau.titre');
        $formationniveau->save();
    }

    /**
     * @param Formationniveau $formationniveau
     *
     * @return void
     */
    public function delete(Formationniveau $formationniveau)
    {
        $formationniveau->delete();
    }



    public function toggleEtat(Request $request)
    {
        $formationniveau = Formationniveau::findOrFail($request->input('formationniveau'));
        $formationniveau->etat = !$formationniveau->etat;
        $formationniveau->save();
    }

    public function update(Request $request)
    {
        $request->validate([
            'formationniveau.titre' => 'required|max:255',
        ]);

        $formationniveau = Formationniveau::findOrFail($request->input('formationniveau.id'));
        $formationniveau->titre = $request->input('formationniveau.titre');
        $formationniveau->save();
    }

}
