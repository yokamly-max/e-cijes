<?php

namespace App\Orchid\Screens\Formation;

use Orchid\Screen\Screen;

use App\Models\Formation;
use App\Models\Pays;

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
     * @var Formation
     */
    public $formation;

    /**
     * Query data.
     *
     * @param Formation $formation
     *
     * @return array
     */
    public function query(Formation $formation): array
    {
        return [
            'formation' => $formation
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return $this->formation->exists ? 'Modification de la formation' : 'Créer une formation';
    }

    /**
     * The description is displayed on the user's screen under the heading
     */
    public function description(): ?string
    {
        return "Toutes les formations enregistrées";
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Button::make('Créer une formation')
                ->icon('pencil')
                ->method('createOrUpdate')
                ->canSee(!$this->formation->exists),

            Button::make('Modifier la formation')
                ->icon('note')
                ->method('createOrUpdate')
                ->canSee($this->formation->exists),

            Button::make('Supprimer')
                ->icon('trash')
                ->method('remove')
                ->canSee($this->formation->exists),
        ];
    }

    /**
     * The screen's layout elements.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): iterable
    {
        // Récupérer les pays via l'API Supabase et créer un tableau [id => nom]
        $paysModel = new Pays();
        $paysList = collect($paysModel->all())->pluck('name', 'id')->toArray();

        return [
            Layout::rows([
                Input::make('formation.titre')
                    ->title('Titre')
                    ->required()
                    ->placeholder('Saisir le titre'),

                DateTimer::make('formation.datedebut')
                    ->title('Date début')
                    ->required()
                    ->format('Y-m-d'),

                DateTimer::make('formation.datefin')
                    ->title('Date fin')
                    ->format('Y-m-d'),

                Input::make('formation.prix')
                    ->title('Prix')
                    ->placeholder('Saisir le prix'),

                Quill::make('formation.description')
                    ->title('Description')
                    //->popover('Saisir la description')
                    ->placeholder('Saisir la description'),

                Select::make('formation.formationtype_id')
                    ->title('Type de la formation')
                    ->placeholder('Choisir le type')
                    //->help('Spécifiez un type d\'formation.')
                    ->fromModel(\App\Models\Formationtype::class, 'titre')
                    ->empty('Choisir', 0),

                Select::make('formation.formationniveau_id')
                    ->title('Niveau de la formation')
                    ->placeholder('Choisir le niveau')
                    //->help('Spécifiez un niveau d\'formation.')
                    ->fromModel(\App\Models\Formationniveau::class, 'titre')
                    ->empty('Choisir', 0),

                Select::make('formation.expert_id')
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

                Select::make('formation.pays_id')
                    ->title('Pays')
                    ->placeholder('Choisir le pays')
                    ->options($paysList)
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
    $data = $request->get('formation');

    $this->formation->fill($data)->save();

    Alert::info('Formation enregistrée avec succès.');

    return redirect()->route('platform.formation.list');
}

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function remove()
    {
        $this->formation->delete();

        Alert::info('Vous avez supprimé la formation avec succès.');

        return redirect()->route('platform.formation.list');
    }

}
