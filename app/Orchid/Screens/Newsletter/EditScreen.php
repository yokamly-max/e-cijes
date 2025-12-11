<?php

namespace App\Orchid\Screens\Newsletter;

use Orchid\Screen\Screen;

use App\Models\Newsletter;
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
     * @var Newsletter
     */
    public $newsletter;

    /**
     * Query data.
     *
     * @param Newsletter $newsletter
     *
     * @return array
     */
    public function query(Newsletter $newsletter): array
    {
        return [
            'newsletter' => $newsletter
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return $this->newsletter->exists ? 'Modification de la newsletter' : 'Créer une newsletter';
    }

    /**
     * The description is displayed on the user's screen under the heading
     */
    public function description(): ?string
    {
        return "Toutes les newsletters enregistrées";
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Button::make('Créer une newsletter')
                ->icon('pencil')
                ->method('createOrUpdate')
                ->canSee(!$this->newsletter->exists),

            Button::make('Modifier la newsletter')
                ->icon('note')
                ->method('createOrUpdate')
                ->canSee($this->newsletter->exists),

            Button::make('Supprimer')
                ->icon('trash')
                ->method('remove')
                ->canSee($this->newsletter->exists),
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
                Input::make('newsletter.nom')
                    ->title('Nom et prénom.s')
                    ->placeholder('Saisir le nom et prénom.s'),

                Input::make('newsletter.email')
                    ->title('Email')
                    ->required()
                    ->placeholder('Saisir l\'email'),

                Select::make('newsletter.pays_id')
                    ->title('Pays')
                    ->placeholder('Choisir le pays')
                    ->options($paysList)
                    ->empty('Choisir', 0),

                Select::make('newsletter.newslettertype_id')
                    ->title('Type d\'newsletter')
                    ->placeholder('Choisir le type')
                    //->help('Spécifiez un type d\'newsletter.')
                    ->fromModel(\App\Models\Newslettertype::class, 'titre')
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
    $data = $request->get('newsletter');

    $this->newsletter->fill($data)->save();

    Alert::info('Newsletter enregistrée avec succès.');

    return redirect()->route('platform.newsletter.list');
}

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function remove()
    {
        $this->newsletter->delete();

        Alert::info('Vous avez supprimé la newsletter avec succès.');

        return redirect()->route('platform.newsletter.list');
    }

}
