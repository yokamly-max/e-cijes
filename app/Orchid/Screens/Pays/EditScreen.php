<?php

namespace App\Orchid\Screens\Pays;

use Orchid\Screen\Screen;

use App\Models\Pays;
use Illuminate\Http\Request;
use Orchid\Screen\Fields\Input;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Actions\Button;
use Orchid\Support\Facades\Alert;

class EditScreen extends Screen
{
    /**
     * @var Pays
     */
    public $pays;

    /**
     * Query data.
     *
     * @param Pays $pays
     *
     * @return array
     */
    public function query(Pays $pays): array
    {
        return [
            'pays' => $pays
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return $this->pays->exists ? 'Modification d\'un pays' : 'Créer un nouveau pays';
    }

    /**
     * The description is displayed on the user's screen under the heading
     */
    public function description(): ?string
    {
        return "Tous les pays enregistrés";
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Button::make('Créer un pays')
                ->icon('pencil')
                ->method('createOrUpdate')
                ->canSee(!$this->pays->exists),

            Button::make('Modifier le pays')
                ->icon('note')
                ->method('createOrUpdate')
                ->canSee($this->pays->exists),

            Button::make('Supprimer')
                ->icon('trash')
                ->method('remove')
                ->canSee($this->pays->exists),
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
                Input::make('pays.nom')
                    ->title('Nom')
                    ->placeholder('Saisir le nom'),
                    //->help('Spécifiez un nom pour ce pays.')

                Input::make('pays.code')
                    ->title('Code')
                    ->placeholder('Saisir le code'),
                    //->help('Spécifiez un code pour ce pays.')

                Input::make('pays.indicatif')
                    ->title('Indicatif')
                    ->placeholder('Saisir l\'indicatif'),
                    //->help('Spécifiez un indicatif pour ce pays')

                Input::make('pays.monnaie')
                    ->title('Monnaie')
                    ->placeholder('Saisir la monnaie'),
                    //->help('Spécifiez une monnaie pour ce pays.')

                Input::make('drapeau')
                    ->type('file')
                    ->title('Drapeau (image)')// ou PDF
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
    $data = $request->get('pays');

    if ($request->hasFile('drapeau')) {
        $file = $request->file('drapeau');

        // Stocker dans /storage/app/public/drapeaux/YYYY/MM/DD
        $path = $file->storeAs(
            'drapeaux/' . date('Y/m/d'),
            uniqid() . '_' . $file->getClientOriginalName(),
            'public'
        );

        // Enregistrer le chemin dans la base (accessible via asset())
        $data['drapeau'] = 'storage/' . $path;
    }

    $this->pays->fill($data)->save();

    Alert::info('Pays enregistré avec succès.');

    return redirect()->route('platform.pays.list');
}

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function remove()
    {
        $this->pays->delete();

        Alert::info('Vous avez supprimé le pays avec succès.');

        return redirect()->route('platform.pays.list');
    }

}
