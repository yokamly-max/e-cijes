<?php

namespace App\Orchid\Screens\Espace;

use Orchid\Screen\Screen;

use App\Models\Espace;
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
     * @var Espace
     */
    public $espace;

    /**
     * Query data.
     *
     * @param Espace $espace
     *
     * @return array
     */
    public function query(Espace $espace): array
    {
        return [
            'espace' => $espace
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return $this->espace->exists ? 'Modification de l\'espace' : 'Créer un espace';
    }

    /**
     * The description is displayed on the user's screen under the heading
     */
    public function description(): ?string
    {
        return "Tous les espaces enregistrés";
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Button::make('Créer un espace')
                ->icon('pencil')
                ->method('createOrUpdate')
                ->canSee(!$this->espace->exists),

            Button::make('Modifier l\'espace')
                ->icon('note')
                ->method('createOrUpdate')
                ->canSee($this->espace->exists),

            Button::make('Supprimer')
                ->icon('trash')
                ->method('remove')
                ->canSee($this->espace->exists),
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
                Input::make('espace.titre')
                    ->title('Titre')
                    ->required()
                    ->placeholder('Saisir le titre'),

                Input::make('espace.capacite')
                    ->title('Capacité')
                    ->placeholder('Saisir la capacité'),

                TextArea::make('espace.resume')
                    ->title('Résumé')
                    ->placeholder('Saisir le résumé'),

                Input::make('espace.prix')
                    ->title('Prix')
                    ->placeholder('Saisir le prix'),

                /*TextArea::make('espace.description')
                    ->title('Description')
                    ->placeholder('Saisir la description'),
                    //->help('Spécifiez une description pour cette espace')*/

                Quill::make('espace.description')
                    ->title('Description')
                    //->popover('Saisir la description')
                    ->placeholder('Saisir la description'),

                Select::make('espace.espacetype_id')
                    ->title('Type d\'espace')
                    ->placeholder('Choisir le type')
                    //->help('Spécifiez un type d\'espace.')
                    ->fromModel(\App\Models\Espacetype::class, 'titre')
                    ->empty('Choisir', 0),

                Input::make('vignette')
                    ->type('file')
                    ->title('Vignette (image)')// ou PDF
                    ->accept('image/*')//,.pdf
                    ->help('Uploader un fichier image (1 seul fichier).'),// ou PDF

                Select::make('espace.pays_id')
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
    $data = $request->get('espace');

    if ($request->hasFile('vignette')) {
        $file = $request->file('vignette');

        // Stocker dans /storage/app/public/espaces/YYYY/MM/DD
        $path = $file->storeAs(
            'espaces/' . date('Y/m/d'),
            uniqid() . '_' . $file->getClientOriginalName(),
            'public'
        );

        // Enregistrer le chemin dans la base (accessible via asset())
        $data['vignette'] = 'storage/' . $path;
    }

    $this->espace->fill($data)->save();

    Alert::info('Espace enregistré avec succès.');

    return redirect()->route('platform.espace.list');
}

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function remove()
    {
        $this->espace->delete();

        Alert::info('Vous avez supprimé l\'espace avec succès.');

        return redirect()->route('platform.espace.list');
    }

}
