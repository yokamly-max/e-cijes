<?php

namespace App\Orchid\Screens\Prestationressource;

use Orchid\Screen\Screen;

use App\Models\Prestationressource;
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
     * @var Prestationressource
     */
    public $prestationressource;

    /**
     * Query data.
     *
     * @param Prestationressource $prestationressource
     *
     * @return array
     */
    public function query(Prestationressource $prestationressource): array
    {
        return [
            'prestationressource' => $prestationressource
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return $this->prestationressource->exists ? 'Modification du paiement de la prestation' : 'Créer un paiement de la prestation';
    }

    /**
     * The description is displayed on the user's screen under the heading
     */
    public function description(): ?string
    {
        return "Tous les paiements des prestations enregistrés";
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Button::make('Créer un paiement de la prestation')
                ->icon('pencil')
                ->method('createOrUpdate')
                ->canSee(!$this->prestationressource->exists),

            Button::make('Modifier le paiement de la prestation')
                ->icon('note')
                ->method('createOrUpdate')
                ->canSee($this->prestationressource->exists),

            Button::make('Supprimer')
                ->icon('trash')
                ->method('remove')
                ->canSee($this->prestationressource->exists),
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
                Select::make('prestationressource.membre_id')
                    ->title('Membre')
                    ->placeholder('Choisir le membre')
                    //->help('Spécifiez un membre.')
                    ->options(
                        \App\Models\Membre::all()
                            ->mapWithKeys(function ($membre) {
                                return [$membre->id => trim("{$membre->prenom} {$membre->nom}")];
                            })
                            ->toArray())
                    ->empty('Choisir', 0),

                Select::make('prestationressource.entreprise_id')
                    ->title('Entreprise')
                    ->placeholder('Choisir le entreprise')
                    //->help('Spécifiez un entreprise.')
                    ->fromModel(\App\Models\Entreprise::class, 'nom')
                    ->empty('Choisir', 0),

                Select::make('prestationressource.accompagnement_id')
                    ->title('Accompagnement')
                    ->placeholder('Choisir l\'accompagnement')
                    ->options(
                        \App\Models\Accompagnement::with('membre', 'entreprise')->get()
                            ->mapWithKeys(function ($accompagnement) {
                                $membre = $accompagnement->membre ? $accompagnement->membre->prenom . ' ' . $accompagnement->membre->nom : '';
                                $entreprise = $accompagnement->entreprise ? $accompagnement->entreprise->nom : '';
                                return [$accompagnement->id => "$membre - $entreprise"];
                            })
                            ->toArray()
                    )
                    ->empty('Choisir', 0),

                Select::make('prestationressource.prestation_id')
                    ->title('Prestation')
                    ->placeholder('Choisir la prestation')
                    ->fromModel(\App\Models\Prestation::class, 'titre')
                    ->empty('Choisir', 0),

                Input::make('prestationressource.montant')
                    ->title('Montant')
                    ->required()
                    ->placeholder('Saisir le montant'),

                TextArea::make('prestationressource.reference')
                    ->title('Reference')
                    ->placeholder('Saisir la reference de la transaction'),

                Select::make('prestationressource.ressourcecompte_id')
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

                Select::make('prestationressource.paiementstatut_id')
                    ->title('Statut du paiement')
                    ->placeholder('Choisir le statut')
                    ->fromModel(\App\Models\Paiementstatut::class, 'titre')
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
    $data = $request->get('prestationressource');

    $this->prestationressource->fill($data)->save();

    Alert::info('Paiement de la prestation enregistré avec succès.');

    return redirect()->route('platform.prestationressource.list');
}

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function remove()
    {
        $this->prestationressource->delete();

        Alert::info('Vous avez supprimé le paiement de la prestation avec succès.');

        return redirect()->route('platform.prestationressource.list');
    }

}
