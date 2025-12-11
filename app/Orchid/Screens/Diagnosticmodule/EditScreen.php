<?php

namespace App\Orchid\Screens\Diagnosticmodule;

use Orchid\Screen\Screen;

use App\Models\Diagnosticmodule;
use App\Models\Diagnosticmoduletype;
use App\Models\Pays;
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
     * @var Diagnosticmodule
     */
    public $diagnosticmodule;

    /**
     * Query data.
     *
     * @param Diagnosticmodule $diagnosticmodule
     *
     * @return array
     */
    public function query(Diagnosticmodule $diagnosticmodule): array
    {
        return [
            'diagnosticmodule' => $diagnosticmodule
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return $this->diagnosticmodule->exists ? 'Modification du module de diagnostic' : 'Créer un module de diagnostic';
    }

    /**
     * The description is displayed on the user's screen under the heading
     */
    public function description(): ?string
    {
        return "Tous les modules des diagnostics enregistrés";
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Button::make('Créer un module de diagnostic')
                ->icon('pencil')
                ->method('createOrUpdate')
                ->canSee(!$this->diagnosticmodule->exists),

            Button::make('Modifier le module de diagnostic')
                ->icon('note')
                ->method('createOrUpdate')
                ->canSee($this->diagnosticmodule->exists),

            Button::make('Supprimer')
                ->icon('trash')
                ->method('remove')
                ->canSee($this->diagnosticmodule->exists),
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

        // Récupérer les langue via l'API Supabase et créer un tableau [id => nom]
        $langueModel = new Langue();
        $langueList = collect($langueModel->all())->pluck('name', 'id')->toArray();


        return [
            Layout::rows([
                Input::make('diagnosticmodule.titre')
                    ->title('Titre')
                    ->required()
                    ->placeholder('Saisir le titre'),

                Input::make('diagnosticmodule.position')
                    ->title('Position')
                    ->placeholder('Saisir la position'),

                /*TextArea::make('diagnosticmodule.description')
                    ->title('Description')
                    ->placeholder('Saisir la description'),
                    //->help('Spécifiez une description pour cette diagnosticmodule')*/

                Quill::make('diagnosticmodule.description')
                    ->title('Description')
                    //->popover('Saisir la description')
                    ->placeholder('Saisir la description'),

                Select::make('diagnosticmodule.diagnosticmoduletype_id')
                    ->title('Type')
                    ->placeholder('Choisir le type')
                    ->fromModel(\App\Models\Diagnosticmoduletype::class, 'titre')
                    ->empty('Choisir', 0),

                Select::make('diagnosticmodule.parent')
                    ->title('Module parent')
                    ->placeholder('Choisir le module')
                    ->fromModel(\App\Models\Diagnosticmodule::class, 'titre')
                    ->empty('Choisir', 0),

                Select::make('diagnosticmodule.langue_id')
                    ->title('Langue')
                    ->placeholder('Choisir la langue')
                    ->options($langueList)
                    ->empty('Choisir', 0),

                Select::make('diagnosticmodule.pays_id')
                    ->title('Pays')
                    ->placeholder('Choisir le pays')
                    ->options($paysList)
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
    $data = $request->get('diagnosticmodule');

    $this->diagnosticmodule->fill($data)->save();

    Alert::info('Module de diagnostic enregistré avec succès.');

    return redirect()->route('platform.diagnosticmodule.list');
}

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function remove()
    {
        $this->diagnosticmodule->delete();

        Alert::info('Vous avez supprimé le module de diagnostic avec succès.');

        return redirect()->route('platform.diagnosticmodule.list');
    }

}
