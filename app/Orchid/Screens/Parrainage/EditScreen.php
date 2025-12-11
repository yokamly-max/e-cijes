<?php

namespace App\Orchid\Screens\Parrainage;

use Orchid\Screen\Screen;

use App\Models\Parrainage;
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
     * @var Parrainage
     */
    public $parrainage;

    /**
     * Query data.
     *
     * @param Parrainage $parrainage
     *
     * @return array
     */
    public function query(Parrainage $parrainage): array
    {
        return [
            'parrainage' => $parrainage
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return $this->parrainage->exists ? 'Modification du parrainage' : 'Créer un parrainage';
    }

    /**
     * The description is displayed on the user's screen under the heading
     */
    public function description(): ?string
    {
        return "Tous les parrainages enregistrés";
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Button::make('Créer un parrainage')
                ->icon('pencil')
                ->method('createOrUpdate')
                ->canSee(!$this->parrainage->exists),

            Button::make('Modifier le parrainage')
                ->icon('note')
                ->method('createOrUpdate')
                ->canSee($this->parrainage->exists),

            Button::make('Supprimer')
                ->icon('trash')
                ->method('remove')
                ->canSee($this->parrainage->exists),
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
                Input::make('parrainage.lien')
                    ->title('Lien')
                    ->require()
                    ->placeholder('Saisir le lien'),

                Select::make('parrainage.membre_parrain_id')
                    ->title('Membre parrain')
                    ->placeholder('Choisir le membre')
                    //->help('Spécifiez un membre.')
                    ->options(
                        \App\Models\Membre::all()
                            ->mapWithKeys(function ($membreparrain) {
                                return [$membreparrain->id => trim("{$membreparrain->prenom} {$membreparrain->nom}")];
                            })
                            ->toArray())
                    ->empty('Choisir', 0),

                Select::make('parrainage.membre_filleul_id')
                    ->title('Membre filleul')
                    ->placeholder('Choisir le membre')
                    //->help('Spécifiez un membre.')
                    ->options(
                        \App\Models\Membre::all()
                            ->mapWithKeys(function ($membrefilleul) {
                                return [$membrefilleul->id => trim("{$membrefilleul->prenom} {$membrefilleul->nom}")];
                            })
                            ->toArray())
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
        $data = $request->get('parrainage');

        $this->parrainage->fill($data)->save();

        Alert::info('Parrainage enregistré avec succès.');

        return redirect()->route('platform.parrainage.list');
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function remove()
    {
        $this->parrainage->delete();

        Alert::info('Vous avez supprimé le parrainage avec succès.');

        return redirect()->route('platform.parrainage.list');
    }

}
