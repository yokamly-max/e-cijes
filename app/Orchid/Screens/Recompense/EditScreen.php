<?php

namespace App\Orchid\Screens\Recompense;

use Orchid\Screen\Screen;

use App\Models\Recompense;
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
     * @var Recompense
     */
    public $recompense;

    /**
     * Query data.
     *
     * @param Recompense $recompense
     *
     * @return array
     */
    public function query(Recompense $recompense): array
    {
        return [
            'recompense' => $recompense
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return $this->recompense->exists ? 'Modification de la récompense' : 'Créer une récompense';
    }

    /**
     * The description is displayed on the user's screen under the heading
     */
    public function description(): ?string
    {
        return "Toutes les récompenses enregistrées";
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Button::make('Créer une récompense')
                ->icon('pencil')
                ->method('createOrUpdate')
                ->canSee(!$this->recompense->exists),

            Button::make('Modifier la récompense')
                ->icon('note')
                ->method('createOrUpdate')
                ->canSee($this->recompense->exists),

            Button::make('Supprimer')
                ->icon('trash')
                ->method('remove')
                ->canSee($this->recompense->exists),
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
                Select::make('recompense.membre_id')
                    ->title('Membre')
                    ->placeholder('Choisir le membre')
                    ->options(
                        \App\Models\Membre::all()
                            ->mapWithKeys(function ($membre) {
                                return [$membre->id => trim("{$membre->prenom} {$membre->nom}")];
                            })
                            ->toArray())
                    ->empty('Choisir', 0),
                
                Select::make('recompense.entreprise_id')
                    ->title('Entreprise')
                    ->placeholder('Choisir l\'entreprise')
                    ->fromModel(\App\Models\Entreprise::class, 'nom')
                    ->empty('Choisir', 0),
                
                Select::make('recompense.action_id')
                    ->title('Action')
                    ->placeholder('Choisir l\'action')
                    ->fromModel(\App\Models\Action::class, 'titre')
                    ->empty('Choisir', 0),

                Select::make('recompense.ressourcetype_id')
                    ->title('Type')
                    ->placeholder('Choisir le type')
                    ->fromModel(\App\Models\Ressourcetype::class, 'titre')
                    ->empty('Choisir', 0),

                Input::make('recompense.valeur')
                    ->title('Valeur')
                    ->required()
                    ->placeholder('Saisir la valeur'),

                DateTimer::make('recompense.dateattribution')
                    ->title('Date de la récompense')
                    ->format('Y-m-d'),

                Input::make('recompense.source_id')
                    ->title('Source')
                    ->placeholder('Saisir la source id'),

                TextArea::make('recompense.commentaire')
                    ->title('Commentaire')
                    ->placeholder('Saisir le commentaire'),

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
    $data = $request->get('recompense');

    $this->recompense->fill($data)->save();

    Alert::info('Récompense enregistrée avec succès.');

    return redirect()->route('platform.recompense.list');
}

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function remove()
    {
        $this->recompense->delete();

        Alert::info('Vous avez supprimé la récompense avec succès.');

        return redirect()->route('platform.recompense.list');
    }

}
