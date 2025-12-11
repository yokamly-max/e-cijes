<?php

namespace App\Orchid\Screens\Diagnosticreponse;

use Orchid\Screen\Screen;

use App\Models\Diagnosticreponse;
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
     * @var Diagnosticreponse
     */
    public $diagnosticreponse;

    /**
     * Query data.
     *
     * @param Diagnosticreponse $diagnosticreponse
     *
     * @return array
     */
    public function query(Diagnosticreponse $diagnosticreponse): array
    {
        return [
            'diagnosticreponse' => $diagnosticreponse
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return $this->diagnosticreponse->exists ? 'Modification de la réponse du diagnostic' : 'Créer une réponse du diagnostic';
    }

    /**
     * The description is displayed on the user's screen under the heading
     */
    public function description(): ?string
    {
        return "Toutes les réponses des diagnostics enregistrées";
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Button::make('Créer une réponse du diagnostic')
                ->icon('pencil')
                ->method('createOrUpdate')
                ->canSee(!$this->diagnosticreponse->exists),

            Button::make('Modifier la réponse du diagnostic')
                ->icon('note')
                ->method('createOrUpdate')
                ->canSee($this->diagnosticreponse->exists),

            Button::make('Supprimer')
                ->icon('trash')
                ->method('remove')
                ->canSee($this->diagnosticreponse->exists),
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
                Select::make('diagnosticreponse.diagnosticquestion_id')
                    ->title('Question du diagnostic')
                    ->placeholder('Choisir la question')
                    ->fromModel(\App\Models\Diagnosticquestion::class, 'titre')
                    ->empty('Choisir', 0),

                Input::make('diagnosticreponse.titre')
                    ->title('Titre')
                    ->required()
                    ->placeholder('Saisir le titre'),

                Input::make('diagnosticreponse.position')
                    ->title('Position')
                    ->placeholder('Saisir la position'),

                Input::make('diagnosticreponse.score')
                    ->title('Score')
                    ->placeholder('Saisir le score'),

                Select::make('diagnosticreponse.langue_id')
                    ->title('Langue')
                    ->placeholder('Choisir la langue')
                    ->options($langueList)
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
    $data = $request->get('diagnosticreponse');

    $this->diagnosticreponse->fill($data)->save();

    Alert::info('Réponse du diagnostic enregistrée avec succès.');

    return redirect()->route('platform.diagnosticreponse.list');
}

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function remove()
    {
        $this->diagnosticreponse->delete();

        Alert::info('Vous avez supprimé la réponse du diagnostic avec succès.');

        return redirect()->route('platform.diagnosticreponse.list');
    }

}
