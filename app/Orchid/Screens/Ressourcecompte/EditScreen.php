<?php

namespace App\Orchid\Screens\Ressourcecompte;

use Orchid\Screen\Screen;

use App\Models\Ressourcecompte;

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
     * @var Ressourcecompte
     */
    public $ressourcecompte;

    /**
     * Query data.
     *
     * @param Ressourcecompte $ressourcecompte
     *
     * @return array
     */
    public function query(Ressourcecompte $ressourcecompte): array
    {
        return [
            'ressourcecompte' => $ressourcecompte
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return $this->ressourcecompte->exists ? 'Modification de la ressource' : 'Créer une ressource';
    }

    /**
     * The description is displayed on the user's screen under the heading
     */
    public function description(): ?string
    {
        return "Toutes les ressources enregistrées";
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Button::make('Créer une ressource')
                ->icon('pencil')
                ->method('createOrUpdate')
                ->canSee(!$this->ressourcecompte->exists),

            Button::make('Modifier la ressource')
                ->icon('note')
                ->method('createOrUpdate')
                ->canSee($this->ressourcecompte->exists),

            Button::make('Supprimer')
                ->icon('trash')
                ->method('remove')
                ->canSee($this->ressourcecompte->exists),
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
                Input::make('ressourcecompte.solde')
                    ->title('Solde')
                    ->required()
                    ->placeholder('Saisir le solde'),

                Select::make('ressourcecompte.ressourcetype_id')
                    ->title('Type de la ressource')
                    ->placeholder('Choisir le type')
                    ->fromModel(\App\Models\Ressourcetype::class, 'titre')
                    ->empty('Choisir', 0),

                Select::make('ressourcecompte.membre_id')
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

                Select::make('ressourcecompte.entreprise_id')
                    ->title('Entreprise')
                    ->placeholder('Choisir l\'entreprise')
                    ->fromModel(\App\Models\Entreprise::class, 'nom')
                    ->empty('Choisir', 0),

                Select::make('ressourcecompte.user_id')
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
    $data = $request->get('ressourcecompte');

    $this->ressourcecompte->fill($data)->save();

    Alert::info('Ressource enregistrée avec succès.');

    return redirect()->route('platform.ressourcecompte.list');
}

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function remove()
    {
        $this->ressourcecompte->delete();

        Alert::info('Vous avez supprimé la ressource avec succès.');

        return redirect()->route('platform.ressourcecompte.list');
    }

}
