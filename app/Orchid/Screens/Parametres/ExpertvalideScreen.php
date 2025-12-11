<?php

namespace App\Orchid\Screens\Parametres;

use Orchid\Screen\Screen;
use Orchid\Screen\Fields\Input;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Actions\ModalToggle;

use App\Models\Expertvalide;
use Illuminate\Http\Request;

use Orchid\Screen\TD;
use Orchid\Screen\Actions\Button;

use Illuminate\Support\Facades\Redirect; // si tu veux rediriger après

class ExpertvalideScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            'expertvalides' => Expertvalide::latest()->paginate(20),
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Liste des validations d\'experts';
    }

    /**
     * Displays a description on the user's screen
     * directly under the heading.
     */
    public function description(): ?string
    {
        return "Paramètres";
    }

    public function asyncExpertvalide(Expertvalide $expertvalide): iterable
    {
        return [
            'expertvalide' => $expertvalide
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
            ModalToggle::make('Ajouter une validation d\'expert')
                ->modal('expertvalideModal')
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
            Layout::table('expertvalides', [
                TD::make('titre'),

                TD::make('etat', 'État')
                    ->render(function (Expertvalide $expertvalide) {
                        return Button::make($expertvalide->etat ? 'Désactiver' : 'Activer')
                            ->method('toggleEtat', [
                                'expertvalide' => $expertvalide->id,
                            ])
                            ->icon($expertvalide->etat ? 'toggle-on' : 'toggle-off')
                            ->class($expertvalide->etat ? 'btn btn-success' : 'btn btn-secondary');
                    }),

                TD::make('Actions')
                    ->alignRight()
                    ->render(function (Expertvalide $expertvalide) {
                        return ModalToggle::make('Modifier')
                                ->modal('editExpertvalideModal')
                                ->modalTitle('Modifier la validation d\'expert')
                                ->method('update')
                                ->asyncParameters([
                                    'expertvalide' => $expertvalide->id,
                                ])
                                ->icon('pencil')
                                ->class('btn btn-sm btn-warning')
                            . ' ' . 
                            Button::make('Supprimer')
                                ->confirm('Après la suppression, la validation d\'expert disparaîtra définitivement.')
                                ->method('delete', ['expertvalide' => $expertvalide->id])
                                ->icon('trash')
                                ->class('btn btn-sm btn-danger');
                    }),

            ]),

            Layout::modal('expertvalideModal', Layout::rows([
                Input::make('expertvalide.titre')
                    ->title('Titre')
                    ->placeholder('Entrez le nom de la validation d\'expert')
                    ->help('Le nom de la validation d\'expert à créer.'),
            ]))
                ->title('Créer une validation d\'expert')
                ->applyButton('Ajouter une validation d\'expert'),


            Layout::modal('editExpertvalideModal', Layout::rows([
                Input::make('expertvalide.id')->valide('hidden'),

                Input::make('expertvalide.titre')
                    ->title('Titre')
                    ->required(),
            ]))
                ->async('asyncExpertvalide')
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
        // Validate form data, save expertvalide to database, etc.
        $request->validate([
            'expertvalide.titre' => 'required|max:255',
        ]);

        $expertvalide = new Expertvalide();
        $expertvalide->titre = $request->input('expertvalide.titre');
        $expertvalide->save();
    }

    /**
     * @param Expertvalide $expertvalide
     *
     * @return void
     */
    public function delete(Expertvalide $expertvalide)
    {
        $expertvalide->delete();
    }



    public function toggleEtat(Request $request)
    {
        $expertvalide = Expertvalide::findOrFail($request->input('expertvalide'));
        $expertvalide->etat = !$expertvalide->etat;
        $expertvalide->save();
    }

    public function update(Request $request)
    {
        $request->validate([
            'expertvalide.titre' => 'required|max:255',
        ]);

        $expertvalide = Expertvalide::findOrFail($request->input('expertvalide.id'));
        $expertvalide->titre = $request->input('expertvalide.titre');
        $expertvalide->save();
    }

}
