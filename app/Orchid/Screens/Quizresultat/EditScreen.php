<?php

namespace App\Orchid\Screens\Quizresultat;

use Orchid\Screen\Screen;

use App\Models\Quizresultat;

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
     * @var Quizresultat
     */
    public $quizresultat;

    /**
     * Query data.
     *
     * @param Quizresultat $quizresultat
     *
     * @return array
     */
    public function query(Quizresultat $quizresultat): array
    {
        return [
            'quizresultat' => $quizresultat
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return $this->quizresultat->exists ? 'Modification du résultat du quiz' : 'Créer un résultat du quiz';
    }

    /**
     * The description is displayed on the user's screen under the heading
     */
    public function description(): ?string
    {
        return "Tous les résultats du quiz enregistrés";
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Button::make('Créer un résultat du quiz')
                ->icon('pencil')
                ->method('createOrUpdate')
                ->canSee(!$this->quizresultat->exists),

            Button::make('Modifier le résultat du quiz')
                ->icon('note')
                ->method('createOrUpdate')
                ->canSee($this->quizresultat->exists),

            Button::make('Supprimer')
                ->icon('trash')
                ->method('remove')
                ->canSee($this->quizresultat->exists),
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
                Select::make('quizresultat.membre_id')
                    ->title('Membre')
                    ->placeholder('Choisir le membre')
                    ->options(
                        \App\Models\Membre::all()
                            ->mapWithKeys(function ($membre) {
                                return [$membre->id => trim("{$membre->prenom} {$membre->nom}")];
                            })
                            ->toArray())
                    ->empty('Choisir', 0),

                Select::make('quizresultat.quiz_id')
                    ->title('Quiz')
                    ->placeholder('Choisir le quiz')
                    ->fromModel(\App\Models\Quiz::class, 'titre')
                    ->empty('Choisir', 0),

                Select::make('quizresultat.quizresultatstatut_id')
                    ->title('Statut')
                    ->placeholder('Choisir le statut')
                    ->fromModel(\App\Models\Quizresultatstatut::class, 'titre')
                    ->empty('Choisir', 0),

                Textarea::make('quizresultat.score')
                    ->title('Score')
                    ->placeholder('Saisir le score'),

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
    $data = $request->get('quizresultat');

    $this->quizresultat->fill($data)->save();

    Alert::info('Résultat du quiz enregistré avec succès.');

    return redirect()->route('platform.quizresultat.list');
}

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function remove()
    {
        $this->quizresultat->delete();

        Alert::info('Vous avez supprimé le résultat du quiz avec succès.');

        return redirect()->route('platform.quizresultat.list');
    }

}
