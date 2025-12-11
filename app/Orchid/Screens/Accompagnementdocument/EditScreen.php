<?php

namespace App\Orchid\Screens\Accompagnementdocument;

use Orchid\Screen\Screen;

use App\Models\Accompagnementdocument;
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
     * @var Accompagnementdocument
     */
    public $accompagnementdocument;

    /**
     * Query data.
     *
     * @param Accompagnementdocument $accompagnementdocument
     *
     * @return array
     */
    public function query(Accompagnementdocument $accompagnementdocument): array
    {
        return [
            'accompagnementdocument' => $accompagnementdocument
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return $this->accompagnementdocument->exists ? 'Modification du document' : 'Créer un document';
    }

    /**
     * The description is displayed on the user's screen under the heading
     */
    public function description(): ?string
    {
        return "Tous les documents d'accompagnement enregistrés";
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Button::make('Créer un document')
                ->icon('pencil')
                ->method('createOrUpdate')
                ->canSee(!$this->accompagnementdocument->exists),

            Button::make('Modifier le document')
                ->icon('note')
                ->method('createOrUpdate')
                ->canSee($this->accompagnementdocument->exists),

            Button::make('Supprimer')
                ->icon('trash')
                ->method('remove')
                ->canSee($this->accompagnementdocument->exists),
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
                Select::make('accompagnementdocument.accompagnement_id')
                    ->title('Accompagnement')
                    ->placeholder('Choisir l\'accompagnement')
                    ->options(
                        \App\Models\Accompagnement::with('membre', 'entreprise')->get()
                            ->mapWithKeys(function ($accompagnement) {
                                $membre = $accompagnement->membre ? $accompagnement->membre->prenom . ' ' . $accompagnement->membre->nom : '';
                                $entreprise = $accompagnement->entreprise ? $accompagnement->entreprise->nom : '';
                                return [$accompagnement->id => "$membre - $entreprise"];
                            })
                            ->toArray()
                    )
                    ->empty('Choisir', 0),

                Select::make('accompagnementdocument.document_id')
                    ->title('Document')
                    ->placeholder('Choisir le document')
                    ->fromModel(\App\Models\Document::class, 'titre')
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
    $data = $request->get('accompagnementdocument');

    $this->accompagnementdocument->fill($data)->save();

    Alert::info('Document d\'accompagnement enregistré avec succès.');

    return redirect()->route('platform.accompagnementdocument.list');
}

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function remove()
    {
        $this->accompagnementdocument->delete();

        Alert::info('Vous avez supprimé le document d\'accompagnement avec succès.');

        return redirect()->route('platform.accompagnementdocument.list');
    }

}
