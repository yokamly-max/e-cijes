<?php

namespace App\Orchid\Screens\Entreprise;

use Orchid\Screen\Screen;

use App\Models\Entreprise;
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
     * @var Entreprise
     */
    public $entreprise;

    /**
     * Query data.
     *
     * @param Entreprise $entreprise
     *
     * @return array
     */
    public function query(Entreprise $entreprise): array
    {
        return [
            'entreprise' => $entreprise
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return $this->entreprise->exists ? 'Modification de l\'entreprise' : 'Créer une entreprise';
    }

    /**
     * The description is displayed on the user's screen under the heading
     */
    public function description(): ?string
    {
        return "Toutes les entreprises enregistrées";
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Button::make('Créer une entreprise')
                ->icon('pencil')
                ->method('createOrUpdate')
                ->canSee(!$this->entreprise->exists),

            Button::make('Modifier l\'entreprise')
                ->icon('note')
                ->method('createOrUpdate')
                ->canSee($this->entreprise->exists),

            Button::make('Supprimer')
                ->icon('trash')
                ->method('remove')
                ->canSee($this->entreprise->exists),
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
                Input::make('entreprise.nom')
                    ->title('Raison sociale')
                    ->required()
                    ->placeholder('Saisir la raison sociale'),

                Input::make('entreprise.email')
                    ->title('Email')
                    ->required()
                    ->placeholder('Saisir l\'email'),

                Select::make('entreprise.pays_id')
                    ->title('Pays')
                    ->placeholder('Choisir le pays')
                    ->options($paysList)
                    ->empty('Choisir', 0),

                Input::make('entreprise.telephone')
                    ->title('Téléphone')
                    ->required()
                    ->placeholder('Saisir le numéro de téléphone'),

                TextArea::make('entreprise.adresse')
                    ->title('Adresse')
                    ->placeholder('Saisir l\'adresse'),

                /*TextArea::make('entreprise.description')
                    ->title('Description')
                    ->placeholder('Saisir la description'),
                    //->help('Spécifiez une description pour cette entreprise')*/

                Quill::make('entreprise.description')
                    ->title('Description')
                    //->popover('Saisir la description')
                    ->placeholder('Saisir la description'),

                Select::make('entreprise.entreprisetype_id')
                    ->title('Type d\'entreprise')
                    ->placeholder('Choisir le type')
                    //->help('Spécifiez un type d\'entreprise.')
                    ->fromModel(\App\Models\Entreprisetype::class, 'titre')
                    ->empty('Choisir', 0),

                Select::make('entreprise.secteur_id')
                    ->title('Secteur')
                    ->placeholder('Choisir la secteur')
                    //->help('Spécifiez une secteur.')
                    ->fromModel(\App\Models\Secteur::class, 'titre')
                    ->empty('Choisir', 0),

                Input::make('vignette')
                    ->type('file')
                    ->title('Vignette (image)')// ou PDF
                    ->accept('image/*')//,.pdf
                    ->help('Uploader un fichier image (1 seul fichier).'),// ou PDF

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
    $data = $request->get('entreprise');

    if ($request->hasFile('vignette')) {
        $file = $request->file('vignette');

        // Stocker dans /storage/app/public/entreprises/YYYY/MM/DD
        $path = $file->storeAs(
            'entreprises/' . date('Y/m/d'),
            uniqid() . '_' . $file->getClientOriginalName(),
            'public'
        );

        // Enregistrer le chemin dans la base (accessible via asset())
        $data['vignette'] = 'storage/' . $path;
    }

    $this->entreprise->fill($data)->save();

    Alert::info('Entreprise enregistrée avec succès.');

    return redirect()->route('platform.entreprise.list');
}

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function remove()
    {
        $this->entreprise->delete();

        Alert::info('Vous avez supprimé l\'entreprise avec succès.');

        return redirect()->route('platform.entreprise.list');
    }

}
