<?php

namespace App\Orchid\Screens\Parametres;

use Orchid\Screen\Screen;
use Orchid\Screen\Fields\Input;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Actions\ModalToggle;

use App\Models\Accompagnementniveau;
use Illuminate\Http\Request;

use Orchid\Screen\TD;
use Orchid\Screen\Actions\Button;

use Illuminate\Support\Facades\Redirect; // si tu veux rediriger après

class AccompagnementniveauScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            'accompagnementniveaus' => Accompagnementniveau::latest()->paginate(20),
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Liste des niveaux d\'accompagnements';
    }

    /**
     * Displays a description on the user's screen
     * directly under the heading.
     */
    public function description(): ?string
    {
        return "Paramètres";
    }

    public function asyncAccompagnementniveau(Accompagnementniveau $accompagnementniveau): iterable
    {
        return [
            'accompagnementniveau' => $accompagnementniveau
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
            ModalToggle::make('Ajouter un niveau d\'accompagnement')
                ->modal('accompagnementniveauModal')
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
            Layout::table('accompagnementniveaus', [
                TD::make('titre'),

                TD::make('etat', 'État')
                    ->render(function (Accompagnementniveau $accompagnementniveau) {
                        return Button::make($accompagnementniveau->etat ? 'Désactiver' : 'Activer')
                            ->method('toggleEtat', [
                                'accompagnementniveau' => $accompagnementniveau->id,
                            ])
                            ->icon($accompagnementniveau->etat ? 'toggle-on' : 'toggle-off')
                            ->class($accompagnementniveau->etat ? 'btn btn-success' : 'btn btn-secondary');
                    }),

                TD::make('Actions')
                    ->alignRight()
                    ->render(function (Accompagnementniveau $accompagnementniveau) {
                        return ModalToggle::make('Modifier')
                                ->modal('editAccompagnementniveauModal')
                                ->modalTitle('Modifier le niveau d\'accompagnement')
                                ->method('update')
                                ->asyncParameters([
                                    'accompagnementniveau' => $accompagnementniveau->id,
                                ])
                                ->icon('pencil')
                                ->class('btn btn-sm btn-warning')
                            . ' ' . 
                            Button::make('Supprimer')
                                ->confirm('Après la suppression, le niveau d\'accompagnement disparaîtra définitivement.')
                                ->method('delete', ['accompagnementniveau' => $accompagnementniveau->id])
                                ->icon('trash')
                                ->class('btn btn-sm btn-danger');
                    }),

            ]),

            Layout::modal('accompagnementniveauModal', Layout::rows([
                Input::make('accompagnementniveau.titre')
                    ->title('Titre')
                    ->placeholder('Entrez le nom du niveau d\'accompagnement')
                    ->help('Le nom du niveau d\'accompagnement à créer.'),
            ]))
                ->title('Créer un niveau d\'accompagnement')
                ->applyButton('Ajouter un niveau d\'accompagnement'),


            Layout::modal('editAccompagnementniveauModal', Layout::rows([
                Input::make('accompagnementniveau.id')->type('hidden'),

                Input::make('accompagnementniveau.titre')
                    ->title('Titre')
                    ->required(),
            ]))
                ->async('asyncAccompagnementniveau')
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
        // Validate form data, save accompagnementniveau to database, etc.
        $request->validate([
            'accompagnementniveau.titre' => 'required|max:255',
        ]);

        $accompagnementniveau = new Accompagnementniveau();
        $accompagnementniveau->titre = $request->input('accompagnementniveau.titre');
        $accompagnementniveau->save();
    }

    /**
     * @param Accompagnementniveau $accompagnementniveau
     *
     * @return void
     */
    public function delete(Accompagnementniveau $accompagnementniveau)
    {
        $accompagnementniveau->delete();
    }



    public function toggleEtat(Request $request)
    {
        $accompagnementniveau = Accompagnementniveau::findOrFail($request->input('accompagnementniveau'));
        $accompagnementniveau->etat = !$accompagnementniveau->etat;
        $accompagnementniveau->save();
    }

    public function update(Request $request)
    {
        $request->validate([
            'accompagnementniveau.titre' => 'required|max:255',
        ]);

        $accompagnementniveau = Accompagnementniveau::findOrFail($request->input('accompagnementniveau.id'));
        $accompagnementniveau->titre = $request->input('accompagnementniveau.titre');
        $accompagnementniveau->save();
    }

}
