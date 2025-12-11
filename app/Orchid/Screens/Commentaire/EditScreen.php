<?php

namespace App\Orchid\Screens\Commentaire;

use Orchid\Screen\Screen;

use App\Models\Commentaire;
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
     * @var Commentaire
     */
    public $commentaire;

    /**
     * Query data.
     *
     * @param Commentaire $commentaire
     *
     * @return array
     */
    public function query(Commentaire $commentaire): array
    {
        return [
            'commentaire' => $commentaire
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return $this->commentaire->exists ? 'Modification du commentaire' : 'Créer un commentaire';
    }

    /**
     * The description is displayed on the user's screen under the heading
     */
    public function description(): ?string
    {
        return "Tous les commentaires enregistrés";
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Button::make('Créer un commentaire')
                ->icon('pencil')
                ->method('createOrUpdate')
                ->canSee(!$this->commentaire->exists),

            Button::make('Modifier le commentaire')
                ->icon('note')
                ->method('createOrUpdate')
                ->canSee($this->commentaire->exists),

            Button::make('Supprimer')
                ->icon('trash')
                ->method('remove')
                ->canSee($this->commentaire->exists),
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
                Input::make('commentaire.nom')
                    ->title('Nom et prénom(s)')
                    ->required()
                    ->placeholder('Saisir le nom et prénom(s)'),
                    //->help('Spécifiez un nom et prénom(s) pour cette commentaire.')

                Input::make('commentaire.email')
                    ->title('Email')
                    ->placeholder('Saisir l\'email'),
                    //->help('Spécifiez un email pour cette commentaire.')

                TextArea::make('commentaire.message')
                    ->title('Message')
                    ->placeholder('Saisir le message'),
                    //->help('Spécifiez un message pour cette commentaire')

                Select::make('commentaire.actualite_id')
                    ->title('Actualité')
                    ->placeholder('Choisir l\'actualite')
                    //->help('Spécifiez une actualite.')
                    ->fromModel(\App\Models\Actualite::class, 'titre')
                    ->empty('Choisir', 0),

                Select::make('commentaire.pays_id')
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
    $data = $request->get('commentaire');

    $this->commentaire->fill($data)->save();

    Alert::info('Commentaire enregistré avec succès.');

    return redirect()->route('platform.commentaire.list');
}

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function remove()
    {
        $this->commentaire->delete();

        Alert::info('Vous avez supprimé le commentaire avec succès.');

        return redirect()->route('platform.commentaire.list');
    }

}
