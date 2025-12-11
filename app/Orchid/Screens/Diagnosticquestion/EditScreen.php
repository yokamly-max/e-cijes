<?php

namespace App\Orchid\Screens\Diagnosticquestion;

use Orchid\Screen\Screen;

use App\Models\Diagnosticquestion;
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
     * @var Diagnosticquestion
     */
    public $diagnosticquestion;

    /**
     * Query data.
     *
     * @param Diagnosticquestion $diagnosticquestion
     *
     * @return array
     */
    public function query(Diagnosticquestion $diagnosticquestion): array
    {
        return [
            'diagnosticquestion' => $diagnosticquestion
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return $this->diagnosticquestion->exists ? 'Modification de la question du diagnostic' : 'Créer une question du diagnostic';
    }

    /**
     * The description is displayed on the user's screen under the heading
     */
    public function description(): ?string
    {
        return "Tous les questions des diagnostics enregistrées";
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Button::make('Créer une question du diagnostic')
                ->icon('pencil')
                ->method('createOrUpdate')
                ->canSee(!$this->diagnosticquestion->exists),

            Button::make('Modifier la question du diagnostic')
                ->icon('note')
                ->method('createOrUpdate')
                ->canSee($this->diagnosticquestion->exists),

            Button::make('Supprimer')
                ->icon('trash')
                ->method('remove')
                ->canSee($this->diagnosticquestion->exists),
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
                Select::make('diagnosticquestion.diagnosticmodule_id')
                    ->title('Module du diagnostic')
                    ->placeholder('Choisir le module')
                    ->fromModel(\App\Models\Diagnosticmodule::class, 'titre')
                    ->empty('Choisir', 0),

                Input::make('diagnosticquestion.titre')
                    ->title('Titre')
                    ->required()
                    ->placeholder('Saisir le titre'),

                Input::make('diagnosticquestion.position')
                    ->title('Position')
                    ->placeholder('Saisir la position'),

                Select::make('diagnosticquestion.diagnosticquestiontype_id')
                    ->title('Type de la question du diagnostic')
                    ->placeholder('Choisir le type')
                    ->fromModel(\App\Models\Diagnosticquestiontype::class, 'titre')
                    ->empty('Choisir', 0),

                Select::make('diagnosticquestion.diagnosticquestioncategorie_id')
                    ->title('Categorie de la question du diagnostic')
                    ->placeholder('Choisir la categorie')
                    ->fromModel(\App\Models\Diagnosticquestioncategorie::class, 'titre')
                    ->empty('Choisir', 0),

                Select::make('diagnosticquestion.langue_id')
                    ->title('Langue')
                    ->placeholder('Choisir la langue')
                    ->options($langueList)
                    ->empty('Choisir', 0),

                Select::make('diagnosticquestion.parent')
                    ->title('Question parente')
                    ->placeholder('Choisir la question')
                    ->fromModel(\App\Models\Diagnosticquestion::class, 'titre')
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
    $data = $request->get('diagnosticquestion');

    $this->diagnosticquestion->fill($data)->save();

    Alert::info('Question du diagnostic enregistrée avec succès.');

    return redirect()->route('platform.diagnosticquestion.list');
}

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function remove()
    {
        $this->diagnosticquestion->delete();

        Alert::info('Vous avez supprimé la question du diagnostic avec succès.');

        return redirect()->route('platform.diagnosticquestion.list');
    }

}
