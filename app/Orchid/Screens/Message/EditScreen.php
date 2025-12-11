<?php

namespace App\Orchid\Screens\Message;

use Orchid\Screen\Screen;

use App\Models\Message;
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
     * @var Message
     */
    public $message;

    /**
     * Query data.
     *
     * @param Message $message
     *
     * @return array
     */
    public function query(Message $message): array
    {
        return [
            'message' => $message
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return $this->message->exists ? 'Modification du message' : 'Créer un message';
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
                ->canSee(!$this->message->exists),

            Button::make('Modifier le message')
                ->icon('note')
                ->method('createOrUpdate')
                ->canSee($this->message->exists),

            Button::make('Supprimer')
                ->icon('trash')
                ->method('remove')
                ->canSee($this->message->exists),
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
                TextArea::make('message.contenu')
                    ->title('Contenu')
                    ->required()
                    ->placeholder('Saisir le contenu'),

                Select::make('message.conversation_id')
                    ->title('Conversation')
                    ->placeholder('Choisir la conversation')
                    ->fromModel(\App\Models\Conversation::class, 'membre_id1')
                    ->empty('Choisir', 0),

                Select::make('message.membre_id')
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
    $data = $request->get('message');

    $this->message->fill($data)->save();

    Alert::info('Message enregistré avec succès.');

    return redirect()->route('platform.message.list');
}

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function remove()
    {
        $this->message->delete();

        Alert::info('Vous avez supprimé le message avec succès.');

        return redirect()->route('platform.message.list');
    }

}
