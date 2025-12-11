<?php

namespace App\Orchid\Screens\Conversation;

use Orchid\Screen\Screen;

use App\Models\Conversation;
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
     * @var Conversation
     */
    public $conversation;

    /**
     * Query data.
     *
     * @param Conversation $conversation
     *
     * @return array
     */
    public function query(Conversation $conversation): array
    {
        return [
            'conversation' => $conversation
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return $this->conversation->exists ? 'Modification de la conversation' : 'Créer une conversation';
    }

    /**
     * The description is displayed on the user's screen under the heading
     */
    public function description(): ?string
    {
        return "Toutes les conversations enregistrées";
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Button::make('Créer une conversation')
                ->icon('pencil')
                ->method('createOrUpdate')
                ->canSee(!$this->conversation->exists),

            Button::make('Modifier la conversation')
                ->icon('note')
                ->method('createOrUpdate')
                ->canSee($this->conversation->exists),

            Button::make('Supprimer')
                ->icon('trash')
                ->method('remove')
                ->canSee($this->conversation->exists),
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

                Select::make('conversation.membre_id1')
                    ->title('Membre 1')
                    ->placeholder('Choisir le membre')
                    ->options(
                        \App\Models\Membre::all()
                            ->mapWithKeys(function ($membre) {
                                return [$membre->id => trim("{$membre->prenom} {$membre->nom}")];
                            })
                            ->toArray())
                    ->empty('Choisir', 0),

                Select::make('conversation.membre_id2')
                    ->title('Membre 2')
                    ->placeholder('Choisir le membre')
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
    $data = $request->get('conversation');

    $this->conversation->fill($data)->save();

    Alert::info('Conversation enregistrée avec succès.');

    return redirect()->route('platform.conversation.list');
}

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function remove()
    {
        $this->conversation->delete();

        Alert::info('Vous avez supprimé la conversation avec succès.');

        return redirect()->route('platform.conversation.list');
    }

}
