<?php

namespace App\Orchid\Screens\Formationressource;

use Orchid\Screen\Screen;

use App\Models\Formationressource;
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
     * @var Formationressource
     */
    public $formationressource;

    /**
     * Query data.
     *
     * @param Formationressource $formationressource
     *
     * @return array
     */
    public function query(Formationressource $formationressource): array
    {
        return [
            'formationressource' => $formationressource
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return $this->formationressource->exists ? 'Modification du paiement de la formation' : 'Créer un paiement de la formation';
    }

    /**
     * The description is displayed on the user's screen under the heading
     */
    public function description(): ?string
    {
        return "Tous les paiements des formations enregistrés";
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Button::make('Créer un paiement de la formation')
                ->icon('pencil')
                ->method('createOrUpdate')
                ->canSee(!$this->formationressource->exists),

            Button::make('Modifier le paiement de la formation')
                ->icon('note')
                ->method('createOrUpdate')
                ->canSee($this->formationressource->exists),

            Button::make('Supprimer')
                ->icon('trash')
                ->method('remove')
                ->canSee($this->formationressource->exists),
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
                Select::make('formationressource.membre_id')
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

                Select::make('formationressource.entreprise_id')
                    ->title('Entreprise')
                    ->placeholder('Choisir le entreprise')
                    //->help('Spécifiez un entreprise.')
                    ->fromModel(\App\Models\Entreprise::class, 'nom')
                    ->empty('Choisir', 0),

                Select::make('formationressource.accompagnement_id')
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

                Select::make('formationressource.formation_id')
                    ->title('Formation')
                    ->placeholder('Choisir la formation')
                    ->fromModel(\App\Models\Formation::class, 'titre')
                    ->empty('Choisir', 0),

                Input::make('formationressource.montant')
                    ->title('Montant')
                    ->required()
                    ->placeholder('Saisir le montant'),

                TextArea::make('formationressource.reference')
                    ->title('Reference')
                    ->placeholder('Saisir la reference de la transaction'),

                Select::make('formationressource.ressourcecompte_id')
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

                Select::make('formationressource.paiementstatut_id')
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
    $data = $request->get('formationressource');

    $this->formationressource->fill($data)->save();

    Alert::info('Paiement de la formation enregistré avec succès.');

    return redirect()->route('platform.formationressource.list');
}

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function remove()
    {
        $this->formationressource->delete();

        Alert::info('Vous avez supprimé le paiement de la formation avec succès.');

        return redirect()->route('platform.formationressource.list');
    }

}
