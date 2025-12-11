<?php

namespace App\Orchid\Screens\Evenement;

use Orchid\Screen\Screen;

use App\Models\Evenement;
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
     * @var Evenement
     */
    public $evenement;

    /**
     * Query data.
     *
     * @param Evenement $evenement
     *
     * @return array
     */
    public function query(Evenement $evenement): array
    {
        return [
            'evenement' => $evenement
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return $this->evenement->exists ? 'Modification de l\'évènement' : 'Créer une évènement';
    }

    /**
     * The description is displayed on the user's screen under the heading
     */
    public function description(): ?string
    {
        return "Toutes les évènements enregistrées";
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Button::make('Créer une évènement')
                ->icon('pencil')
                ->method('createOrUpdate')
                ->canSee(!$this->evenement->exists),

            Button::make('Modifier l\'évènement')
                ->icon('note')
                ->method('createOrUpdate')
                ->canSee($this->evenement->exists),

            Button::make('Supprimer')
                ->icon('trash')
                ->method('remove')
                ->canSee($this->evenement->exists),
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
                Input::make('evenement.titre')
                    ->title('Titre')
                    ->required()
                    ->placeholder('Saisir le titre'),
                    //->help('Spécifiez un titre pour cette évènement.')

                TextArea::make('evenement.resume')
                    ->title('Résumé')
                    ->placeholder('Saisir le résumé'),
                    //->help('Spécifiez un résumé pour cette évènement.')

                /*DateTimer::make('evenement.dateevenement')
                    ->title('Date de l\'évènement'),*/

                Input::make('evenement.prix')
                    ->title('Prix')
                    ->placeholder('Saisir le prix'),

                    
                    Input::make('evenement.dateevenement')
                        ->type('datetime-local')
                        ->title('Date de l\'évènement')
                        ->placeholder('YYYY-MM-DDTHH:MM'),

                /*TextArea::make('evenement.description')
                    ->title('Description')
                    ->placeholder('Saisir la description'),
                    //->help('Spécifiez une description pour cette évènement')*/

                Quill::make('evenement.description')
                    ->title('Description')
                    //->popover('Saisir la description')
                    ->placeholder('Saisir la description'),

                Select::make('evenement.evenementtype_id')
                    ->title('Type d\'évènement')
                    ->placeholder('Choisir le type')
                    //->help('Spécifiez un type d\'évènement.')
                    ->fromModel(\App\Models\Evenementtype::class, 'titre')
                    ->empty('Choisir', 0),

                Input::make('vignette')
                    ->type('file')
                    ->title('Vignette (image)')// ou PDF
                    ->accept('image/*')//,.pdf
                    ->help('Uploader un fichier image (1 seul fichier).'),// ou PDF

                Select::make('evenement.langue_id')
                    ->title('Langue')
                    ->placeholder('Choisir la langue')
                    ->options($langueList)
                    ->empty('Choisir', 0),

                Select::make('evenement.pays_id')
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
    $data = $request->get('evenement');

    if ($request->hasFile('vignette')) {
        $file = $request->file('vignette');

        // Stocker dans /storage/app/public/evenements/YYYY/MM/DD
        $path = $file->storeAs(
            'evenements/' . date('Y/m/d'),
            uniqid() . '_' . $file->getClientOriginalName(),
            'public'
        );

        // Enregistrer le chemin dans la base (accessible via asset())
        $data['vignette'] = 'storage/' . $path;
    }

    $this->evenement->fill($data)->save();

    Alert::info('Évènement enregistrée avec succès.');

    return redirect()->route('platform.evenement.list');
}

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function remove()
    {
        $this->evenement->delete();

        Alert::info('Vous avez supprimé l\'évènement avec succès.');

        return redirect()->route('platform.evenement.list');
    }

}
