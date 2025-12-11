<?php

namespace App\Orchid\Screens\Echeancier;

use Orchid\Screen\Screen;

use App\Models\Echeancier;
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
     * @var Echeancier
     */
    public $echeancier;

    /**
     * Query data.
     *
     * @param Echeancier $echeancier
     *
     * @return array
     */
    public function query(Echeancier $echeancier): array
    {
        return [
            'echeancier' => $echeancier
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return $this->echeancier->exists ? 'Modification d\'échéancier' : 'Créer un échéancier';
    }

    /**
     * The description is displayed on the user's screen under the heading
     */
    public function description(): ?string
    {
        return "Tous les échéanciers enregistrés";
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Button::make('Créer un échéancier')
                ->icon('pencil')
                ->method('createOrUpdate')
                ->canSee(!$this->echeancier->exists),

            Button::make('Modifier l\'échéancier')
                ->icon('note')
                ->method('createOrUpdate')
                ->canSee($this->echeancier->exists),

            Button::make('Supprimer')
                ->icon('trash')
                ->method('remove')
                ->canSee($this->echeancier->exists),
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
                Select::make('echeancier.entreprise_id')
                    ->title('Entreprise')
                    ->placeholder('Choisir l\'entreprise')
                    ->fromModel(\App\Models\Entreprise::class, 'nom')
                    ->empty('Choisir', 0),

                DateTimer::make('echeancier.dateecheancier')
                    ->title('Date de l\'échéancier')
                    ->format('Y-m-d'),

                Input::make('echeancier.montant')
                    ->title('Montant')
                    ->required()
                    ->placeholder('Saisir le montant'),

                Select::make('echeancier.echeancierstatut_id')
                    ->title('Statut de l\'échéancier')
                    ->placeholder('Choisir le statut')
                    ->fromModel(\App\Models\Echeancierstatut::class, 'titre')
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
    $data = $request->get('echeancier');

    $this->echeancier->fill($data)->save();

    Alert::info('Echéancier enregistré avec succès.');

    return redirect()->route('platform.echeancier.list');
}

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function remove()
    {
        $this->echeancier->delete();

        Alert::info('Vous avez supprimé l\'échéancier avec succès.');

        return redirect()->route('platform.echeancier.list');
    }

}
