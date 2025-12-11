<?php

namespace App\Orchid\Screens\Prestation;

use Orchid\Screen\Screen;

use App\Models\Prestation;
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
     * @var Prestation
     */
    public $prestation;

    /**
     * Query data.
     *
     * @param Prestation $prestation
     *
     * @return array
     */
    public function query(Prestation $prestation): array
    {
        return [
            'prestation' => $prestation
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return $this->prestation->exists ? 'Modification de la prestation' : 'Créer une prestation';
    }

    /**
     * The description is displayed on the user's screen under the heading
     */
    public function description(): ?string
    {
        return "Toutes les prestations enregistrées";
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Button::make('Créer une prestation')
                ->icon('pencil')
                ->method('createOrUpdate')
                ->canSee(!$this->prestation->exists),

            Button::make('Modifier la prestation')
                ->icon('note')
                ->method('createOrUpdate')
                ->canSee($this->prestation->exists),

            Button::make('Supprimer')
                ->icon('trash')
                ->method('remove')
                ->canSee($this->prestation->exists),
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
                Input::make('prestation.titre')
                    ->title('Titre')
                    ->required()
                    ->placeholder('Saisir le titre'),

                Input::make('prestation.prix')
                    ->title('Prix')
                    ->required()
                    ->placeholder('Saisir le prix'),
                    //->help('Spécifiez un prix pour cette prestation.')

                Input::make('prestation.duree')
                    ->title('Durée')
                    ->placeholder('Saisir la durée'),
                    //->help('Spécifiez un durée pour cette prestation.')

                Quill::make('prestation.description')
                    ->title('Description')
                    //->popover('Saisir la description')
                    ->placeholder('Saisir la description'),

                Select::make('prestation.prestationtype_id')
                    ->title('Type de la prestation')
                    ->placeholder('Choisir le type')
                    //->help('Spécifiez un type d\'prestation.')
                    ->fromModel(\App\Models\Prestationtype::class, 'titre')
                    ->empty('Choisir', 0),

                Select::make('prestation.entreprise_id')
                    ->title('Entreprise')
                    ->placeholder('Choisir l\'entreprise')
                    ->fromModel(\App\Models\Entreprise::class, 'nom')
                    ->empty('Choisir', 0),

                Select::make('prestation.pays_id')
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
    $data = $request->get('prestation');

    $this->prestation->fill($data)->save();

    Alert::info('Prestation enregistrée avec succès.');

    return redirect()->route('platform.prestation.list');
}

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function remove()
    {
        $this->prestation->delete();

        Alert::info('Vous avez supprimé la prestation avec succès.');

        return redirect()->route('platform.prestation.list');
    }

}
