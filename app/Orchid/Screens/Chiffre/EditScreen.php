<?php

namespace App\Orchid\Screens\Chiffre;

use Orchid\Screen\Screen;

use App\Models\Chiffre;
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
     * @var Chiffre
     */
    public $chiffre;

    /**
     * Query data.
     *
     * @param Chiffre $chiffre
     *
     * @return array
     */
    public function query(Chiffre $chiffre): array
    {
        return [
            'chiffre' => $chiffre
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return $this->chiffre->exists ? 'Modification du chiffre' : 'Créer un chiffre';
    }

    /**
     * The description is displayed on the user's screen under the heading
     */
    public function description(): ?string
    {
        return "Tous les chiffres enregistrés";
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Button::make('Créer un chiffre')
                ->icon('pencil')
                ->method('createOrUpdate')
                ->canSee(!$this->chiffre->exists),

            Button::make('Modifier le chiffre')
                ->icon('note')
                ->method('createOrUpdate')
                ->canSee($this->chiffre->exists),

            Button::make('Supprimer')
                ->icon('trash')
                ->method('remove')
                ->canSee($this->chiffre->exists),
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
                Input::make('chiffre.titre')
                    ->title('Titre')
                    ->required()
                    ->placeholder('Saisir le titre'),
                    //->help('Spécifiez un titre pour cette chiffre.')

                Input::make('chiffre.chiffre')
                    ->title('Chiffre')
                    ->required()
                    ->placeholder('Saisir le chiffre'),
                    //->help('Spécifiez un chiffre pour cette chiffre.')

                Input::make('vignette')
                    ->type('file')
                    ->title('Vignette (image)')// ou PDF
                    ->accept('image/*')//,.pdf
                    ->help('Uploader un fichier image (1 seul fichier).'),// ou PDF

                Select::make('chiffre.langue_id')
                    ->title('Langue')
                    ->placeholder('Choisir la langue')
                    ->options($langueList)
                    ->empty('Choisir', 0),


                Select::make('chiffre.pays_id')
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
    $data = $request->get('chiffre');

    if ($request->hasFile('vignette')) {
        $file = $request->file('vignette');

        // Stocker dans /storage/app/public/chiffres/YYYY/MM/DD
        $path = $file->storeAs(
            'chiffres/' . date('Y/m/d'),
            uniqid() . '_' . $file->getClientOriginalName(),
            'public'
        );

        // Enregistrer le chemin dans la base (accessible via asset())
        $data['vignette'] = 'storage/' . $path;
    }

    $this->chiffre->fill($data)->save();

    Alert::info('Chiffre enregistré avec succès.');

    return redirect()->route('platform.chiffre.list');
}

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function remove()
    {
        $this->chiffre->delete();

        Alert::info('Vous avez supprimé le chiffre avec succès.');

        return redirect()->route('platform.chiffre.list');
    }

}
