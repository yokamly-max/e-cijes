<?php

namespace App\Orchid\Screens\Conseillerentreprise;

use Orchid\Screen\Screen;

use App\Models\Conseillerentreprise;
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
     * @var Conseillerentreprise
     */
    public $conseillerentreprise;

    /**
     * Query data.
     *
     * @param Conseillerentreprise $conseillerentreprise
     *
     * @return array
     */
    public function query(Conseillerentreprise $conseillerentreprise): array
    {
        return [
            'conseillerentreprise' => $conseillerentreprise
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return $this->conseillerentreprise->exists ? 'Modification de l\'attribution de conseiller' : 'Créer une attribution de conseiller';
    }

    /**
     * The description is displayed on the user's screen under the heading
     */
    public function description(): ?string
    {
        return "Toutes les attributions de conseillers enregistrées";
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Button::make('Créer une attribution de conseiller')
                ->icon('pencil')
                ->method('createOrUpdate')
                ->canSee(!$this->conseillerentreprise->exists),

            Button::make('Modifier l\'attribution de conseiller')
                ->icon('note')
                ->method('createOrUpdate')
                ->canSee($this->conseillerentreprise->exists),

            Button::make('Supprimer')
                ->icon('trash')
                ->method('remove')
                ->canSee($this->conseillerentreprise->exists),
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

                Select::make('conseillerentreprise.conseiller_id')
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

                Select::make('conseillerentreprise.entreprise_id')
                    ->title('Entreprise')
                    ->placeholder('Choisir le entreprise')
                    ->fromModel(\App\Models\Entreprise::class, 'nom')
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
    $data = $request->get('conseillerentreprise');

    $this->conseillerentreprise->fill($data)->save();

    Alert::info('Attribution de conseiller enregistrée avec succès.');

    return redirect()->route('platform.conseillerentreprise.list');
}

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function remove()
    {
        $this->conseillerentreprise->delete();

        Alert::info('Vous avez supprimé l\'attribution de conseiller avec succès.');

        return redirect()->route('platform.conseillerentreprise.list');
    }

}
