<?php

namespace App\Orchid\Screens\Bon;

use Orchid\Screen\Screen;

use App\Models\Bon;
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
     * @var Bon
     */
    public $bon;

    /**
     * Query data.
     *
     * @param Bon $bon
     *
     * @return array
     */
    public function query(Bon $bon): array
    {
        return [
            'bon' => $bon
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return $this->bon->exists ? 'Modification du bon' : 'Créer un bon';
    }

    /**
     * The description is displayed on the user's screen under the heading
     */
    public function description(): ?string
    {
        return "Tous les bons enregistrés";
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Button::make('Créer un bon')
                ->icon('pencil')
                ->method('createOrUpdate')
                ->canSee(!$this->bon->exists),

            Button::make('Modifier le bon')
                ->icon('note')
                ->method('createOrUpdate')
                ->canSee($this->bon->exists),

            Button::make('Supprimer')
                ->icon('trash')
                ->method('remove')
                ->canSee($this->bon->exists),
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
                Input::make('bon.montant')
                    ->title('Montant')
                    ->required()
                    ->placeholder('Saisir le montant'),

                DateTimer::make('bon.datebon')
                    ->title('Date du bon')
                    ->format('Y-m-d'),

                Select::make('bon.bontype_id')
                    ->title('Type du bon')
                    ->placeholder('Choisir le type')
                    ->fromModel(\App\Models\Bontype::class, 'titre')
                    ->empty('Choisir', 0),

                Select::make('bon.bonstatut_id')
                    ->title('Statut du bon')
                    ->placeholder('Choisir le statut')
                    ->fromModel(\App\Models\Bonstatut::class, 'titre')
                    ->empty('Choisir', 0),

                Select::make('bon.pays_id')
                    ->title('Pays')
                    ->placeholder('Choisir le pays')
                    ->options($paysList)
                    ->empty('Choisir', 0),

                Select::make('bon.entreprise_id')
                    ->title('Entreprise')
                    ->placeholder('Choisir l\'entreprise')
                    ->fromModel(\App\Models\Entreprise::class, 'nom')
                    ->empty('Choisir', 0),

                Select::make('bon.user_id')
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
    $data = $request->get('bon');

    $this->bon->fill($data)->save();

    Alert::info('Bon enregistré avec succès.');

    return redirect()->route('platform.bon.list');
}

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function remove()
    {
        $this->bon->delete();

        Alert::info('Vous avez supprimé le bon avec succès.');

        return redirect()->route('platform.bon.list');
    }

}
