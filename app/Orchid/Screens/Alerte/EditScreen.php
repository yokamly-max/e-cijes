<?php

namespace App\Orchid\Screens\Alerte;

use Orchid\Screen\Screen;

use App\Models\Alerte;
use App\Models\Langue;

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
     * @var Alerte
     */
    public $alerte;

    /**
     * Query data.
     *
     * @param Alerte $alerte
     *
     * @return array
     */
    public function query(Alerte $alerte): array
    {
        return [
            'alerte' => $alerte
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return $this->alerte->exists ? 'Modification de l\'alerte' : 'Créer une alerte';
    }

    /**
     * The description is displayed on the user's screen under the heading
     */
    public function description(): ?string
    {
        return "Toutes les alertes enregistrées";
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Button::make('Créer une alerte')
                ->icon('pencil')
                ->method('createOrUpdate')
                ->canSee(!$this->alerte->exists),

            Button::make('Modifier l\'alerte')
                ->icon('note')
                ->method('createOrUpdate')
                ->canSee($this->alerte->exists),

            Button::make('Supprimer')
                ->icon('trash')
                ->method('remove')
                ->canSee($this->alerte->exists),
        ];
    }

    /**
     * The screen's layout elements.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): iterable
    {
        // Récupérer les langue via l'API Supabase et créer un tableau [id => nom]
        $langueModel = new Langue();
        $langueList = collect($langueModel->all())->pluck('name', 'id')->toArray();

        return [
            Layout::rows([
                Input::make('alerte.titre')
                    ->title('Titre')
                    ->required()
                    ->placeholder('Saisir le titre'),

                TextArea::make('alerte.contenu')
                    ->title('Contenu')
                    ->placeholder('Saisir le contenu'),

                DateTimer::make('alerte.datealerte')
                    ->title('Date de l\'alerte')
                    ->format('Y-m-d'),

                TextArea::make('alerte.lienurl')
                    ->title('Lien url')
                    ->placeholder('Saisir le lien url'),

                Select::make('alerte.alertetype_id')
                    ->title('Type d\'alerte')
                    ->placeholder('Choisir le type')
                    ->fromModel(\App\Models\Alertetype::class, 'titre')
                    ->empty('Choisir', 0),

                Select::make('alerte.recompense_id')
                    ->title('Recompense')
                    ->placeholder('Choisir la recompense')
                    ->fromModel(\App\Models\Recompense::class, 'titre')
                    ->empty('Choisir', 0),

                Select::make('alerte.langue_id')
                    ->title('Langue')
                    ->placeholder('Choisir la langue')
                    ->options($langueList)
                    ->empty('Choisir', 0),


                Select::make('alerte.membre_id')
                    ->title('Membre')
                    ->placeholder('Choisir le membre')
                    ->options(
                        \App\Models\Membre::all()
                            ->mapWithKeys(function ($membre) {
                                return [$membre->id => trim("{$membre->prenom} {$membre->nom}")];
                            })
                            ->toArray())
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
    $data = $request->get('alerte');

    $this->alerte->fill($data)->save();

    Alert::info('Alerte enregistrée avec succès.');

    return redirect()->route('platform.alerte.list');
}

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function remove()
    {
        $this->alerte->delete();

        Alert::info('Vous avez supprimé l\'alerte avec succès.');

        return redirect()->route('platform.alerte.list');
    }

}
