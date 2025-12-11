<?php

namespace App\Orchid\Screens\Prefecture;

use Orchid\Screen\Screen;

use App\Models\Prefecture;
use Illuminate\Http\Request;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Select;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Actions\Button;
use Orchid\Support\Facades\Alert;

class EditScreen extends Screen
{
    /**
     * @var Prefecture
     */
    public $prefecture;

    /**
     * Query data.
     *
     * @param Prefecture $prefecture
     *
     * @return array
     */
    public function query(Prefecture $prefecture): array
    {
        return [
            'prefecture' => $prefecture
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return $this->prefecture->exists ? 'Modifier la préfecture' : 'Créer une nouvelle préfecture';
    }

    /**
     * The description is displayed on the user's screen under the heading
     */
    public function description(): ?string
    {
        return "Toutes les préfectures enregistrées";
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Button::make('Créer une préfecture')
                ->icon('pencil')
                ->method('createOrUpdate')
                ->canSee(!$this->prefecture->exists),

            Button::make('Modifier la préfecture')
                ->icon('note')
                ->method('createOrUpdate')
                ->canSee($this->prefecture->exists),

            Button::make('Supprimer')
                ->icon('trash')
                ->method('remove')
                ->canSee($this->prefecture->exists),
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
                Input::make('prefecture.nom')
                    ->title('Nom')
                    ->required()
                    ->placeholder('Saisir le nom'),
                    //->help('Spécifiez un nom pour cette préfecture.')

                Input::make('prefecture.cheflieu')
                    ->title('Chef lieu')
                    ->placeholder('Saisir le chef lieu'),
                    //->help('Spécifiez un chef lieu pour cette préfecture.')

                Select::make('prefecture.region_id')
                    ->title('Région')
                    ->required()
                    ->placeholder('Choisir la région')
                    //->help('Spécifiez une région.')
                    ->fromModel(\App\Models\Region::class, 'nom')
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
    $data = $request->get('prefecture');

    $this->prefecture->fill($data)->save();

    Alert::info('Préfecture enregistrée avec succès.');

    return redirect()->route('platform.prefecture.list');
}

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function remove()
    {
        $this->prefecture->delete();

        Alert::info('Vous avez supprimé la préfecture avec succès.');

        return redirect()->route('platform.prefecture.list');
    }

}
