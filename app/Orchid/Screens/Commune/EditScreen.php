<?php

namespace App\Orchid\Screens\Commune;

use Orchid\Screen\Screen;

use App\Models\Commune;
use Illuminate\Http\Request;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Select;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Actions\Button;
use Orchid\Support\Facades\Alert;

class EditScreen extends Screen
{
    /**
     * @var Commune
     */
    public $commune;

    /**
     * Query data.
     *
     * @param Commune $commune
     *
     * @return array
     */
    public function query(Commune $commune): array
    {
        return [
            'commune' => $commune
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return $this->commune->exists ? 'Modifier la commune' : 'Créer une nouvelle commune';
    }

    /**
     * The description is displayed on the user's screen under the heading
     */
    public function description(): ?string
    {
        return "Toutes les communes enregistrées";
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Button::make('Créer une commune')
                ->icon('pencil')
                ->method('createOrUpdate')
                ->canSee(!$this->commune->exists),

            Button::make('Modifier la commune')
                ->icon('note')
                ->method('createOrUpdate')
                ->canSee($this->commune->exists),

            Button::make('Supprimer')
                ->icon('trash')
                ->method('remove')
                ->canSee($this->commune->exists),
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
                Input::make('commune.nom')
                    ->title('Nom')
                    ->required()
                    ->placeholder('Saisir le nom'),
                    //->help('Spécifiez un nom pour cette commune.')

                Select::make('commune.prefecture_id')
                    ->title('Préfecture')
                    ->required()
                    ->placeholder('Choisir la préfecture')
                    //->help('Spécifiez une préfecture.')
                    ->fromModel(\App\Models\Prefecture::class, 'nom')
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
    $data = $request->get('commune');

    $this->commune->fill($data)->save();

    Alert::info('Commune enregistrée avec succès.');

    return redirect()->route('platform.commune.list');
}

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function remove()
    {
        $this->commune->delete();

        Alert::info('Vous avez supprimé la commune avec succès.');

        return redirect()->route('platform.commune.list');
    }

}
