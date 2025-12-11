<?php

namespace App\Orchid\Screens\Bonutilise;

use Orchid\Screen\Screen;

use App\Models\Bonutilise;
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
     * @var Bonutilise
     */
    public $bonutilise;

    /**
     * Query data.
     *
     * @param Bonutilise $bonutilise
     *
     * @return array
     */
    public function query(Bonutilise $bonutilise): array
    {
        return [
            'bonutilise' => $bonutilise
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return $this->bonutilise->exists ? 'Modification du bon utilisé' : 'Créer un bon utilisé';
    }

    /**
     * The description is displayed on the user's screen under the heading
     */
    public function description(): ?string
    {
        return "Toutes les bons utilisés enregistrés";
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Button::make('Créer un bon utilisé')
                ->icon('pencil')
                ->method('createOrUpdate')
                ->canSee(!$this->bonutilise->exists),

            Button::make('Modifier le bon utilisé')
                ->icon('note')
                ->method('createOrUpdate')
                ->canSee($this->bonutilise->exists),

            Button::make('Supprimer')
                ->icon('trash')
                ->method('remove')
                ->canSee($this->bonutilise->exists),
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
                Input::make('bonutilise.montant')
                    ->title('Montant')
                    ->required()
                    ->placeholder('Saisir le montant'),

                TextArea::make('bonutilise.noteservice')
                    ->title('Note de service')
                    ->placeholder('Saisir la note de service'),

                Select::make('bonutilise.bon_id')
                    ->title('Bon')
                    ->placeholder('Choisir le bon')
                    ->fromModel(\App\Models\Bon::class, 'montant')
                    ->empty('Choisir', 0),

                Select::make('bonutilise.prestationrealisee_id')
                    ->title('Prestation realisée')
                    ->placeholder('Choisir la prestation')
                    ->fromModel(\App\Models\Prestationrealisee::class, 'note')
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
    $data = $request->get('bonutilise');

    $this->bonutilise->fill($data)->save();

    Alert::info('Bon utilisé enregistré avec succès.');

    return redirect()->route('platform.bonutilise.list');
}

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function remove()
    {
        $this->bonutilise->delete();

        Alert::info('Vous avez supprimé la bon utilisé avec succès.');

        return redirect()->route('platform.bonutilise.list');
    }

}
