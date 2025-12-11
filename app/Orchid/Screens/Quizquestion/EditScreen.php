<?php

namespace App\Orchid\Screens\Quizquestion;

use Orchid\Screen\Screen;

use App\Models\Quizquestion;

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
     * @var Quizquestion
     */
    public $quizquestion;

    /**
     * Query data.
     *
     * @param Quizquestion $quizquestion
     *
     * @return array
     */
    public function query(Quizquestion $quizquestion): array
    {
        return [
            'quizquestion' => $quizquestion
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return $this->quizquestion->exists ? 'Modification de la question du quiz' : 'Créer une question du quiz';
    }

    /**
     * The description is displayed on the user's screen under the heading
     */
    public function description(): ?string
    {
        return "Toutes les questions du quiz enregistrées";
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Button::make('Créer une question du quiz')
                ->icon('pencil')
                ->method('createOrUpdate')
                ->canSee(!$this->quizquestion->exists),

            Button::make('Modifier la question du quiz')
                ->icon('note')
                ->method('createOrUpdate')
                ->canSee($this->quizquestion->exists),

            Button::make('Supprimer')
                ->icon('trash')
                ->method('remove')
                ->canSee($this->quizquestion->exists),
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
                Textarea::make('quizquestion.titre')
                    ->title('Titre')
                    ->required()
                    ->placeholder('Saisir le titre'),

                Input::make('quizquestion.point')
                    ->title('Point')
                    ->placeholder('Saisir le point'),

                Select::make('quizquestion.quiz_id')
                    ->title('Quiz')
                    ->placeholder('Choisir le quiz')
                    ->fromModel(\App\Models\Quiz::class, 'titre')
                    ->empty('Choisir', 0),

                Select::make('quizquestion.quizquestiontype_id')
                    ->title('Type de la question du quiz')
                    ->placeholder('Choisir le type')
                    ->fromModel(\App\Models\Quizquestiontype::class, 'titre')
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
    $data = $request->get('quizquestion');

    $this->quizquestion->fill($data)->save();

    Alert::info('Question du quiz enregistrée avec succès.');

    return redirect()->route('platform.quizquestion.list');
}

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function remove()
    {
        $this->quizquestion->delete();

        Alert::info('Vous avez supprimé la question du quiz avec succès.');

        return redirect()->route('platform.quizquestion.list');
    }

}
