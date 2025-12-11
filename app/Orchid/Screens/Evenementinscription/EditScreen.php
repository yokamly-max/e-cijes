<?php

namespace App\Orchid\Screens\Evenementinscription;

use Orchid\Screen\Screen;

use App\Models\Evenementinscription;
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
     * @var Evenementinscription
     */
    public $evenementinscription;

    /**
     * Query data.
     *
     * @param Evenementinscription $evenementinscription
     *
     * @return array
     */
    public function query(Evenementinscription $evenementinscription): array
    {
        return [
            'evenementinscription' => $evenementinscription
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return $this->evenementinscription->exists ? 'Modification de l\'inscription à l\'évènement' : 'Créer une inscription à l\'évènement';
    }

    /**
     * The description is displayed on the user's screen under the heading
     */
    public function description(): ?string
    {
        return "Toutes les inscriptions à un évènement enregistrés";
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Button::make('Créer une inscription à un évènement')
                ->icon('pencil')
                ->method('createOrUpdate')
                ->canSee(!$this->evenementinscription->exists),

            Button::make('Modifier l\'inscription à un évènement')
                ->icon('note')
                ->method('createOrUpdate')
                ->canSee($this->evenementinscription->exists),

            Button::make('Supprimer')
                ->icon('trash')
                ->method('remove')
                ->canSee($this->evenementinscription->exists),
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
                DateTimer::make('evenementinscription.dateevenementinscription')
                    ->title('Date de l\'inscription à un évènement')
                    ->format('Y-m-d'),

                Select::make('evenementinscription.membre_id')
                    ->title('Membre')
                    ->placeholder('Choisir le membre')
                    ->options(
                        \App\Models\Membre::all()
                            ->mapWithKeys(function ($membre) {
                                return [$membre->id => trim("{$membre->prenom} {$membre->nom}")];
                            })
                            ->toArray())
                    ->empty('Choisir', 0),

                Select::make('evenementinscription.evenement_id')
                    ->title('Evènement')
                    ->placeholder('Choisir l\'évènement')
                    ->fromModel(\App\Models\Evenement::class, 'titre')
                    ->empty('Choisir', 0),

                Select::make('evenementinscription.evenementinscriptiontype_id')
                    ->title('Type d\'inscription à un évènement')
                    ->placeholder('Choisir le type')
                    ->fromModel(\App\Models\Evenementinscriptiontype::class, 'titre')
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
    $data = $request->get('evenementinscription');

    $this->evenementinscription->fill($data)->save();

    Alert::info('Inscription à l\'évènement enregistrée avec succès.');

    return redirect()->route('platform.evenementinscription.list');
}

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function remove()
    {
        $this->evenementinscription->delete();

        Alert::info('Vous avez supprimé l\'inscription à l\'évènement avec succès.');

        return redirect()->route('platform.evenementinscription.list');
    }

}
