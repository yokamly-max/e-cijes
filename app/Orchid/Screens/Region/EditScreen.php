<?php

namespace App\Orchid\Screens\Region;

use Orchid\Screen\Screen;

use App\Models\Region;
use App\Models\Pays;

use Illuminate\Http\Request;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Select;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Actions\Button;
use Orchid\Support\Facades\Alert;

class EditScreen extends Screen
{
    /**
     * @var Region
     */
    public $region;

    /**
     * Query data.
     *
     * @param Region $region
     *
     * @return array
     */
    public function query(Region $region): array
    {
        return [
            'region' => $region
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return $this->region->exists ? 'Modifier la région' : 'Créer une nouvelle région';
    }

    /**
     * The description is displayed on the user's screen under the heading
     */
    public function description(): ?string
    {
        return "Toutes les régions enregistrées";
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Button::make('Créer une région')
                ->icon('pencil')
                ->method('createOrUpdate')
                ->canSee(!$this->region->exists),

            Button::make('Modifier la région')
                ->icon('note')
                ->method('createOrUpdate')
                ->canSee($this->region->exists),

            Button::make('Supprimer')
                ->icon('trash')
                ->method('remove')
                ->canSee($this->region->exists),
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
                Input::make('region.nom')
                    ->title('Nom')
                    ->required()
                    ->placeholder('Saisir le nom'),

                Input::make('region.code')
                    ->title('Code')
                    ->placeholder('Saisir le code'),

                Select::make('region.pays_id')
                    ->title('Pays')
                    ->required()
                    ->placeholder('Choisir le pays')
                    ->options($paysList)
                    ->empty('Choisir', 0),
            ]),
        ];
    }
    

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function createOrUpdate(Request $request)
{
    $data = $request->get('region');

    $this->region->fill($data)->save();

    Alert::info('Région enregistrée avec succès.');

    return redirect()->route('platform.region.list');
}

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function remove()
    {
        $this->region->delete();

        Alert::info('Vous avez supprimé la région avec succès.');

        return redirect()->route('platform.region.list');
    }

}
