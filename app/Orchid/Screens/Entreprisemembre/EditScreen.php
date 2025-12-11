<?php

namespace App\Orchid\Screens\Entreprisemembre;

use Orchid\Screen\Screen;

use App\Models\Entreprisemembre;
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
     * @var Entreprisemembre
     */
    public $entreprisemembre;

    /**
     * Query data.
     *
     * @param Entreprisemembre $entreprisemembre
     *
     * @return array
     */
    public function query(Entreprisemembre $entreprisemembre): array
    {
        return [
            'entreprisemembre' => $entreprisemembre
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return $this->entreprisemembre->exists ? 'Modification du membre de l\'entreprise' : 'Créer un membre de l\'entreprise';
    }

    /**
     * The description is displayed on the user's screen under the heading
     */
    public function description(): ?string
    {
        return "Tous les membres de l'entreprise enregistrés";
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Button::make('Créer un membre de l\'entreprise')
                ->icon('pencil')
                ->method('createOrUpdate')
                ->canSee(!$this->entreprisemembre->exists),

            Button::make('Modifier le membre de l\'entreprise')
                ->icon('note')
                ->method('createOrUpdate')
                ->canSee($this->entreprisemembre->exists),

            Button::make('Supprimer')
                ->icon('trash')
                ->method('remove')
                ->canSee($this->entreprisemembre->exists),
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
                Input::make('entreprisemembre.fonction')
                    ->title('Fonction')
                    ->require()
                    ->placeholder('Saisir la fonction'),

                TextArea::make('entreprisemembre.bio')
                    ->title('Bio')
                    ->placeholder('Saisir la bio'),

                Select::make('entreprisemembre.membre_id')
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

                Select::make('entreprisemembre.entreprise_id')
                    ->title('Entreprise')
                    ->placeholder('Choisir l\'entreprise')
                    //->help('Spécifiez une entreprise.')
                    ->fromModel(\App\Models\Entreprise::class, 'nom')
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
        $data = $request->get('entreprisemembre');

        $this->entreprisemembre->fill($data)->save();

        Alert::info('Membre de l\'entreprise enregistré avec succès.');

        return redirect()->route('platform.entreprisemembre.list');
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function remove()
    {
        $this->entreprisemembre->delete();

        Alert::info('Vous avez supprimé le membre de l\'entreprise avec succès.');

        return redirect()->route('platform.entreprisemembre.list');
    }

}
