<?php

namespace App\Orchid\Screens\Diagnostic;

use Orchid\Screen\Screen;

use App\Models\Diagnostic;
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
     * @var Diagnostic
     */
    public $diagnostic;

    /**
     * Query data.
     *
     * @param Diagnostic $diagnostic
     *
     * @return array
     */
    public function query(Diagnostic $diagnostic): array
    {
        return [
            'diagnostic' => $diagnostic
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return $this->diagnostic->exists ? 'Modification du diagnostic' : 'Créer un diagnostic';
    }

    /**
     * The description is displayed on the user's screen under the heading
     */
    public function description(): ?string
    {
        return "Tous les diagnostics enregistrés";
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Button::make('Créer un diagnostic')
                ->icon('pencil')
                ->method('createOrUpdate')
                ->canSee(!$this->diagnostic->exists),

            Button::make('Modifier le diagnostic')
                ->icon('note')
                ->method('createOrUpdate')
                ->canSee($this->diagnostic->exists),

            Button::make('Supprimer')
                ->icon('trash')
                ->method('remove')
                ->canSee($this->diagnostic->exists),
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
                Select::make('diagnostic.membre_id')
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

                Select::make('diagnostic.entreprise_id')
                    ->title('Entreprise')
                    ->placeholder('Choisir le entreprise')
                    //->help('Spécifiez un entreprise.')
                    ->fromModel(\App\Models\Entreprise::class, 'nom')
                    ->empty('Choisir', 0),

                Select::make('diagnostic.accompagnement_id')
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

                Input::make('diagnostic.scoreglobal')
                    ->title('Score global')
                    ->required()
                    ->placeholder('Saisir le score global'),

                TextArea::make('diagnostic.commentaire')
                    ->title('Commentaire')
                    ->placeholder('Saisir le commentaire'),

                Select::make('diagnostic.diagnostictype_id')
                    ->title('Profil émotionnel')
                    ->placeholder('Choisir le profil')
                    ->fromModel(\App\Models\Diagnostictype::class, 'titre')
                    ->empty('Choisir', 0),

                Select::make('diagnostic.diagnosticstatut_id')
                    ->title('Statut du diagnostic')
                    ->placeholder('Choisir le statut')
                    ->fromModel(\App\Models\Diagnosticstatut::class, 'titre')
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
    $data = $request->get('diagnostic');

    $this->diagnostic->fill($data)->save();

    Alert::info('Diagnostic enregistré avec succès.');

    return redirect()->route('platform.diagnostic.list');
}

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function remove()
    {
        $this->diagnostic->delete();

        Alert::info('Vous avez supprimé le diagnostic avec succès.');

        return redirect()->route('platform.diagnostic.list');
    }

}
