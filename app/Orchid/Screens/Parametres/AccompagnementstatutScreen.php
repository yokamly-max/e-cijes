<?php

namespace App\Orchid\Screens\Parametres;

use Orchid\Screen\Screen;
use Orchid\Screen\Fields\Input;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Actions\ModalToggle;

use App\Models\Accompagnementstatut;
use Illuminate\Http\Request;

use Orchid\Screen\TD;
use Orchid\Screen\Actions\Button;

use Illuminate\Support\Facades\Redirect; // si tu veux rediriger après

class AccompagnementstatutScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            'accompagnementstatuts' => Accompagnementstatut::latest()->paginate(20),
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Liste des statuts d\'accompagnements';
    }

    /**
     * Displays a description on the user's screen
     * directly under the heading.
     */
    public function description(): ?string
    {
        return "Paramètres";
    }

    public function asyncAccompagnementstatut(Accompagnementstatut $accompagnementstatut): iterable
    {
        return [
            'accompagnementstatut' => $accompagnementstatut
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
            ModalToggle::make('Ajouter un statut d\'accompagnement')
                ->modal('accompagnementstatutModal')
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
            Layout::table('accompagnementstatuts', [
                TD::make('titre'),

                TD::make('etat', 'État')
                    ->render(function (Accompagnementstatut $accompagnementstatut) {
                        return Button::make($accompagnementstatut->etat ? 'Désactiver' : 'Activer')
                            ->method('toggleEtat', [
                                'accompagnementstatut' => $accompagnementstatut->id,
                            ])
                            ->icon($accompagnementstatut->etat ? 'toggle-on' : 'toggle-off')
                            ->class($accompagnementstatut->etat ? 'btn btn-success' : 'btn btn-secondary');
                    }),

                TD::make('Actions')
                    ->alignRight()
                    ->render(function (Accompagnementstatut $accompagnementstatut) {
                        return ModalToggle::make('Modifier')
                                ->modal('editAccompagnementstatutModal')
                                ->modalTitle('Modifier le statut d\'accompagnement')
                                ->method('update')
                                ->asyncParameters([
                                    'accompagnementstatut' => $accompagnementstatut->id,
                                ])
                                ->icon('pencil')
                                ->class('btn btn-sm btn-warning')
                            . ' ' . 
                            Button::make('Supprimer')
                                ->confirm('Après la suppression, le statut d\'accompagnement disparaîtra définitivement.')
                                ->method('delete', ['accompagnementstatut' => $accompagnementstatut->id])
                                ->icon('trash')
                                ->class('btn btn-sm btn-danger');
                    }),

            ]),

            Layout::modal('accompagnementstatutModal', Layout::rows([
                Input::make('accompagnementstatut.titre')
                    ->title('Titre')
                    ->placeholder('Entrez le nom du statut d\'accompagnement')
                    ->help('Le nom du statut d\'accompagnement à créer.'),
            ]))
                ->title('Créer un statut d\'accompagnement')
                ->applyButton('Ajouter un statut d\'accompagnement'),


            Layout::modal('editAccompagnementstatutModal', Layout::rows([
                Input::make('accompagnementstatut.id')->type('hidden'),

                Input::make('accompagnementstatut.titre')
                    ->title('Titre')
                    ->required(),
            ]))
                ->async('asyncAccompagnementstatut')
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
        // Validate form data, save accompagnementstatut to database, etc.
        $request->validate([
            'accompagnementstatut.titre' => 'required|max:255',
        ]);

        $accompagnementstatut = new Accompagnementstatut();
        $accompagnementstatut->titre = $request->input('accompagnementstatut.titre');
        $accompagnementstatut->save();
    }

    /**
     * @param Accompagnementstatut $accompagnementstatut
     *
     * @return void
     */
    public function delete(Accompagnementstatut $accompagnementstatut)
    {
        $accompagnementstatut->delete();
    }



    public function toggleEtat(Request $request)
    {
        $accompagnementstatut = Accompagnementstatut::findOrFail($request->input('accompagnementstatut'));
        $accompagnementstatut->etat = !$accompagnementstatut->etat;
        $accompagnementstatut->save();
    }

    public function update(Request $request)
    {
        $request->validate([
            'accompagnementstatut.titre' => 'required|max:255',
        ]);

        $accompagnementstatut = Accompagnementstatut::findOrFail($request->input('accompagnementstatut.id'));
        $accompagnementstatut->titre = $request->input('accompagnementstatut.titre');
        $accompagnementstatut->save();
    }

}
