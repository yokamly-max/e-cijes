<?php

namespace App\Orchid\Screens\Sujet;

use Orchid\Screen\Screen;

use App\Models\Sujet;
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
     * @var Sujet
     */
    public $sujet;

    /**
     * Query data.
     *
     * @param Sujet $sujet
     *
     * @return array
     */
    public function query(Sujet $sujet): array
    {
        return [
            'sujet' => $sujet
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return $this->sujet->exists ? 'Modification du sujet' : 'Créer un sujet';
    }

    /**
     * The description is displayed on the user's screen under the heading
     */
    public function description(): ?string
    {
        return "Tous les sujets enregistrés";
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Button::make('Créer un sujet')
                ->icon('pencil')
                ->method('createOrUpdate')
                ->canSee(!$this->sujet->exists),

            Button::make('Modifier le sujet')
                ->icon('note')
                ->method('createOrUpdate')
                ->canSee($this->sujet->exists),

            Button::make('Supprimer')
                ->icon('trash')
                ->method('remove')
                ->canSee($this->sujet->exists),
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
                Input::make('sujet.titre')
                    ->title('Titre')
                    ->required()
                    ->placeholder('Saisir le titre'),

                TextArea::make('sujet.resume')
                    ->title('Résumé')
                    ->placeholder('Saisir le résumé'),

                /*TextArea::make('sujet.description')
                    ->title('Description')
                    ->placeholder('Saisir la description'),
                    //->help('Spécifiez une description pour cette sujet')*/

                Quill::make('sujet.description')
                    ->title('Description')
                    //->popover('Saisir la description')
                    ->placeholder('Saisir la description'),

                Select::make('sujet.forum_id')
                    ->title('Forum')
                    ->placeholder('Choisir le forum')
                    ->fromModel(\App\Models\Forum::class, 'titre')
                    ->empty('Choisir', 0),

                Input::make('vignette')
                    ->type('file')
                    ->title('Vignette (image)')// ou PDF
                    ->accept('image/*')//,.pdf
                    ->help('Uploader un fichier image (1 seul fichier).'),// ou PDF

                Select::make('sujet.membre_id')
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
    $data = $request->get('sujet');

    if ($request->hasFile('vignette')) {
        $file = $request->file('vignette');

        // Stocker dans /storage/app/public/sujets/YYYY/MM/DD
        $path = $file->storeAs(
            'sujets/' . date('Y/m/d'),
            uniqid() . '_' . $file->getClientOriginalName(),
            'public'
        );

        // Enregistrer le chemin dans la base (accessible via asset())
        $data['vignette'] = 'storage/' . $path;
    }

    $this->sujet->fill($data)->save();

    Alert::info('Sujet enregistré avec succès.');

    return redirect()->route('platform.sujet.list');
}

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function remove()
    {
        $this->sujet->delete();

        Alert::info('Vous avez supprimé le sujet avec succès.');

        return redirect()->route('platform.sujet.list');
    }

}
