<?php

namespace App\Orchid\Screens\Forum;

use Orchid\Screen\Screen;

use App\Models\Forum;
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
     * @var Forum
     */
    public $forum;

    /**
     * Query data.
     *
     * @param Forum $forum
     *
     * @return array
     */
    public function query(Forum $forum): array
    {
        return [
            'forum' => $forum
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return $this->forum->exists ? 'Modification du forum' : 'Créer un forum';
    }

    /**
     * The description is displayed on the user's screen under the heading
     */
    public function description(): ?string
    {
        return "Tous les forums enregistrés";
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Button::make('Créer un forum')
                ->icon('pencil')
                ->method('createOrUpdate')
                ->canSee(!$this->forum->exists),

            Button::make('Modifier le forum')
                ->icon('note')
                ->method('createOrUpdate')
                ->canSee($this->forum->exists),

            Button::make('Supprimer')
                ->icon('trash')
                ->method('remove')
                ->canSee($this->forum->exists),
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
                Input::make('forum.titre')
                    ->title('Titre')
                    ->required()
                    ->placeholder('Saisir le titre'),

                TextArea::make('forum.resume')
                    ->title('Résumé')
                    ->placeholder('Saisir le résumé'),

                DateTimer::make('forum.dateforum')
                    ->title('Date du forum')
                    ->format('Y-m-d'),

                /*TextArea::make('forum.description')
                    ->title('Description')
                    ->placeholder('Saisir la description'),
                    //->help('Spécifiez une description pour cette forum')*/

                Quill::make('forum.description')
                    ->title('Description')
                    //->popover('Saisir la description')
                    ->placeholder('Saisir la description'),

                Select::make('forum.forumtype_id')
                    ->title('Type du forum')
                    ->placeholder('Choisir le type')
                    ->fromModel(\App\Models\Forumtype::class, 'titre')
                    ->empty('Choisir', 0),

                Select::make('forum.secteur_id')
                    ->title('Secteur')
                    ->placeholder('Choisir le secteur')
                    ->fromModel(\App\Models\Secteur::class, 'titre')
                    ->empty('Choisir', 0),

                Input::make('vignette')
                    ->type('file')
                    ->title('Vignette (image)')// ou PDF
                    ->accept('image/*')//,.pdf
                    ->help('Uploader un fichier image (1 seul fichier).'),// ou PDF

                Select::make('forum.langue_id')
                    ->title('Langue')
                    ->placeholder('Choisir la langue')
                    ->options($langueList)
                    ->empty('Choisir', 0),


                Select::make('forum.pays_id')
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
    $data = $request->get('forum');

    if ($request->hasFile('vignette')) {
        $file = $request->file('vignette');

        // Stocker dans /storage/app/public/forums/YYYY/MM/DD
        $path = $file->storeAs(
            'forums/' . date('Y/m/d'),
            uniqid() . '_' . $file->getClientOriginalName(),
            'public'
        );

        // Enregistrer le chemin dans la base (accessible via asset())
        $data['vignette'] = 'storage/' . $path;
    }

    $this->forum->fill($data)->save();

    Alert::info('Forum enregistré avec succès.');

    return redirect()->route('platform.forum.list');
}

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function remove()
    {
        $this->forum->delete();

        Alert::info('Vous avez supprimé le forum avec succès.');

        return redirect()->route('platform.forum.list');
    }

}
