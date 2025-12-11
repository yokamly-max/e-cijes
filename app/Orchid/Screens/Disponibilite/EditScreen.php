<?php

namespace App\Orchid\Screens\Disponibilite;

use Orchid\Screen\Screen;

use App\Models\Disponibilite;
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
     * @var Disponibilite
     */
    public $disponibilite;

    /**
     * Query data.
     *
     * @param Disponibilite $disponibilite
     *
     * @return array
     */
    public function query(Disponibilite $disponibilite): array
    {
        return [
            'disponibilite' => $disponibilite
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return $this->disponibilite->exists ? 'Modification de la disponibilité' : 'Créer une disponibilité';
    }

    /**
     * The description is displayed on the user's screen under the heading
     */
    public function description(): ?string
    {
        return "Toutes les disponibilités enregistrées";
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Button::make('Créer une disponibilité')
                ->icon('pencil')
                ->method('createOrUpdate')
                ->canSee(!$this->disponibilite->exists),

            Button::make('Modifier la disponibilité')
                ->icon('note')
                ->method('createOrUpdate')
                ->canSee($this->disponibilite->exists),

            Button::make('Supprimer')
                ->icon('trash')
                ->method('remove')
                ->canSee($this->disponibilite->exists),
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
                Select::make('disponibilite.expert_id')
                    ->title('Expert')
                    ->placeholder('Choisir l\'expert')
                    ->options(
                        \App\Models\Expert::with('membre')->get()
                            ->mapWithKeys(function ($expert) {
                                return [$expert->id => trim("{$expert->membre->prenom} {$expert->membre->nom}")];
                            })
                            ->toArray()
                    )
                    ->empty('Choisir', 0),

                Select::make('disponibilite.jour_id')
                    ->title('Jour')
                    ->placeholder('Choisir le jour')
                    ->fromModel(\App\Models\Jour::class, 'titre')
                    ->empty('Choisir', 0),

                Input::make('disponibilite.horairedebut')
                    ->title('Horaire début')
                    ->type('time')
                    ->required()
                    ->placeholder('Saisir l\'horaire début'),

                Input::make('disponibilite.horairefin')
                    ->title('Horaire fin')
                    ->type('time')
                    ->required()
                    ->placeholder('Saisir l\'horaire fin'),

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
    $data = $request->get('disponibilite');

    $this->disponibilite->fill($data)->save();

    Alert::info('Disponibilité enregistrée avec succès.');

    return redirect()->route('platform.disponibilite.list');
}

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function remove()
    {
        $this->disponibilite->delete();

        Alert::info('Vous avez supprimé la disponibilité avec succès.');

        return redirect()->route('platform.disponibilite.list');
    }

}
