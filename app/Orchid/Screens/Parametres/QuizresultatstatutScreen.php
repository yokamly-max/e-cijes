<?php

namespace App\Orchid\Screens\Parametres;

use Orchid\Screen\Screen;
use Orchid\Screen\Fields\Input;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Actions\ModalToggle;

use App\Models\Quizresultatstatut;
use Illuminate\Http\Request;

use Orchid\Screen\TD;
use Orchid\Screen\Actions\Button;

use Illuminate\Support\Facades\Redirect; // si tu veux rediriger après

class QuizresultatstatutScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            'quizresultatstatuts' => Quizresultatstatut::latest()->paginate(20),
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Liste des statut de resultat du quiz';
    }

    /**
     * Displays a description on the user's screen
     * directly under the heading.
     */
    public function description(): ?string
    {
        return "Paramètres";
    }

    public function asyncQuizresultatstatut(Quizresultatstatut $quizresultatstatut): iterable
    {
        return [
            'quizresultatstatut' => $quizresultatstatut
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
            ModalToggle::make('Ajouter un statut de resultat du quiz')
                ->modal('quizresultatstatutModal')
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
            Layout::table('quizresultatstatuts', [
                TD::make('titre'),

                TD::make('etat', 'État')
                    ->render(function (Quizresultatstatut $quizresultatstatut) {
                        return Button::make($quizresultatstatut->etat ? 'Désactiver' : 'Activer')
                            ->method('toggleEtat', [
                                'quizresultatstatut' => $quizresultatstatut->id,
                            ])
                            ->icon($quizresultatstatut->etat ? 'toggle-on' : 'toggle-off')
                            ->class($quizresultatstatut->etat ? 'btn btn-success' : 'btn btn-secondary');
                    }),

                TD::make('Actions')
                    ->alignRight()
                    ->render(function (Quizresultatstatut $quizresultatstatut) {
                        return ModalToggle::make('Modifier')
                                ->modal('editQuizresultatstatutModal')
                                ->modalTitle('Modifier le statut de resultat du quiz')
                                ->method('update')
                                ->asyncParameters([
                                    'quizresultatstatut' => $quizresultatstatut->id,
                                ])
                                ->icon('pencil')
                                ->class('btn btn-sm btn-warning')
                            . ' ' . 
                            Button::make('Supprimer')
                                ->confirm('Après la suppression, le statut de resultat du quiz disparaîtra définitivement.')
                                ->method('delete', ['quizresultatstatut' => $quizresultatstatut->id])
                                ->icon('trash')
                                ->class('btn btn-sm btn-danger');
                    }),

            ]),

            Layout::modal('quizresultatstatutModal', Layout::rows([
                Input::make('quizresultatstatut.titre')
                    ->title('Titre')
                    ->placeholder('Entrez le nom du type')
                    ->help('Le nom du type à créer.'),
            ]))
                ->title('Créer un type')
                ->applyButton('Ajouter un type'),


            Layout::modal('editQuizresultatstatutModal', Layout::rows([
                Input::make('quizresultatstatut.id')->type('hidden'),

                Input::make('quizresultatstatut.titre')
                    ->title('Titre')
                    ->required(),
            ]))
                ->async('asyncQuizresultatstatut')
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
        // Validate form data, save quizresultatstatut to database, etc.
        $request->validate([
            'quizresultatstatut.titre' => 'required|max:255',
        ]);

        $quizresultatstatut = new Quizresultatstatut();
        $quizresultatstatut->titre = $request->input('quizresultatstatut.titre');
        $quizresultatstatut->save();
    }

    /**
     * @param Quizresultatstatut $quizresultatstatut
     *
     * @return void
     */
    public function delete(Quizresultatstatut $quizresultatstatut)
    {
        $quizresultatstatut->delete();
    }



    public function toggleEtat(Request $request)
    {
        $quizresultatstatut = Quizresultatstatut::findOrFail($request->input('quizresultatstatut'));
        $quizresultatstatut->etat = !$quizresultatstatut->etat;
        $quizresultatstatut->save();
    }

    public function update(Request $request)
    {
        $request->validate([
            'quizresultatstatut.titre' => 'required|max:255',
        ]);

        $quizresultatstatut = Quizresultatstatut::findOrFail($request->input('quizresultatstatut.id'));
        $quizresultatstatut->titre = $request->input('quizresultatstatut.titre');
        $quizresultatstatut->save();
    }

}
