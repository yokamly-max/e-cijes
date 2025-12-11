<?php

namespace App\Orchid\Screens\Diagnosticresultat;

use Orchid\Screen\Screen;

use App\Models\Diagnosticresultat;
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
     * @var Diagnosticresultat
     */
    public $diagnosticresultat;

    /**
     * Query data.
     *
     * @param Diagnosticresultat $diagnosticresultat
     *
     * @return array
     */
    public function query(Diagnosticresultat $diagnosticresultat): array
    {
        return [
            'diagnosticresultat' => $diagnosticresultat
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return $this->diagnosticresultat->exists ? 'Modification du résultat du diagnostic' : 'Créer un résultat du diagnostic';
    }

    /**
     * The description is displayed on the user's screen under the heading
     */
    public function description(): ?string
    {
        return "Tous les résultats des diagnostics enregistrés";
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Button::make('Créer un résultat du diagnostic')
                ->icon('pencil')
                ->method('createOrUpdate')
                ->canSee(!$this->diagnosticresultat->exists),

            Button::make('Modifier le résultat du diagnostic')
                ->icon('note')
                ->method('createOrUpdate')
                ->canSee($this->diagnosticresultat->exists),

            Button::make('Supprimer')
                ->icon('trash')
                ->method('remove')
                ->canSee($this->diagnosticresultat->exists),
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
                Select::make('diagnosticresultat.diagnostic_id')
                    ->title('Diagnostic Session')
                    ->placeholder('Choisir le diagnostic')
                    ->options(
                        \App\Models\Diagnostic::with('membre', 'entreprise')->get()
                            ->mapWithKeys(function ($diagnostic) {
                                $membre = $diagnostic->membre ? trim("{$diagnostic->membre->prenom} {$diagnostic->membre->nom}") : '';
                                $entreprise = $diagnostic->entreprise ? $diagnostic->entreprise->nom : '';
                                return [
                                    $diagnostic->id => "Diagnostic #{$diagnostic->id} - $membre - $entreprise (Score: {$diagnostic->scoreglobal})"
                                ];
                            })
                            ->toArray()
                    )
                    ->empty('Choisir', 0),

                Select::make('diagnosticresultat.diagnosticquestion_id')
                    ->title('Question')
                    ->placeholder('Choisir la question')
                    ->fromModel(\App\Models\Diagnosticquestion::class, 'titre')
                    ->empty('Choisir', 0),

                Select::make('diagnosticresultat.diagnosticreponse_id')
                    ->title('Réponse')
                    ->placeholder('Choisir la réponse')
                    ->fromModel(\App\Models\Diagnosticreponse::class, 'titre')
                    ->empty('Choisir', 0),

                Input::make('diagnosticresultat.reponsetexte')
                    ->title('Réponse texte')
                    ->placeholder('Saisir la réponse'),

                TextArea::make('diagnosticresultat.diagnosticreponseids')
                    ->title('Les réponses')
                    ->placeholder('Saisir les réponses'),

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
    $data = $request->get('diagnosticresultat');

    $this->diagnosticresultat->fill($data)->save();

    Alert::info('Résultat du diagnostic enregistré avec succès.');

    return redirect()->route('platform.diagnosticresultat.list');
}

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function remove()
    {
        $this->diagnosticresultat->delete();

        Alert::info('Vous avez supprimé le résultat du diagnostic avec succès.');

        return redirect()->route('platform.diagnosticresultat.list');
    }

}
