<?php

namespace App\Orchid\Screens\Conseillerprescription;

use Orchid\Screen\Screen;

use App\Models\Conseillerprescription;
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
     * @var Conseillerprescription
     */
    public $conseillerprescription;

    /**
     * Query data.
     *
     * @param Conseillerprescription $conseillerprescription
     *
     * @return array
     */
    public function query(Conseillerprescription $conseillerprescription): array
    {
        return [
            'conseillerprescription' => $conseillerprescription
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return $this->conseillerprescription->exists ? 'Modification de la prescription du conseiller' : 'Créer une prescription du conseiller';
    }

    /**
     * The description is displayed on the user's screen under the heading
     */
    public function description(): ?string
    {
        return "Toutes les prescriptions des conseillers enregistrées";
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Button::make('Créer une prescription du conseiller')
                ->icon('pencil')
                ->method('createOrUpdate')
                ->canSee(!$this->conseillerprescription->exists),

            Button::make('Modifier la prescription du conseiller')
                ->icon('note')
                ->method('createOrUpdate')
                ->canSee($this->conseillerprescription->exists),

            Button::make('Supprimer')
                ->icon('trash')
                ->method('remove')
                ->canSee($this->conseillerprescription->exists),
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
                Select::make('conseillerprescription.conseiller_id')
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

                Select::make('conseillerprescription.membre_id')
                    ->title('Membre')
                    ->placeholder('Choisir le membre')
                    ->options(
                        \App\Models\Membre::all()
                            ->mapWithKeys(function ($membre) {
                                return [$membre->id => trim("{$membre->prenom} {$membre->nom}")];
                            })
                            ->toArray())
                    ->empty('Choisir', 0),

                Select::make('conseillerprescription.entreprise_id')
                    ->title('Entreprise')
                    ->placeholder('Choisir le entreprise')
                    ->fromModel(\App\Models\Entreprise::class, 'nom')
                    ->empty('Choisir', 0),

                Select::make('conseillerprescription.prestation_id')
                    ->title('Prestation')
                    ->placeholder('Choisir la prestation')
                    ->fromModel(\App\Models\Prestation::class, 'titre')
                    ->empty('Choisir', 0),

                Select::make('conseillerprescription.formation_id')
                    ->title('Formation')
                    ->placeholder('Choisir la formation')
                    ->fromModel(\App\Models\Formation::class, 'titre')
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
    $data = $request->get('conseillerprescription');

    $this->conseillerprescription->fill($data)->save();

    Alert::info('Prescription du conseiller enregistré avec succès.');

    return redirect()->route('platform.conseillerprescription.list');
}

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function remove()
    {
        $this->conseillerprescription->delete();

        Alert::info('Vous avez supprimé la prescription du conseiller avec succès.');

        return redirect()->route('platform.conseillerprescription.list');
    }

}
