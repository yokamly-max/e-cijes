<?php

namespace App\Orchid\Screens\Partenaire;

use Orchid\Screen\Screen;

use App\Models\Partenaire;
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
     * @var Partenaire
     */
    public $partenaire;

    /**
     * Query data.
     *
     * @param Partenaire $partenaire
     *
     * @return array
     */
    public function query(Partenaire $partenaire): array
    {
        return [
            'partenaire' => $partenaire
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return $this->partenaire->exists ? 'Modification du partenaire' : 'Créer un partenaire';
    }

    /**
     * The description is displayed on the user's screen under the heading
     */
    public function description(): ?string
    {
        return "Tous les partenaires enregistrés";
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Button::make('Créer un partenaire')
                ->icon('pencil')
                ->method('createOrUpdate')
                ->canSee(!$this->partenaire->exists),

            Button::make('Modifier le partenaire')
                ->icon('note')
                ->method('createOrUpdate')
                ->canSee($this->partenaire->exists),

            Button::make('Supprimer')
                ->icon('trash')
                ->method('remove')
                ->canSee($this->partenaire->exists),
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
                Input::make('partenaire.titre')
                    ->title('Titre')
                    ->required()
                    ->placeholder('Saisir le titre'),
                    //->help('Spécifiez un titre pour cette partenaire.')

                TextArea::make('partenaire.contact')
                    ->title('Contact')
                    ->placeholder('Saisir le contact'),
                    //->help('Spécifiez un contact pour cette partenaire.')

                /*TextArea::make('partenaire.description')
                    ->title('Description')
                    ->placeholder('Saisir la description'),
                    //->help('Spécifiez une description pour cette partenaire')*/

                Quill::make('partenaire.description')
                    ->title('Description')
                    //->popover('Saisir la description')
                    ->placeholder('Saisir la description'),

                Select::make('partenaire.partenairetype_id')
                    ->title('Type du partenaire')
                    ->placeholder('Choisir le type')
                    //->help('Spécifiez un type d\'partenaire.')
                    ->fromModel(\App\Models\Partenairetype::class, 'titre')
                    ->empty('Choisir', 0),

                Input::make('vignette')
                    ->type('file')
                    ->title('Vignette (image)')// ou PDF
                    ->accept('image/*')//,.pdf
                    ->help('Uploader un fichier image (1 seul fichier).'),// ou PDF

                Select::make('partenaire.langue_id')
                    ->title('Langue')
                    ->placeholder('Choisir la langue')
                    ->options($langueList)
                    ->empty('Choisir', 0),


                Select::make('partenaire.pays_id')
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
    $data = $request->get('partenaire');

    if ($request->hasFile('vignette')) {
        $file = $request->file('vignette');

        // Stocker dans /storage/app/public/partenaires/YYYY/MM/DD
        $path = $file->storeAs(
            'partenaires/' . date('Y/m/d'),
            uniqid() . '_' . $file->getClientOriginalName(),
            'public'
        );

        // Enregistrer le chemin dans la base (accessible via asset())
        $data['vignette'] = 'storage/' . $path;
    }

    $this->partenaire->fill($data)->save();

    Alert::info('Partenaire enregistré avec succès.');

    return redirect()->route('platform.partenaire.list');
}

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function remove()
    {
        $this->partenaire->delete();

        Alert::info('Vous avez supprimé le partenaire avec succès.');

        return redirect()->route('platform.partenaire.list');
    }

}
