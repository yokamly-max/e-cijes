<?php

namespace App\Orchid\Screens\Parametres;

use Orchid\Screen\Screen;
use Orchid\Screen\Fields\Input;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Actions\ModalToggle;

use App\Models\Slidertype;
use Illuminate\Http\Request;

use Orchid\Screen\TD;
use Orchid\Screen\Actions\Button;

use Illuminate\Support\Facades\Redirect; // si tu veux rediriger après

class SlidertypeScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            'slidertypes' => Slidertype::latest()->paginate(20),
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Liste des types de sliders';
    }

    /**
     * Displays a description on the user's screen
     * directly under the heading.
     */
    public function description(): ?string
    {
        return "Paramètres";
    }

    public function asyncSlidertype(Slidertype $slidertype): iterable
    {
        return [
            'slidertype' => $slidertype
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
            ModalToggle::make('Ajouter un type de slider')
                ->modal('slidertypeModal')
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
            Layout::table('slidertypes', [
                TD::make('titre'),

                TD::make('etat', 'État')
                    ->render(function (Slidertype $slidertype) {
                        return Button::make($slidertype->etat ? 'Désactiver' : 'Activer')
                            ->method('toggleEtat', [
                                'slidertype' => $slidertype->id,
                            ])
                            ->icon($slidertype->etat ? 'toggle-on' : 'toggle-off')
                            ->class($slidertype->etat ? 'btn btn-success' : 'btn btn-secondary');
                    }),

                TD::make('Actions')
                    ->alignRight()
                    ->render(function (Slidertype $slidertype) {
                        return ModalToggle::make('Modifier')
                                ->modal('editSlidertypeModal')
                                ->modalTitle('Modifier le type de slider')
                                ->method('update')
                                ->asyncParameters([
                                    'slidertype' => $slidertype->id,
                                ])
                                ->icon('pencil')
                                ->class('btn btn-sm btn-warning')
                            . ' ' . 
                            Button::make('Supprimer')
                                ->confirm('Après la suppression, le type de slider disparaîtra définitivement.')
                                ->method('delete', ['slidertype' => $slidertype->id])
                                ->icon('trash')
                                ->class('btn btn-sm btn-danger');
                    }),

            ]),

            Layout::modal('slidertypeModal', Layout::rows([
                Input::make('slidertype.titre')
                    ->title('Titre')
                    ->placeholder('Entrez le nom du type de slider')
                    ->help('Le nom du type de slider à créer.'),
            ]))
                ->title('Créer un type de slider')
                ->applyButton('Ajouter un type de slider'),


            Layout::modal('editSlidertypeModal', Layout::rows([
                Input::make('slidertype.id')->type('hidden'),

                Input::make('slidertype.titre')
                    ->title('Titre')
                    ->required(),
            ]))
                ->async('asyncSlidertype')
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
        // Validate form data, save slidertype to database, etc.
        $request->validate([
            'slidertype.titre' => 'required|max:255',
        ]);

        $slidertype = new Slidertype();
        $slidertype->titre = $request->input('slidertype.titre');
        $slidertype->save();
    }

    /**
     * @param Slidertype $slidertype
     *
     * @return void
     */
    public function delete(Slidertype $slidertype)
    {
        $slidertype->delete();
    }



    public function toggleEtat(Request $request)
    {
        $slidertype = Slidertype::findOrFail($request->input('slidertype'));
        $slidertype->etat = !$slidertype->etat;
        $slidertype->save();
    }

    public function update(Request $request)
    {
        $request->validate([
            'slidertype.titre' => 'required|max:255',
        ]);

        $slidertype = Slidertype::findOrFail($request->input('slidertype.id'));
        $slidertype->titre = $request->input('slidertype.titre');
        $slidertype->save();
    }

}
