<?php

namespace App\Orchid\Screens\Accompagnementconseiller;

use Orchid\Screen\Screen;

use App\Models\Accompagnementconseiller;
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
     * @var Accompagnementconseiller
     */
    public $accompagnementconseiller;

    /**
     * Query data.
     *
     * @param Accompagnementconseiller $accompagnementconseiller
     *
     * @return array
     */
    public function query(Accompagnementconseiller $accompagnementconseiller): array
    {
        return [
            'accompagnementconseiller' => $accompagnementconseiller
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return $this->accompagnementconseiller->exists ? 'Modification du conseiller de l\'accompagnement' : 'Créer un conseiller de l\'accompagnement';
    }

    /**
     * The description is displayed on the user's screen under the heading
     */
    public function description(): ?string
    {
        return "Tous les conseillers des accompagnements enregistrés";
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Button::make('Créer un conseiller de l\'accompagnement')
                ->icon('pencil')
                ->method('createOrUpdate')
                ->canSee(!$this->accompagnementconseiller->exists),

            Button::make('Modifier le conseiller de l\'accompagnement')
                ->icon('note')
                ->method('createOrUpdate')
                ->canSee($this->accompagnementconseiller->exists),

            Button::make('Supprimer')
                ->icon('trash')
                ->method('remove')
                ->canSee($this->accompagnementconseiller->exists),
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
                Select::make('accompagnementconseiller.accompagnement_id')
                    ->title('Accompagnement')
                    ->placeholder('Choisir l\'accompagnement')
                    //->help('Spécifiez un accompagnement.')
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


                DateTimer::make('accompagnementconseiller.datedebut')
                    ->title('Date de début')
                    ->required()
                    ->format('Y-m-d'),

                DateTimer::make('accompagnementconseiller.datefin')
                    ->title('Date de fin')
                    ->required()
                    ->format('Y-m-d'),

                TextArea::make('accompagnementconseiller.observation')
                    ->title('Observation')
                    ->placeholder('Saisir l\'observation'),

                Select::make('accompagnementconseiller.conseiller_id')
                    ->title('Conseiller')
                    ->placeholder('Choisir le conseiller')
                    ->options(
                        \App\Models\Conseiller::with('membre')->get()
                            ->mapWithKeys(function ($conseiller) {
                                return [$conseiller->id => trim("{$conseiller->membre->prenom} {$conseiller->membre->nom}")];
                            })
                            ->toArray()
                    )
                    ->empty('Choisir', 0),

                Input::make('accompagnementconseiller.montant')
                    ->title('Montant')
                    ->placeholder('Saisir le montant'),

                Select::make('accompagnementconseiller.accompagnementtype_id')
                    ->title('Type du conseiller de l\'accompagnement')
                    ->placeholder('Choisir le type')
                    ->fromModel(\App\Models\Accompagnementtype::class, 'titre')
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
    $data = $request->get('accompagnementconseiller');

    $this->accompagnementconseiller->fill($data)->save();

    Alert::info('Conseiller de l\'accompagnement enregistré avec succès.');

    return redirect()->route('platform.accompagnementconseiller.list');
}

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function remove()
    {
        $this->accompagnementconseiller->delete();

        Alert::info('Vous avez supprimé le conseiller de l\'accompagnement avec succès.');

        return redirect()->route('platform.accompagnementconseiller.list');
    }

}
