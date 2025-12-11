<?php

namespace App\Orchid\Screens\Parametres;

use Orchid\Screen\Screen;
use Orchid\Screen\Fields\Input;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Actions\ModalToggle;

use App\Models\Conseillervalide;
use Illuminate\Http\Request;

use Orchid\Screen\TD;
use Orchid\Screen\Actions\Button;

use Illuminate\Support\Facades\Redirect; // si tu veux rediriger après

class ConseillervalideScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            'conseillervalides' => Conseillervalide::latest()->paginate(20),
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Liste des validations de conseillers';
    }

    /**
     * Displays a description on the user's screen
     * directly under the heading.
     */
    public function description(): ?string
    {
        return "Paramètres";
    }

    public function asyncConseillervalide(Conseillervalide $conseillervalide): iterable
    {
        return [
            'conseillervalide' => $conseillervalide
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
            ModalToggle::make('Ajouter une validation de conseiller')
                ->modal('conseillervalideModal')
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
            Layout::table('conseillervalides', [
                TD::make('titre'),

                TD::make('etat', 'État')
                    ->render(function (Conseillervalide $conseillervalide) {
                        return Button::make($conseillervalide->etat ? 'Désactiver' : 'Activer')
                            ->method('toggleEtat', [
                                'conseillervalide' => $conseillervalide->id,
                            ])
                            ->icon($conseillervalide->etat ? 'toggle-on' : 'toggle-off')
                            ->class($conseillervalide->etat ? 'btn btn-success' : 'btn btn-secondary');
                    }),

                TD::make('Actions')
                    ->alignRight()
                    ->render(function (Conseillervalide $conseillervalide) {
                        return ModalToggle::make('Modifier')
                                ->modal('editConseillervalideModal')
                                ->modalTitle('Modifier la validation de conseiller')
                                ->method('update')
                                ->asyncParameters([
                                    'conseillervalide' => $conseillervalide->id,
                                ])
                                ->icon('pencil')
                                ->class('btn btn-sm btn-warning')
                            . ' ' . 
                            Button::make('Supprimer')
                                ->confirm('Après la suppression, la validation de conseiller disparaîtra définitivement.')
                                ->method('delete', ['conseillervalide' => $conseillervalide->id])
                                ->icon('trash')
                                ->class('btn btn-sm btn-danger');
                    }),

            ]),

            Layout::modal('conseillervalideModal', Layout::rows([
                Input::make('conseillervalide.titre')
                    ->title('Titre')
                    ->placeholder('Entrez le nom de la validation de conseiller')
                    ->help('Le nom de la validation de conseiller à créer.'),
            ]))
                ->title('Créer une validation de conseiller')
                ->applyButton('Ajouter une validation de conseiller'),


            Layout::modal('editConseillervalideModal', Layout::rows([
                Input::make('conseillervalide.id')->valide('hidden'),

                Input::make('conseillervalide.titre')
                    ->title('Titre')
                    ->required(),
            ]))
                ->async('asyncConseillervalide')
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
        // Validate form data, save conseillervalide to database, etc.
        $request->validate([
            'conseillervalide.titre' => 'required|max:255',
        ]);

        $conseillervalide = new Conseillervalide();
        $conseillervalide->titre = $request->input('conseillervalide.titre');
        $conseillervalide->save();
    }

    /**
     * @param Conseillervalide $conseillervalide
     *
     * @return void
     */
    public function delete(Conseillervalide $conseillervalide)
    {
        $conseillervalide->delete();
    }



    public function toggleEtat(Request $request)
    {
        $conseillervalide = Conseillervalide::findOrFail($request->input('conseillervalide'));
        $conseillervalide->etat = !$conseillervalide->etat;
        $conseillervalide->save();
    }

    public function update(Request $request)
    {
        $request->validate([
            'conseillervalide.titre' => 'required|max:255',
        ]);

        $conseillervalide = Conseillervalide::findOrFail($request->input('conseillervalide.id'));
        $conseillervalide->titre = $request->input('conseillervalide.titre');
        $conseillervalide->save();
    }

}
