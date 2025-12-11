<?php

namespace App\Orchid\Screens\Evaluation;

use Orchid\Screen\Screen;

use App\Models\Evaluation;
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
     * @var Evaluation
     */
    public $evaluation;

    /**
     * Query data.
     *
     * @param Evaluation $evaluation
     *
     * @return array
     */
    public function query(Evaluation $evaluation): array
    {
        return [
            'evaluation' => $evaluation
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return $this->evaluation->exists ? 'Modification de l\'évaluation' : 'Créer une évaluation';
    }

    /**
     * The description is displayed on the user's screen under the heading
     */
    public function description(): ?string
    {
        return "Toutes les évaluations enregistrées";
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Button::make('Créer une évaluation')
                ->icon('pencil')
                ->method('createOrUpdate')
                ->canSee(!$this->evaluation->exists),

            Button::make('Modifier l\'évaluation')
                ->icon('note')
                ->method('createOrUpdate')
                ->canSee($this->evaluation->exists),

            Button::make('Supprimer')
                ->icon('trash')
                ->method('remove')
                ->canSee($this->evaluation->exists),
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
                Input::make('evaluation.note')
                    ->title('Note')
                    ->required()
                    ->placeholder('Saisir la note'),

                TextArea::make('evaluation.commentaire')
                    ->title('Commentaire')
                    ->placeholder('Saisir le commentaire'),

                Select::make('evaluation.expert_id')
                    ->title('Expert')
                    ->placeholder('Choisir l\'expert')
                    ->options(
                        \App\Models\Expert::with('membre')->get()
                            ->mapWithKeys(function ($expert) {
                                return [$expert->id => trim("{$expert->membre->prenom} {$expert->membre->nom}")];
                            })
                            ->toArray()
                    )
                    ->empty('Choisir', 0),

                Select::make('evaluation.membre_id')
                    ->title('Membre')
                    ->placeholder('Choisir le membre')
                    ->options(
                        \App\Models\Membre::all()
                            ->mapWithKeys(function ($membre) {
                                return [$membre->id => trim("{$membre->prenom} {$membre->nom}")];
                            })
                            ->toArray())
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
    $data = $request->get('evaluation');

    $this->evaluation->fill($data)->save();

    Alert::info('Evaluation enregistrée avec succès.');

    return redirect()->route('platform.evaluation.list');
}

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function remove()
    {
        $this->evaluation->delete();

        Alert::info('Vous avez supprimé l\'évaluation avec succès.');

        return redirect()->route('platform.evaluation.list');
    }

}
