<?php

namespace App\Orchid\Screens\Prestationrealisee;

use Orchid\Screen\Screen;

use App\Models\Prestationrealisee;
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
     * @var Prestationrealisee
     */
    public $prestationrealisee;

    /**
     * Query data.
     *
     * @param Prestationrealisee $prestationrealisee
     *
     * @return array
     */
    public function query(Prestationrealisee $prestationrealisee): array
    {
        return [
            'prestationrealisee' => $prestationrealisee
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return $this->prestationrealisee->exists ? 'Modification de la réalisation' : 'Créer une réalisation';
    }

    /**
     * The description is displayed on the user's screen under the heading
     */
    public function description(): ?string
    {
        return "Toutes les réalisations enregistrées";
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Button::make('Créer une réalisation')
                ->icon('pencil')
                ->method('createOrUpdate')
                ->canSee(!$this->prestationrealisee->exists),

            Button::make('Modifier la réalisation')
                ->icon('note')
                ->method('createOrUpdate')
                ->canSee($this->prestationrealisee->exists),

            Button::make('Supprimer')
                ->icon('trash')
                ->method('remove')
                ->canSee($this->prestationrealisee->exists),
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
                Input::make('prestationrealisee.note')
                    ->title('Note')
                    ->required()
                    ->placeholder('Saisir le note'),

                TextArea::make('prestationrealisee.feedback')
                    ->title('Feedback')
                    ->placeholder('Saisir le feedback'),

                DateTimer::make('prestationrealisee.daterealisation')
                    ->title('Date de la réalisation')
                    ->format('Y-m-d'),

                Select::make('prestationrealisee.accompagnement_id')
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

                Select::make('prestationrealisee.prestation_id')
                    ->title('Prestation')
                    ->placeholder('Choisir la prestation')
                    ->fromModel(\App\Models\Prestation::class, 'titre')
                    ->empty('Choisir', 0),

                Select::make('prestationrealisee.prestationrealiseestatut_id')
                    ->title('Statut de la prestation')
                    ->placeholder('Choisir le statut')
                    ->fromModel(\App\Models\Prestationrealiseestatut::class, 'titre')
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
    $data = $request->get('prestationrealisee');

    $this->prestationrealisee->fill($data)->save();

    Alert::info('Réalisation enregistrée avec succès.');

    return redirect()->route('platform.prestationrealisee.list');
}

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function remove()
    {
        $this->prestationrealisee->delete();

        Alert::info('Vous avez supprimé la réalisation avec succès.');

        return redirect()->route('platform.prestationrealisee.list');
    }

}
