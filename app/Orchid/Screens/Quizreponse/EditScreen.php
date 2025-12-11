<?php

namespace App\Orchid\Screens\Quizreponse;

use Orchid\Screen\Screen;

use App\Models\Quizreponse;

use Illuminate\Http\Request;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\DateTimer;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Fields\Quill;
use Orchid\Screen\Fields\CheckBox;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Actions\Button;
use Orchid\Support\Facades\Alert;

class EditScreen extends Screen
{
    /**
     * @var Quizreponse
     */
    public $quizreponse;

    /**
     * Query data.
     *
     * @param Quizreponse $quizreponse
     *
     * @return array
     */
    public function query(Quizreponse $quizreponse): array
    {
        return [
            'quizreponse' => $quizreponse
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return $this->quizreponse->exists ? 'Modification de la reponse du quiz' : 'Créer une reponse du quiz';
    }

    /**
     * The description is displayed on the user's screen under the heading
     */
    public function description(): ?string
    {
        return "Toutes les reponses du quiz enregistrées";
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Button::make('Créer une reponse du quiz')
                ->icon('pencil')
                ->method('createOrUpdate')
                ->canSee(!$this->quizreponse->exists),

            Button::make('Modifier la reponse du quiz')
                ->icon('note')
                ->method('createOrUpdate')
                ->canSee($this->quizreponse->exists),

            Button::make('Supprimer')
                ->icon('trash')
                ->method('remove')
                ->canSee($this->quizreponse->exists),
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
                Textarea::make('quizreponse.text')
                    ->title('Text')
                    ->required()
                    ->placeholder('Saisir le text'),

                Input::make('quizreponse.correcte')
                    ->title('Correcte')
                    ->placeholder('Saisir le correcte'),

                CheckBox::make('quizreponse.correcte')
                    ->title('Question correcte')
                    ->sendTrueOrFalse(),

                Select::make('quizreponse.quizquestion_id')
                    ->title('Question')
                    ->placeholder('Choisir la question')
                    ->fromModel(\App\Models\Quizquestion::class, 'titre')
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
    $data = $request->get('quizreponse');

    $this->quizreponse->fill($data)->save();

    Alert::info('Reponse du quiz enregistrée avec succès.');

    return redirect()->route('platform.quizreponse.list');
}

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function remove()
    {
        $this->quizreponse->delete();

        Alert::info('Vous avez supprimé la reponse du quiz avec succès.');

        return redirect()->route('platform.quizreponse.list');
    }

}
