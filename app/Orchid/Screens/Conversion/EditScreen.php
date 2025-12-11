<?php

namespace App\Orchid\Screens\Conversion;

use Orchid\Screen\Screen;

use App\Models\Conversion;
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
     * @var Conversion
     */
    public $conversion;

    /**
     * Query data.
     *
     * @param Conversion $conversion
     *
     * @return array
     */
    public function query(Conversion $conversion): array
    {
        return [
            'conversion' => $conversion
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return $this->conversion->exists ? 'Modification de la conversion' : 'Créer une conversion';
    }

    /**
     * The description is displayed on the user's screen under the heading
     */
    public function description(): ?string
    {
        return "Toutes les conversions enregistrées";
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Button::make('Créer une conversion')
                ->icon('pencil')
                ->method('createOrUpdate')
                ->canSee(!$this->conversion->exists),

            Button::make('Modifier la conversion')
                ->icon('note')
                ->method('createOrUpdate')
                ->canSee($this->conversion->exists),

            Button::make('Supprimer')
                ->icon('trash')
                ->method('remove')
                ->canSee($this->conversion->exists),
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
                Input::make('conversion.taux')
                    ->title('Taux')
                    ->require()
                    ->placeholder('Saisir le taux'),

                Select::make('conversion.ressourcetransaction_source_id')
                    ->title('Transaction source')
                    ->placeholder('Choisir la source')
                    //->help('Spécifiez la source.')
                    ->options(
                        \App\Models\Ressourcetransaction::all()
                            ->mapWithKeys(function ($ressourcetransactionsource) {
                                return [$ressourcetransactionsource->id => trim("{$ressourcetransactionsource->reference}")];
                            })
                            ->toArray())
                    ->empty('Choisir', 0),

                Select::make('conversion.ressourcetransaction_cible_id')
                    ->title('Transaction cible')
                    ->placeholder('Choisir la cible')
                    //->help('Spécifiez la source.')
                    ->options(
                        \App\Models\Ressourcetransaction::all()
                            ->mapWithKeys(function ($ressourcetransactioncible) {
                                return [$ressourcetransactioncible->id => trim("{$ressourcetransactioncible->reference}")];
                            })
                            ->toArray())
                    ->empty('Choisir', 0),

                Select::make('conversion.membre_id')
                    ->title('Membre')
                    ->placeholder('Choisir le membre')
                    ->options(
                        \App\Models\Membre::all()
                            ->mapWithKeys(function ($membre) {
                                return [$membre->id => trim("{$membre->prenom} {$membre->nom}")];
                            })
                            ->toArray())
                    ->empty('Choisir', 0),

                Select::make('conversion.entreprise_id')
                    ->title('Entreprise')
                    ->placeholder('Choisir l\'entreprise')
                    ->fromModel(\App\Models\Entreprise::class, 'nom')
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
        $data = $request->get('conversion');

        $this->conversion->fill($data)->save();

        Alert::info('Conversion enregistré avec succès.');

        return redirect()->route('platform.conversion.list');
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function remove()
    {
        $this->conversion->delete();

        Alert::info('Vous avez supprimé le conversion avec succès.');

        return redirect()->route('platform.conversion.list');
    }

}
