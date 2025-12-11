<?php

namespace App\Orchid\Screens\Ressourcetransaction;

use Orchid\Screen\Screen;

use App\Models\Ressourcetransaction;
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
     * @var Ressourcetransaction
     */
    public $ressourcetransaction;

    /**
     * Query data.
     *
     * @param Ressourcetransaction $ressourcetransaction
     *
     * @return array
     */
    public function query(Ressourcetransaction $ressourcetransaction): array
    {
        return [
            'ressourcetransaction' => $ressourcetransaction
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return $this->ressourcetransaction->exists ? 'Modification de la transaction' : 'Créer une transaction';
    }

    /**
     * The description is displayed on the user's screen under the heading
     */
    public function description(): ?string
    {
        return "Toutes les transactions enregistrées";
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Button::make('Créer une transaction')
                ->icon('pencil')
                ->method('createOrUpdate')
                ->canSee(!$this->ressourcetransaction->exists),

            Button::make('Modifier la transaction')
                ->icon('note')
                ->method('createOrUpdate')
                ->canSee($this->ressourcetransaction->exists),

            Button::make('Supprimer')
                ->icon('trash')
                ->method('remove')
                ->canSee($this->ressourcetransaction->exists),
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
                Select::make('ressourcetransaction.operationtype_id')
                    ->title('Type d\'opération')
                    ->placeholder('Choisir le type')
                    ->fromModel(\App\Models\Operationtype::class, 'titre')
                    ->empty('Choisir', 0),

                DateTimer::make('ressourcetransaction.datetransaction')
                    ->title('Date de la transaction')
                    ->format('Y-m-d'),

                Input::make('ressourcetransaction.montant')
                    ->title('Montant')
                    ->required()
                    ->placeholder('Saisir le montant'),

                Input::make('ressourcetransaction.reference')
                    ->title('Référence')
                    ->placeholder('Saisir la référence'),

                Select::make('ressourcetransaction.ressourcecompte_id')
                    ->title('Ressource')
                    ->placeholder('Choisir la ressource')
                    ->options(
                        \App\Models\Ressourcecompte::with('membre', 'entreprise')->get()
                            ->mapWithKeys(function ($ressourcecompte) {
                                $membre = $ressourcecompte->membre ? $ressourcecompte->membre->prenom . ' ' . $ressourcecompte->membre->nom : '';
                                $entreprise = $ressourcecompte->entreprise ? $ressourcecompte->entreprise->nom : '';
                                $ressourcetype = $ressourcecompte->ressourcetype ? $ressourcecompte->ressourcetype->titre : '';
                                $solde = $ressourcecompte->solde;
                                return [$ressourcecompte->id => "$membre - $entreprise - $ressourcetype - $solde"];
                            })
                            ->toArray()
                    )
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
    $data = $request->get('ressourcetransaction');

    $this->ressourcetransaction->fill($data)->save();

    Alert::info('Transaction enregistrée avec succès.');

    return redirect()->route('platform.ressourcetransaction.list');
}

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function remove()
    {
        $this->ressourcetransaction->delete();

        Alert::info('Vous avez supprimé la transaction avec succès.');

        return redirect()->route('platform.ressourcetransaction.list');
    }

}
