<?php

namespace App\Orchid\Screens\Ressourcetypeoffretype;

use Orchid\Screen\Screen;

use App\Models\Ressourcetypeoffretype;
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
     * @var Ressourcetypeoffretype
     */
    public $ressourcetypeoffretype;

    /**
     * Query data.
     *
     * @param Ressourcetypeoffretype $ressourcetypeoffretype
     *
     * @return array
     */
    public function query(Ressourcetypeoffretype $ressourcetypeoffretype): array
    {
        return [
            'ressourcetypeoffretype' => $ressourcetypeoffretype
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return $this->ressourcetypeoffretype->exists ? 'Modification du type de paiement' : 'Créer un type de paiement';
    }

    /**
     * The description is displayed on the user's screen under the heading
     */
    public function description(): ?string
    {
        return "Tous les types des paiements enregistrés";
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Button::make('Créer un type de paiement')
                ->icon('pencil')
                ->method('createOrUpdate')
                ->canSee(!$this->ressourcetypeoffretype->exists),

            Button::make('Modifier le type de paiement')
                ->icon('note')
                ->method('createOrUpdate')
                ->canSee($this->ressourcetypeoffretype->exists),

            Button::make('Supprimer')
                ->icon('trash')
                ->method('remove')
                ->canSee($this->ressourcetypeoffretype->exists),
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

                Select::make('ressourcetypeoffretype.ressourcetype_id')
                    ->title('Type de ressource')
                    ->placeholder('Choisir le type')
                    ->fromModel(\App\Models\Ressourcetype::class, 'titre')
                    ->empty('Choisir', 0),

                Select::make('ressourcetypeoffretype.offretype_id')
                    ->title('Type d\'offre')
                    ->placeholder('Choisir le type')
                    ->fromModel(\App\Models\Offretype::class, 'titre')
                    ->empty('Choisir', 0),

                Input::make('ressourcetypeoffretype.table_id')
                    ->title('Id offre')
                    ->placeholder('Saisir id du type offre'),


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
    $data = $request->get('ressourcetypeoffretype');

    $this->ressourcetypeoffretype->fill($data)->save();

    Alert::info('Type de paiement enregistré avec succès.');

    return redirect()->route('platform.ressourcetypeoffretype.list');
}

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function remove()
    {
        $this->ressourcetypeoffretype->delete();

        Alert::info('Vous avez supprimé le type de paiement avec succès.');

        return redirect()->route('platform.ressourcetypeoffretype.list');
    }

}
