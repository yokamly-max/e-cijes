<?php

namespace App\Orchid\Screens\Parametres;

use Orchid\Screen\Screen;
use Orchid\Screen\Fields\Input;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Actions\ModalToggle;

use App\Models\Quizquestiontype;
use Illuminate\Http\Request;

use Orchid\Screen\TD;
use Orchid\Screen\Actions\Button;

use Illuminate\Support\Facades\Redirect; // si tu veux rediriger après

class QuizquestiontypeScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            'quizquestiontypes' => Quizquestiontype::latest()->paginate(20),
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Liste des types de question du quiz';
    }

    /**
     * Displays a description on the user's screen
     * directly under the heading.
     */
    public function description(): ?string
    {
        return "Paramètres";
    }

    public function asyncQuizquestiontype(Quizquestiontype $quizquestiontype): iterable
    {
        return [
            'quizquestiontype' => $quizquestiontype
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
            ModalToggle::make('Ajouter un type de question du quiz')
                ->modal('quizquestiontypeModal')
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
            Layout::table('quizquestiontypes', [
                TD::make('titre'),

                TD::make('etat', 'État')
                    ->render(function (Quizquestiontype $quizquestiontype) {
                        return Button::make($quizquestiontype->etat ? 'Désactiver' : 'Activer')
                            ->method('toggleEtat', [
                                'quizquestiontype' => $quizquestiontype->id,
                            ])
                            ->icon($quizquestiontype->etat ? 'toggle-on' : 'toggle-off')
                            ->class($quizquestiontype->etat ? 'btn btn-success' : 'btn btn-secondary');
                    }),

                TD::make('Actions')
                    ->alignRight()
                    ->render(function (Quizquestiontype $quizquestiontype) {
                        return ModalToggle::make('Modifier')
                                ->modal('editQuizquestiontypeModal')
                                ->modalTitle('Modifier le type de question du quiz')
                                ->method('update')
                                ->asyncParameters([
                                    'quizquestiontype' => $quizquestiontype->id,
                                ])
                                ->icon('pencil')
                                ->class('btn btn-sm btn-warning')
                            . ' ' . 
                            Button::make('Supprimer')
                                ->confirm('Après la suppression, le type de question du quiz disparaîtra définitivement.')
                                ->method('delete', ['quizquestiontype' => $quizquestiontype->id])
                                ->icon('trash')
                                ->class('btn btn-sm btn-danger');
                    }),

            ]),

            Layout::modal('quizquestiontypeModal', Layout::rows([
                Input::make('quizquestiontype.titre')
                    ->title('Titre')
                    ->placeholder('Entrez le nom du type')
                    ->help('Le nom du type à créer.'),
            ]))
                ->title('Créer un type')
                ->applyButton('Ajouter un type'),


            Layout::modal('editQuizquestiontypeModal', Layout::rows([
                Input::make('quizquestiontype.id')->type('hidden'),

                Input::make('quizquestiontype.titre')
                    ->title('Titre')
                    ->required(),
            ]))
                ->async('asyncQuizquestiontype')
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
        // Validate form data, save quizquestiontype to database, etc.
        $request->validate([
            'quizquestiontype.titre' => 'required|max:255',
        ]);

        $quizquestiontype = new Quizquestiontype();
        $quizquestiontype->titre = $request->input('quizquestiontype.titre');
        $quizquestiontype->save();
    }

    /**
     * @param Quizquestiontype $quizquestiontype
     *
     * @return void
     */
    public function delete(Quizquestiontype $quizquestiontype)
    {
        $quizquestiontype->delete();
    }



    public function toggleEtat(Request $request)
    {
        $quizquestiontype = Quizquestiontype::findOrFail($request->input('quizquestiontype'));
        $quizquestiontype->etat = !$quizquestiontype->etat;
        $quizquestiontype->save();
    }

    public function update(Request $request)
    {
        $request->validate([
            'quizquestiontype.titre' => 'required|max:255',
        ]);

        $quizquestiontype = Quizquestiontype::findOrFail($request->input('quizquestiontype.id'));
        $quizquestiontype->titre = $request->input('quizquestiontype.titre');
        $quizquestiontype->save();
    }

}
