<?php

namespace App\Orchid\Screens\Credit;

use Orchid\Screen\Screen;

use App\Models\Credit;
use App\Models\Pays;
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
     * @var Credit
     */
    public $credit;

    /**
     * Query data.
     *
     * @param Credit $credit
     *
     * @return array
     */
    public function query(Credit $credit): array
    {
        return [
            'credit' => $credit
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return $this->credit->exists ? 'Modification du crédit' : 'Créer un crédit';
    }

    /**
     * The description is displayed on the user's screen under the heading
     */
    public function description(): ?string
    {
        return "Tous les crédits enregistrés";
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Button::make('Créer un crédit')
                ->icon('pencil')
                ->method('createOrUpdate')
                ->canSee(!$this->credit->exists),

            Button::make('Modifier le crédit')
                ->icon('note')
                ->method('createOrUpdate')
                ->canSee($this->credit->exists),

            Button::make('Supprimer')
                ->icon('trash')
                ->method('remove')
                ->canSee($this->credit->exists),
        ];
    }

    /**
     * The screen's layout elements.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): iterable
    {
        // Récupérer les pays via l'API Supabase et créer un tableau [id => nom]
        $paysModel = new Pays();
        $paysList = collect($paysModel->all())->pluck('name', 'id')->toArray();

        return [
            Layout::rows([
                Select::make('credit.entreprise_id')
                    ->title('Entreprise')
                    ->placeholder('Choisir l\'entreprise')
                    ->fromModel(\App\Models\Entreprise::class, 'nom')
                    ->empty('Choisir', 0),

                Select::make('credit.credittype_id')
                    ->title('Type du crédit')
                    ->placeholder('Choisir le type')
                    ->fromModel(\App\Models\Credittype::class, 'titre')
                    ->empty('Choisir', 0),

                Input::make('credit.montanttotal')
                    ->title('Montant total')
                    ->required()
                    ->placeholder('Saisir le montant total'),

                Input::make('credit.montantutilise')
                    ->title('Montant utilisé')
                    ->required()
                    ->placeholder('Saisir le montant utilisé'),

                DateTimer::make('credit.datecredit')
                    ->title('Date de validation')
                    ->format('Y-m-d'),

                Select::make('credit.creditstatut_id')
                    ->title('Statut du crédit')
                    ->placeholder('Choisir le statut')
                    ->fromModel(\App\Models\Creditstatut::class, 'titre')
                    ->empty('Choisir', 0),

                Select::make('credit.pays_id')
                    ->title('Pays')
                    ->placeholder('Choisir le pays')
                    ->options($paysList)
                    ->empty('Choisir', 0),

                Select::make('credit.partenaire_id')
                    ->title('Partenaire')
                    ->placeholder('Choisir le partenaire')
                    ->fromModel(\App\Models\Partenaire::class, 'titre')
                    ->empty('Choisir', 0),

                Select::make('credit.user_id')
                    ->title('Utilisateur')
                    ->placeholder('Choisir l\'utilisateur')
                    ->fromModel(\App\Models\User::class, 'name')
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
    $data = $request->get('credit');

    $this->credit->fill($data)->save();

    Alert::info('Crédit enregistré avec succès.');

    return redirect()->route('platform.credit.list');
}

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function remove()
    {
        $this->credit->delete();

        Alert::info('Vous avez supprimé le crédit avec succès.');

        return redirect()->route('platform.credit.list');
    }

}
