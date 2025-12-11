<?php

namespace App\Orchid\Screens\Contact;

use Orchid\Screen\Screen;

use App\Models\Contact;
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
     * @var Contact
     */
    public $contact;

    /**
     * Query data.
     *
     * @param Contact $contact
     *
     * @return array
     */
    public function query(Contact $contact): array
    {
        return [
            'contact' => $contact
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return $this->contact->exists ? 'Modification du contact' : 'Créer un contact';
    }

    /**
     * The description is displayed on the user's screen under the heading
     */
    public function description(): ?string
    {
        return "Tous les contacts enregistrés";
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Button::make('Créer un contact')
                ->icon('pencil')
                ->method('createOrUpdate')
                ->canSee(!$this->contact->exists),

            Button::make('Modifier le contact')
                ->icon('note')
                ->method('createOrUpdate')
                ->canSee($this->contact->exists),

            Button::make('Supprimer')
                ->icon('trash')
                ->method('remove')
                ->canSee($this->contact->exists),
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
                Input::make('contact.nom')
                    ->title('Nom et prénom(s)')
                    ->required()
                    ->placeholder('Saisir le nom et prénom(s)'),
                    //->help('Spécifiez un nom et prénom(s) pour cette contact.')

                Input::make('contact.email')
                    ->title('Email')
                    ->placeholder('Saisir le email'),
                    //->help('Spécifiez un email pour cette contact.')

                TextArea::make('contact.message')
                    ->title('Message')
                    ->placeholder('Saisir le message'),
                    //->help('Spécifiez un message pour cette contact')

                Select::make('contact.contacttype_id')
                    ->title('Type')
                    ->placeholder('Choisir le type')
                    //->help('Spécifiez une contacttype.')
                    ->fromModel(\App\Models\Contacttype::class, 'titre')
                    ->empty('Choisir', 0),

                Select::make('contact.pays_id')
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
    $data = $request->get('contact');

    $this->contact->fill($data)->save();

    Alert::info('Contact enregistré avec succès.');

    return redirect()->route('platform.contact.list');
}

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function remove()
    {
        $this->contact->delete();

        Alert::info('Vous avez supprimé le contact avec succès.');

        return redirect()->route('platform.contact.list');
    }

}
