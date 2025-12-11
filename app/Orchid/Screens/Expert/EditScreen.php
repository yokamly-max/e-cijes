<?php

namespace App\Orchid\Screens\Expert;

use Orchid\Screen\Screen;

use App\Models\Expert;
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
     * @var Expert
     */
    public $expert;

    /**
     * Query data.
     *
     * @param Expert $expert
     *
     * @return array
     */
    public function query(Expert $expert): array
    {
        return [
            'expert' => $expert
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return $this->expert->exists ? 'Modification de l\'expert' : 'Créer un expert';
    }

    /**
     * The description is displayed on the user's screen under the heading
     */
    public function description(): ?string
    {
        return "Tous les experts enregistrés";
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Button::make('Créer un expert')
                ->icon('pencil')
                ->method('createOrUpdate')
                ->canSee(!$this->expert->exists),

            Button::make('Modifier l\'expert')
                ->icon('note')
                ->method('createOrUpdate')
                ->canSee($this->expert->exists),

            Button::make('Supprimer')
                ->icon('trash')
                ->method('remove')
                ->canSee($this->expert->exists),
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
                Select::make('expert.membre_id')
                    ->title('Membre')
                    ->placeholder('Choisir le membre')
                    //->help('Spécifiez un membre.')
                    ->options(
                        \App\Models\Membre::all()
                            ->mapWithKeys(function ($membre) {
                                return [$membre->id => trim("{$membre->prenom} {$membre->nom}")];
                            })
                            ->toArray())
                    ->empty('Choisir', 0),

                /*TextArea::make('expert.domaine')
                    ->title('Domaine')
                    ->placeholder('Saisir la domaine'),
                    //->help('Spécifiez une domaine pour cette expert')*/

                Quill::make('expert.domaine')
                    ->title('Domaine')
                    //->popover('Saisir le domaine')
                    ->placeholder('Saisir les domaines d\'expertises'),

                Select::make('expert.experttype_id')
                    ->title('Type d\'expert')
                    ->placeholder('Choisir le type')
                    ->fromModel(\App\Models\Experttype::class, 'titre')
                    ->empty('Choisir', 0),

                Select::make('expert.expertvalide_id')
                    ->title('Validation d\'expert')
                    ->placeholder('Choisir la validation d\'expert')
                    ->fromModel(\App\Models\Expertvalide::class, 'titre')
                    ->empty('Choisir', 0),

                Input::make('fichier')
                    ->type('file')
                    ->title('Fichier (PDF)')// ou image
                    ->accept('.pdf')//,image/*
                    ->help('Uploader un fichier PDF (1 seul fichier).'),// ou image

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
    $data = $request->get('expert');

    if ($request->hasFile('fichier')) {
        $file = $request->file('fichier');

        // Stocker dans /storage/app/public/experts/YYYY/MM/DD
        $path = $file->storeAs(
            'experts/' . date('Y/m/d'),
            uniqid() . '_' . $file->getClientOriginalName(),
            'public'
        );

        // Enregistrer le chemin dans la base (accessible via asset())
        $data['fichier'] = 'storage/' . $path;
    }

    $this->expert->fill($data)->save();

    Alert::info('Expert enregistré avec succès.');

    return redirect()->route('platform.expert.list');
}

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function remove()
    {
        $this->expert->delete();

        Alert::info('Vous avez supprimé l\'expert avec succès.');

        return redirect()->route('platform.expert.list');
    }

}
