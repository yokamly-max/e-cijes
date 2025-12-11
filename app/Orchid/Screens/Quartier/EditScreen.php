<?php

namespace App\Orchid\Screens\Quartier;

use Orchid\Screen\Screen;

use App\Models\Quartier;
use Illuminate\Http\Request;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Select;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Actions\Button;
use Orchid\Support\Facades\Alert;

class EditScreen extends Screen
{
    /**
     * @var Quartier
     */
    public $quartier;

    /**
     * Query data.
     *
     * @param Quartier $quartier
     *
     * @return array
     */
    public function query(Quartier $quartier): array
    {
        return [
            'quartier' => $quartier
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return $this->quartier->exists ? 'Modifier le quartier' : 'Créer un nouveau quartier';
    }

    /**
     * The description is displayed on the user's screen under the heading
     */
    public function description(): ?string
    {
        return "Toutes les quartiers enregistrés";
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Button::make('Créer un quartier')
                ->icon('pencil')
                ->method('createOrUpdate')
                ->canSee(!$this->quartier->exists),

            Button::make('Modifier le quartier')
                ->icon('note')
                ->method('createOrUpdate')
                ->canSee($this->quartier->exists),

            Button::make('Supprimer')
                ->icon('trash')
                ->method('remove')
                ->canSee($this->quartier->exists),
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
                Input::make('quartier.nom')
                    ->title('Nom')
                    ->required()
                    ->placeholder('Saisir le nom'),
                    //->help('Spécifiez un nom pour cette quartier.')

                Select::make('quartier.commune_id')
                    ->title('Commune')
                    ->required()
                    ->placeholder('Choisir la commune')
                    //->help('Spécifiez une commune.')
                    ->fromModel(\App\Models\Commune::class, 'nom')
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
    $data = $request->get('quartier');

    $this->quartier->fill($data)->save();

    Alert::info('Quartier enregistré avec succès.');

    return redirect()->route('platform.quartier.list');
}

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function remove()
    {
        $this->quartier->delete();

        Alert::info('Vous avez supprimé le quartier avec succès.');

        return redirect()->route('platform.quartier.list');
    }

}
