<?php

namespace App\Orchid\Screens\Conseiller;

use Orchid\Screen\Screen;

use App\Models\Conseiller;
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
     * @var Conseiller
     */
    public $conseiller;

    /**
     * Query data.
     *
     * @param Conseiller $conseiller
     *
     * @return array
     */
    public function query(Conseiller $conseiller): array
    {
        return [
            'conseiller' => $conseiller
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return $this->conseiller->exists ? 'Modification du conseiller' : 'Créer un conseiller';
    }

    /**
     * The description is displayed on the user's screen under the heading
     */
    public function description(): ?string
    {
        return "Tous les conseillers enregistrés";
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Button::make('Créer un conseiller')
                ->icon('pencil')
                ->method('createOrUpdate')
                ->canSee(!$this->conseiller->exists),

            Button::make('Modifier l\'conseiller')
                ->icon('note')
                ->method('createOrUpdate')
                ->canSee($this->conseiller->exists),

            Button::make('Supprimer')
                ->icon('trash')
                ->method('remove')
                ->canSee($this->conseiller->exists),
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
                Select::make('conseiller.membre_id')
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

                /*TextArea::make('conseiller.fonction')
                    ->title('Fonction')
                    ->placeholder('Saisir la fonction'),
                    //->help('Spécifiez une fonction pour cette conseiller')*/

                Quill::make('conseiller.fonction')
                    ->title('Fonction')
                    //->popover('Saisir le fonction')
                    ->placeholder('Saisir les fonctions de conseillers'),

                Select::make('conseiller.conseillertype_id')
                    ->title('Type de conseiller')
                    ->placeholder('Choisir le type')
                    ->fromModel(\App\Models\Conseillertype::class, 'titre')
                    ->empty('Choisir', 0),

                Select::make('conseiller.conseillervalide_id')
                    ->title('Validation de conseiller')
                    ->placeholder('Choisir la validation de conseiller')
                    ->fromModel(\App\Models\Conseillervalide::class, 'titre')
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
    $data = $request->get('conseiller');

    $this->conseiller->fill($data)->save();

    Alert::info('Conseiller enregistré avec succès.');

    return redirect()->route('platform.conseiller.list');
}

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function remove()
    {
        $this->conseiller->delete();

        Alert::info('Vous avez supprimé l\'conseiller avec succès.');

        return redirect()->route('platform.conseiller.list');
    }

}
