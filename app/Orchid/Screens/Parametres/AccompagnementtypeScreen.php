<?php

namespace App\Orchid\Screens\Parametres;

use Orchid\Screen\Screen;
use Orchid\Screen\Fields\Input;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Actions\ModalToggle;

use App\Models\Accompagnementtype;
use Illuminate\Http\Request;

use Orchid\Screen\TD;
use Orchid\Screen\Actions\Button;

use Illuminate\Support\Facades\Redirect; // si tu veux rediriger après

class AccompagnementtypeScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            'accompagnementtypes' => Accompagnementtype::latest()->paginate(20),
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Liste des types d\'accompagnements';
    }

    /**
     * Displays a description on the user's screen
     * directly under the heading.
     */
    public function description(): ?string
    {
        return "Paramètres";
    }

    public function asyncAccompagnementtype(Accompagnementtype $accompagnementtype): iterable
    {
        return [
            'accompagnementtype' => $accompagnementtype
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
            ModalToggle::make('Ajouter un type d\'accompagnement')
                ->modal('accompagnementtypeModal')
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
            Layout::table('accompagnementtypes', [
                TD::make('titre'),

                TD::make('etat', 'État')
                    ->render(function (Accompagnementtype $accompagnementtype) {
                        return Button::make($accompagnementtype->etat ? 'Désactiver' : 'Activer')
                            ->method('toggleEtat', [
                                'accompagnementtype' => $accompagnementtype->id,
                            ])
                            ->icon($accompagnementtype->etat ? 'toggle-on' : 'toggle-off')
                            ->class($accompagnementtype->etat ? 'btn btn-success' : 'btn btn-secondary');
                    }),

                TD::make('Actions')
                    ->alignRight()
                    ->render(function (Accompagnementtype $accompagnementtype) {
                        return ModalToggle::make('Modifier')
                                ->modal('editAccompagnementtypeModal')
                                ->modalTitle('Modifier le type d\'accompagnement')
                                ->method('update')
                                ->asyncParameters([
                                    'accompagnementtype' => $accompagnementtype->id,
                                ])
                                ->icon('pencil')
                                ->class('btn btn-sm btn-warning')
                            . ' ' . 
                            Button::make('Supprimer')
                                ->confirm('Après la suppression, le type d\'accompagnement disparaîtra définitivement.')
                                ->method('delete', ['accompagnementtype' => $accompagnementtype->id])
                                ->icon('trash')
                                ->class('btn btn-sm btn-danger');
                    }),

            ]),

            Layout::modal('accompagnementtypeModal', Layout::rows([
                Input::make('accompagnementtype.titre')
                    ->title('Titre')
                    ->placeholder('Entrez le nom du type d\'accompagnement')
                    ->help('Le nom du type d\'accompagnement à créer.'),
            ]))
                ->title('Créer un type d\'accompagnement')
                ->applyButton('Ajouter un type d\'accompagnement'),


            Layout::modal('editAccompagnementtypeModal', Layout::rows([
                Input::make('accompagnementtype.id')->type('hidden'),

                Input::make('accompagnementtype.titre')
                    ->title('Titre')
                    ->required(),
            ]))
                ->async('asyncAccompagnementtype')
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
        // Validate form data, save accompagnementtype to database, etc.
        $request->validate([
            'accompagnementtype.titre' => 'required|max:255',
        ]);

        $accompagnementtype = new Accompagnementtype();
        $accompagnementtype->titre = $request->input('accompagnementtype.titre');
        $accompagnementtype->save();
    }

    /**
     * @param Accompagnementtype $accompagnementtype
     *
     * @return void
     */
    public function delete(Accompagnementtype $accompagnementtype)
    {
        $accompagnementtype->delete();
    }



    public function toggleEtat(Request $request)
    {
        $accompagnementtype = Accompagnementtype::findOrFail($request->input('accompagnementtype'));
        $accompagnementtype->etat = !$accompagnementtype->etat;
        $accompagnementtype->save();
    }

    public function update(Request $request)
    {
        $request->validate([
            'accompagnementtype.titre' => 'required|max:255',
        ]);

        $accompagnementtype = Accompagnementtype::findOrFail($request->input('accompagnementtype.id'));
        $accompagnementtype->titre = $request->input('accompagnementtype.titre');
        $accompagnementtype->save();
    }

}
