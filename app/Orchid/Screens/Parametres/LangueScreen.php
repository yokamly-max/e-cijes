<?php

namespace App\Orchid\Screens\Parametres;

use Orchid\Screen\Screen;
use Orchid\Screen\Fields\Input;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Actions\ModalToggle;

use App\Models\Langue;
use Illuminate\Http\Request;

use Orchid\Screen\TD;
use Orchid\Screen\Actions\Button;

use Illuminate\Support\Facades\Redirect; // si tu veux rediriger après

class LangueScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        $langueModel = new Langue();
        return [
            'langues' => $langueModel->all(), // Collection depuis Supabase
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Liste des langues';
    }

    /**
     * Displays a description on the user's screen
     * directly under the heading.
     */
    public function description(): ?string
    {
        return "Paramètres";
    }

    public function asyncLangue(Langue $langue): iterable
    {
        return [
            'langue' => $langue
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
            ModalToggle::make('Ajouter une langue')
                ->modal('langueModal')
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
            Layout::table('langues', [
                TD::make('titre'),
                TD::make('code'),

                TD::make('etat', 'État')
                    ->render(function (Langue $langue) {
                        return Button::make($langue->etat ? 'Désactiver' : 'Activer')
                            ->method('toggleEtat', [
                                'langue' => $langue->id,
                            ])
                            ->icon($langue->etat ? 'toggle-on' : 'toggle-off')
                            ->class($langue->etat ? 'btn btn-success' : 'btn btn-secondary');
                    }),

                TD::make('Actions')
                    ->alignRight()
                    ->render(function (Langue $langue) {
                        return ModalToggle::make('Modifier')
                                ->modal('editLangueModal')
                                ->modalTitle('Modifier la langue')
                                ->method('update')
                                ->asyncParameters([
                                    'langue' => $langue->id,
                                ])
                                ->icon('pencil')
                                ->class('btn btn-sm btn-warning')
                            . ' ' . 
                            Button::make('Supprimer')
                                ->confirm('Après la suppression, la langue disparaîtra définitivement.')
                                ->method('delete', ['langue' => $langue->id])
                                ->icon('trash')
                                ->class('btn btn-sm btn-danger');
                    }),

            ]),

            Layout::modal('langueModal', Layout::rows([
                Input::make('langue.titre')
                    ->title('Nom')
                    ->placeholder('Entrez le nom de la langue')
                    ->help('Le nom de la langue à créer.'),
                Input::make('langue.code')
                    ->title('Code')
                    ->placeholder('Entrez le code de la langue')
                    ->help('Le code de la langue à créer.'),
            ]))
                ->title('Créer une langue')
                ->applyButton('Ajouter une langue'),


            Layout::modal('editLangueModal', Layout::rows([
                Input::make('langue.id')->type('hidden'),

                Input::make('langue.titre')
                    ->title('Nom')
                    ->required(),
                Input::make('langue.code')
                    ->title('Code')
                    ->required(),
            ]))
                ->async('asyncLangue')
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
        // Validate form data, save langue to database, etc.
        $request->validate([
            'langue.titre' => 'required|max:255',
            'langue.code' => 'required|max:255',
        ]);

        $langue = new Langue();
        $langue->titre = $request->input('langue.titre');
        $langue->code = $request->input('langue.code');
        $langue->save();
    }

    /**
     * @param Langue $langue
     *
     * @return void
     */
    public function delete(Langue $langue)
    {
        $langue->delete();
    }



    public function toggleEtat(Request $request)
    {
        $langue = Langue::findOrFail($request->input('langue'));
        $langue->etat = !$langue->etat;
        $langue->save();
    }

    public function update(Request $request)
    {
        $request->validate([
            'langue.titre' => 'required|max:255',
            'langue.code' => 'required|max:255',
        ]);

        $langue = Langue::findOrFail($request->input('langue.id'));
        $langue->titre = $request->input('langue.titre');
        $langue->code = $request->input('langue.code');
        $langue->save();
    }

}
