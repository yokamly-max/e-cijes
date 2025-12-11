<?php

namespace App\Orchid\Screens\Parametres;

use Orchid\Screen\Screen;
use Orchid\Screen\Fields\Input;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Actions\ModalToggle;

use App\Models\Suivitype;
use Illuminate\Http\Request;

use Orchid\Screen\TD;
use Orchid\Screen\Actions\Button;

use Illuminate\Support\Facades\Redirect; // si tu veux rediriger après

class SuivitypeScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            'suivitypes' => Suivitype::latest()->paginate(20),
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Liste des types de suivis';
    }

    /**
     * Displays a description on the user's screen
     * directly under the heading.
     */
    public function description(): ?string
    {
        return "Paramètres";
    }

    public function asyncSuivitype(Suivitype $suivitype): iterable
    {
        return [
            'suivitype' => $suivitype
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
            ModalToggle::make('Ajouter un type de suivi')
                ->modal('suivitypeModal')
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
            Layout::table('suivitypes', [
                TD::make('titre'),

                TD::make('etat', 'État')
                    ->render(function (Suivitype $suivitype) {
                        return Button::make($suivitype->etat ? 'Désactiver' : 'Activer')
                            ->method('toggleEtat', [
                                'suivitype' => $suivitype->id,
                            ])
                            ->icon($suivitype->etat ? 'toggle-on' : 'toggle-off')
                            ->class($suivitype->etat ? 'btn btn-success' : 'btn btn-secondary');
                    }),

                TD::make('Actions')
                    ->alignRight()
                    ->render(function (Suivitype $suivitype) {
                        return ModalToggle::make('Modifier')
                                ->modal('editSuivitypeModal')
                                ->modalTitle('Modifier le type de suivi')
                                ->method('update')
                                ->asyncParameters([
                                    'suivitype' => $suivitype->id,
                                ])
                                ->icon('pencil')
                                ->class('btn btn-sm btn-warning')
                            . ' ' . 
                            Button::make('Supprimer')
                                ->confirm('Après la suppression, le type de suivi disparaîtra définitivement.')
                                ->method('delete', ['suivitype' => $suivitype->id])
                                ->icon('trash')
                                ->class('btn btn-sm btn-danger');
                    }),

            ]),

            Layout::modal('suivitypeModal', Layout::rows([
                Input::make('suivitype.titre')
                    ->title('Titre')
                    ->placeholder('Entrez le nom du type de suivi')
                    ->help('Le nom du type de suivi à créer.'),
            ]))
                ->title('Créer un type de suivi')
                ->applyButton('Ajouter un type de suivi'),


            Layout::modal('editSuivitypeModal', Layout::rows([
                Input::make('suivitype.id')->type('hidden'),

                Input::make('suivitype.titre')
                    ->title('Titre')
                    ->required(),
            ]))
                ->async('asyncSuivitype')
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
        // Validate form data, save suivitype to database, etc.
        $request->validate([
            'suivitype.titre' => 'required|max:255',
        ]);

        $suivitype = new Suivitype();
        $suivitype->titre = $request->input('suivitype.titre');
        $suivitype->save();
    }

    /**
     * @param Suivitype $suivitype
     *
     * @return void
     */
    public function delete(Suivitype $suivitype)
    {
        $suivitype->delete();
    }



    public function toggleEtat(Request $request)
    {
        $suivitype = Suivitype::findOrFail($request->input('suivitype'));
        $suivitype->etat = !$suivitype->etat;
        $suivitype->save();
    }

    public function update(Request $request)
    {
        $request->validate([
            'suivitype.titre' => 'required|max:255',
        ]);

        $suivitype = Suivitype::findOrFail($request->input('suivitype.id'));
        $suivitype->titre = $request->input('suivitype.titre');
        $suivitype->save();
    }

}
