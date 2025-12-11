<?php

namespace App\Orchid\Screens\Parametres;

use Orchid\Screen\Screen;
use Orchid\Screen\Fields\Input;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Actions\ModalToggle;

use App\Models\Newslettertype;
use Illuminate\Http\Request;

use Orchid\Screen\TD;
use Orchid\Screen\Actions\Button;

use Illuminate\Support\Facades\Redirect; // si tu veux rediriger après

class NewslettertypeScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            'newslettertypes' => Newslettertype::latest()->paginate(20),
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Liste des types des newsletters';
    }

    /**
     * Displays a description on the user's screen
     * directly under the heading.
     */
    public function description(): ?string
    {
        return "Paramètres";
    }

    public function asyncNewslettertype(Newslettertype $newslettertype): iterable
    {
        return [
            'newslettertype' => $newslettertype
        ];
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            ModalToggle::make('Ajouter un type de newsletter')
                ->modal('newslettertypeModal')
                ->method('create')
                ->icon('plus'),
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
            Layout::table('newslettertypes', [
                TD::make('titre'),

                TD::make('etat', 'État')
                    ->render(function (Newslettertype $newslettertype) {
                        return Button::make($newslettertype->etat ? 'Désactiver' : 'Activer')
                            ->method('toggleEtat', [
                                'newslettertype' => $newslettertype->id,
                            ])
                            ->icon($newslettertype->etat ? 'toggle-on' : 'toggle-off')
                            ->class($newslettertype->etat ? 'btn btn-success' : 'btn btn-secondary');
                    }),

                TD::make('Actions')
                    ->alignRight()
                    ->render(function (Newslettertype $newslettertype) {
                        return ModalToggle::make('Modifier')
                                ->modal('editNewslettertypeModal')
                                ->modalTitle('Modifier le type de newsletter')
                                ->method('update')
                                ->asyncParameters([
                                    'newslettertype' => $newslettertype->id,
                                ])
                                ->icon('pencil')
                                ->class('btn btn-sm btn-warning')
                            . ' ' . 
                            Button::make('Supprimer')
                                ->confirm('Après la suppression, le type de newsletter disparaîtra définitivement.')
                                ->method('delete', ['newslettertype' => $newslettertype->id])
                                ->icon('trash')
                                ->class('btn btn-sm btn-danger');
                    }),

            ]),

            Layout::modal('newslettertypeModal', Layout::rows([
                Input::make('newslettertype.titre')
                    ->title('Titre')
                    ->placeholder('Entrez le nom du type de newsletter')
                    ->help('Le nom du type de newsletter à créer.'),
            ]))
                ->title('Créer un type de newsletter')
                ->applyButton('Ajouter un type de newsletter'),


            Layout::modal('editNewslettertypeModal', Layout::rows([
                Input::make('newslettertype.id')->type('hidden'),

                Input::make('newslettertype.titre')
                    ->title('Titre')
                    ->required(),
            ]))
                ->async('asyncNewslettertype')
                ->applyButton('Mettre à jour'),

        ];
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return void
     */
    public function create(Request $request)
    {
        // Validate form data, save newslettertype to database, etc.
        $request->validate([
            'newslettertype.titre' => 'required|max:255',
        ]);

        $newslettertype = new Newslettertype();
        $newslettertype->titre = $request->input('newslettertype.titre');
        $newslettertype->save();
    }

    /**
     * @param Newslettertype $newslettertype
     *
     * @return void
     */
    public function delete(Newslettertype $newslettertype)
    {
        $newslettertype->delete();
    }



    public function toggleEtat(Request $request)
    {
        $newslettertype = Newslettertype::findOrFail($request->input('newslettertype'));
        $newslettertype->etat = !$newslettertype->etat;
        $newslettertype->save();
    }

    public function update(Request $request)
    {
        $request->validate([
            'newslettertype.titre' => 'required|max:255',
        ]);

        $newslettertype = Newslettertype::findOrFail($request->input('newslettertype.id'));
        $newslettertype->titre = $request->input('newslettertype.titre');
        $newslettertype->save();
    }

}
