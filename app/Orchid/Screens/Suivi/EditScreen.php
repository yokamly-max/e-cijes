<?php

namespace App\Orchid\Screens\Suivi;

use Orchid\Screen\Screen;

use App\Models\Suivi;
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
     * @var Suivi
     */
    public $suivi;

    /**
     * Query data.
     *
     * @param Suivi $suivi
     *
     * @return array
     */
    public function query(Suivi $suivi): array
    {
        return [
            'suivi' => $suivi
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return $this->suivi->exists ? 'Modification du suivi' : 'Créer un suivi';
    }

    /**
     * The description is displayed on the user's screen under the heading
     */
    public function description(): ?string
    {
        return "Tous les suivis enregistrés";
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Button::make('Créer un suivi')
                ->icon('pencil')
                ->method('createOrUpdate')
                ->canSee(!$this->suivi->exists),

            Button::make('Modifier le suivi')
                ->icon('note')
                ->method('createOrUpdate')
                ->canSee($this->suivi->exists),

            Button::make('Supprimer')
                ->icon('trash')
                ->method('remove')
                ->canSee($this->suivi->exists),
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
                Select::make('suivi.accompagnement_id')
                    ->title('Accompagnement')
                    ->placeholder('Choisir l\'accompagnement')
                    ->options(
                        \App\Models\Accompagnement::with('membre', 'entreprise')->get()
                            ->mapWithKeys(function ($accompagnement) {
                                $membre = $accompagnement->membre ? $accompagnement->membre->prenom . ' ' . $accompagnement->membre->nom : '';
                                $entreprise = $accompagnement->entreprise ? $accompagnement->entreprise->nom : '';
                                return [$accompagnement->id => "$membre - $entreprise"];
                            })
                            ->toArray()
                    )
                    ->empty('Choisir', 0),

                DateTimer::make('suivi.datesuivi')
                    ->title('Date du suivi')
                    ->required()
                    ->format('Y-m-d'),

                TextArea::make('suivi.observation')
                    ->title('Observation')
                    ->placeholder('Saisir l\'observation'),

                Select::make('suivi.suivitype_id')
                    ->title('Type du suivi')
                    ->placeholder('Choisir le type')
                    ->fromModel(\App\Models\Suivitype::class, 'titre')
                    ->empty('Choisir', 0),

                Select::make('suivi.suivistatut_id')
                    ->title('Statut du suivi')
                    ->placeholder('Choisir le statut')
                    ->fromModel(\App\Models\Suivistatut::class, 'titre')
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
    $data = $request->get('suivi');

    $this->suivi->fill($data)->save();

    Alert::info('Suivi enregistré avec succès.');

    return redirect()->route('platform.suivi.list');
}

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function remove()
    {
        $this->suivi->delete();

        Alert::info('Vous avez supprimé le suivi avec succès.');

        return redirect()->route('platform.suivi.list');
    }

}
