<?php

namespace App\Orchid\Screens\Faq;

use Orchid\Screen\Screen;

use App\Models\Faq;
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
     * @var Faq
     */
    public $faq;

    /**
     * Query data.
     *
     * @param Faq $faq
     *
     * @return array
     */
    public function query(Faq $faq): array
    {
        return [
            'faq' => $faq
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return $this->faq->exists ? 'Modification de la question' : 'Créer une question';
    }

    /**
     * The description is displayed on the user's screen under the heading
     */
    public function description(): ?string
    {
        return "Toutes les questions de la FAQ enregistrées";
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Button::make('Créer une question')
                ->icon('pencil')
                ->method('createOrUpdate')
                ->canSee(!$this->faq->exists),

            Button::make('Modifier la question')
                ->icon('note')
                ->method('createOrUpdate')
                ->canSee($this->faq->exists),

            Button::make('Supprimer')
                ->icon('trash')
                ->method('remove')
                ->canSee($this->faq->exists),
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
                TextArea::make('faq.question')
                    ->title('Question')
                    ->placeholder('Saisir la question'),
                    //->help('Spécifiez une question pour cette question.')

                Quill::make('faq.reponse')
                    ->title('Reponse')
                    //->popover('Saisir la reponse')
                    ->placeholder('Saisir la reponse'),

                Select::make('faq.langue_id')
                    ->title('Langue')
                    ->placeholder('Choisir la langue')
                    ->options($langueList)
                    ->empty('Choisir', 0),


                Select::make('faq.pays_id')
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
        $data = $request->get('faq');

        $this->faq->fill($data)->save();

        Alert::info('FAQ enregistrée avec succès.');

        return redirect()->route('platform.faq.list');
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function remove()
    {
        $this->faq->delete();

        Alert::info('Vous avez supprimé la question avec succès.');

        return redirect()->route('platform.faq.list');
    }

}
