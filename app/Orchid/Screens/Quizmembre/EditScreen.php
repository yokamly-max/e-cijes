<?php

namespace App\Orchid\Screens\Quizmembre;

use Orchid\Screen\Screen;

use App\Models\Quizmembre;

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
     * @var Quizmembre
     */
    public $quizmembre;

    /**
     * Query data.
     *
     * @param Quizmembre $quizmembre
     *
     * @return array
     */
    public function query(Quizmembre $quizmembre): array
    {
        return [
            'quizmembre' => $quizmembre
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return $this->quizmembre->exists ? 'Modification du résultat du membre' : 'Créer un résultat du membre';
    }

    /**
     * The description is displayed on the user's screen under the heading
     */
    public function description(): ?string
    {
        return "Tous les résultats du membre enregistrés";
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Button::make('Créer un résultat du membre')
                ->icon('pencil')
                ->method('createOrUpdate')
                ->canSee(!$this->quizmembre->exists),

            Button::make('Modifier le résultat du membre')
                ->icon('note')
                ->method('createOrUpdate')
                ->canSee($this->quizmembre->exists),

            Button::make('Supprimer')
                ->icon('trash')
                ->method('remove')
                ->canSee($this->quizmembre->exists),
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
                Select::make('quizmembre.membre_id')
                    ->title('Membre')
                    ->placeholder('Choisir le membre')
                    ->options(
                        \App\Models\Membre::all()
                            ->mapWithKeys(function ($membre) {
                                return [$membre->id => trim("{$membre->prenom} {$membre->nom}")];
                            })
                            ->toArray())
                    ->empty('Choisir', 0),

                Select::make('quizmembre.quizquestion_id')
                    ->title('Question')
                    ->placeholder('Choisir la question')
                    ->fromModel(\App\Models\Quizquestion::class, 'titre')
                    ->empty('Choisir', 0),

                Select::make('quizmembre.quizreponse_id')
                    ->title('Reponse')
                    ->placeholder('Choisir la reponse')
                    ->fromModel(\App\Models\Quizreponse::class, 'text')
                    ->empty('Choisir', 0),

                Textarea::make('quizmembre.valeur')
                    ->title('Valeur')
                    ->placeholder('Saisir la valeur'),

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
    $data = $request->get('quizmembre');

    $this->quizmembre->fill($data)->save();

    Alert::info('Résultat du membre enregistré avec succès.');

    return redirect()->route('platform.quizmembre.list');
}

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function remove()
    {
        $this->quizmembre->delete();

        Alert::info('Vous avez supprimé le résultat du membre avec succès.');

        return redirect()->route('platform.quizmembre.list');
    }

}
