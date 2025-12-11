<?php

namespace App\Orchid\Screens\Parametres;

use Orchid\Screen\Screen;
use Orchid\Screen\Fields\Input;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Actions\ModalToggle;

use App\Models\Partenairetype;
use Illuminate\Http\Request;

use Orchid\Screen\TD;
use Orchid\Screen\Actions\Button;

use Illuminate\Support\Facades\Redirect; // si tu veux rediriger après

class PartenairetypeScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            'partenairetypes' => Partenairetype::latest()->paginate(20),
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Liste des types de partenaires';
    }

    /**
     * Displays a description on the user's screen
     * directly under the heading.
     */
    public function description(): ?string
    {
        return "Paramètres";
    }

    public function asyncPartenairetype(Partenairetype $partenairetype): iterable
    {
        return [
            'partenairetype' => $partenairetype
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
            ModalToggle::make('Ajouter un type de partenaire')
                ->modal('partenairetypeModal')
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
            Layout::table('partenairetypes', [
                TD::make('titre'),

                TD::make('etat', 'État')
                    ->render(function (Partenairetype $partenairetype) {
                        return Button::make($partenairetype->etat ? 'Désactiver' : 'Activer')
                            ->method('toggleEtat', [
                                'partenairetype' => $partenairetype->id,
                            ])
                            ->icon($partenairetype->etat ? 'toggle-on' : 'toggle-off')
                            ->class($partenairetype->etat ? 'btn btn-success' : 'btn btn-secondary');
                    }),

                TD::make('Actions')
                    ->alignRight()
                    ->render(function (Partenairetype $partenairetype) {
                        return ModalToggle::make('Modifier')
                                ->modal('editPartenairetypeModal')
                                ->modalTitle('Modifier le type de partenaire')
                                ->method('update')
                                ->asyncParameters([
                                    'partenairetype' => $partenairetype->id,
                                ])
                                ->icon('pencil')
                                ->class('btn btn-sm btn-warning')
                            . ' ' . 
                            Button::make('Supprimer')
                                ->confirm('Après la suppression, le type de partenaire disparaîtra définitivement.')
                                ->method('delete', ['partenairetype' => $partenairetype->id])
                                ->icon('trash')
                                ->class('btn btn-sm btn-danger');
                    }),

            ]),

            Layout::modal('partenairetypeModal', Layout::rows([
                Input::make('partenairetype.titre')
                    ->title('Titre')
                    ->placeholder('Entrez le nom du type de partenaire')
                    ->help('Le nom du type de partenaire à créer.'),
            ]))
                ->title('Créer un type de partenaire')
                ->applyButton('Ajouter un type de partenaire'),


            Layout::modal('editPartenairetypeModal', Layout::rows([
                Input::make('partenairetype.id')->type('hidden'),

                Input::make('partenairetype.titre')
                    ->title('Titre')
                    ->required(),
            ]))
                ->async('asyncPartenairetype')
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
        // Validate form data, save partenairetype to database, etc.
        $request->validate([
            'partenairetype.titre' => 'required|max:255',
        ]);

        $partenairetype = new Partenairetype();
        $partenairetype->titre = $request->input('partenairetype.titre');
        $partenairetype->save();
    }

    /**
     * @param Partenairetype $partenairetype
     *
     * @return void
     */
    public function delete(Partenairetype $partenairetype)
    {
        $partenairetype->delete();
    }



    public function toggleEtat(Request $request)
    {
        $partenairetype = Partenairetype::findOrFail($request->input('partenairetype'));
        $partenairetype->etat = !$partenairetype->etat;
        $partenairetype->save();
    }

    public function update(Request $request)
    {
        $request->validate([
            'partenairetype.titre' => 'required|max:255',
        ]);

        $partenairetype = Partenairetype::findOrFail($request->input('partenairetype.id'));
        $partenairetype->titre = $request->input('partenairetype.titre');
        $partenairetype->save();
    }

}
