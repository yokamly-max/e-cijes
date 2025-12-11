<?php

namespace App\Orchid\Screens\Quiz;

use Orchid\Screen\Screen;

use App\Models\Quiz;

use Illuminate\Http\Request;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\DateTimer;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Fields\Quill;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Actions\Button;
use Orchid\Support\Facades\Alert;

class EditScreen extends Screen
{
    /**
     * @var Quiz
     */
    public $quiz;

    /**
     * Query data.
     *
     * @param Quiz $quiz
     *
     * @return array
     */
    public function query(Quiz $quiz): array
    {
        return [
            'quiz' => $quiz
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return $this->quiz->exists ? 'Modification du quiz' : 'Créer un quiz';
    }

    /**
     * The description is displayed on the user's screen under the heading
     */
    public function description(): ?string
    {
        return "Tous les quiz enregistrés";
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Button::make('Créer un quiz')
                ->icon('pencil')
                ->method('createOrUpdate')
                ->canSee(!$this->quiz->exists),

            Button::make('Modifier le quiz')
                ->icon('note')
                ->method('createOrUpdate')
                ->canSee($this->quiz->exists),

            Button::make('Supprimer')
                ->icon('trash')
                ->method('remove')
                ->canSee($this->quiz->exists),
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
            Layout::rows([
                Input::make('quiz.titre')
                    ->title('Titre')
                    ->placeholder('Saisir le titre'),

                Input::make('quiz.seuil_reussite')
                    ->title('Seuil reussite')
                    ->required()
                    ->placeholder('Saisir le seuil reussite'),

                Select::make('quiz.formation_id')
                    ->title('Formation')
                    ->placeholder('Choisir la formation')
                    ->fromModel(\App\Models\Formation::class, 'titre')
                    ->empty('Choisir', 0),

            ])
        ];
    }
    

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function createOrUpdate(Request $request)
{
    $data = $request->get('quiz');

    $this->quiz->fill($data)->save();

    Alert::info('Quiz enregistré avec succès.');

    return redirect()->route('platform.quiz.list');
}

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function remove()
    {
        $this->quiz->delete();

        Alert::info('Vous avez supprimé la quiz avec succès.');

        return redirect()->route('platform.quiz.list');
    }

}
