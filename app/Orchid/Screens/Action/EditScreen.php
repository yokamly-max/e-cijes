<?php

namespace App\Orchid\Screens\Action;

use Orchid\Screen\Screen;

use App\Models\Action;
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
     * @var Action
     */
    public $action;

    /**
     * Query data.
     *
     * @param Action $action
     *
     * @return array
     */
    public function query(Action $action): array
    {
        return [
            'action' => $action
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return $this->action->exists ? 'Modification de l\'action' : 'Créer une action';
    }

    /**
     * The description is displayed on the user's screen under the heading
     */
    public function description(): ?string
    {
        return "Toutes les actions enregistrées";
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Button::make('Créer une action')
                ->icon('pencil')
                ->method('createOrUpdate')
                ->canSee(!$this->action->exists),

            Button::make('Modifier l\'action')
                ->icon('note')
                ->method('createOrUpdate')
                ->canSee($this->action->exists),

            Button::make('Supprimer')
                ->icon('trash')
                ->method('remove')
                ->canSee($this->action->exists),
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
                Input::make('action.titre')
                    ->title('Titre')
                    ->required()
                    ->placeholder('Saisir le titre'),

                Input::make('action.code')
                    ->title('Code')
                    ->required()
                    ->placeholder('Saisir le code'),

                Input::make('action.point')
                    ->title('Point')
                    ->placeholder('Saisir le point'),

                Input::make('action.limite')
                    ->title('Limite')
                    ->placeholder('Saisir la limite'),

                Input::make('action.seuil')
                    ->title('Seuil')
                    ->placeholder('Saisir le seuil'),

                Select::make('action.ressourcetype_id')
                    ->title('Type de ressource')
                    ->placeholder('Choisir le type')
                    ->fromModel(\App\Models\Ressourcetype::class, 'titre')
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
    $data = $request->get('action');

    $this->action->fill($data)->save();

    Alert::info('Action enregistrée avec succès.');

    return redirect()->route('platform.action.list');
}

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function remove()
    {
        $this->action->delete();

        Alert::info('Vous avez supprimé l\'action avec succès.');

        return redirect()->route('platform.action.list');
    }

}
