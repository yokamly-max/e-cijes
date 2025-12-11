<?php

namespace App\Orchid\Screens\Messageforum;

use Orchid\Screen\Screen;

use App\Models\Messageforum;
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
     * @var Messageforum
     */
    public $messageforum;

    /**
     * Query data.
     *
     * @param Messageforum $messageforum
     *
     * @return array
     */
    public function query(Messageforum $messageforum): array
    {
        return [
            'messageforum' => $messageforum
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return $this->messageforum->exists ? 'Modification du message' : 'Créer un message';
    }

    /**
     * The description is displayed on the user's screen under the heading
     */
    public function description(): ?string
    {
        return "Tous les messages enregistrés";
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Button::make('Créer un message')
                ->icon('pencil')
                ->method('createOrUpdate')
                ->canSee(!$this->messageforum->exists),

            Button::make('Modifier le message')
                ->icon('note')
                ->method('createOrUpdate')
                ->canSee($this->messageforum->exists),

            Button::make('Supprimer')
                ->icon('trash')
                ->method('remove')
                ->canSee($this->messageforum->exists),
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
                TextArea::make('messageforum.contenu')
                    ->title('Contenu')
                    ->required()
                    ->placeholder('Saisir le contenu'),

                Select::make('messageforum.sujet_id')
                    ->title('Sujet')
                    ->placeholder('Choisir le sujet')
                    ->fromModel(\App\Models\Sujet::class, 'titre')
                    ->empty('Choisir', 0),

                Select::make('messageforum.membre_id')
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
    $data = $request->get('messageforum');

    $this->messageforum->fill($data)->save();

    Alert::info('Message enregistré avec succès.');

    return redirect()->route('platform.messageforum.list');
}

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function remove()
    {
        $this->messageforum->delete();

        Alert::info('Vous avez supprimé le message avec succès.');

        return redirect()->route('platform.messageforum.list');
    }

}
