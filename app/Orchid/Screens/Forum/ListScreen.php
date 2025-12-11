<?php

namespace App\Orchid\Screens\Forum;

use App\Models\Forum;
use App\Models\Pays;
use App\Models\Langue;

use Orchid\Screen\Screen;
use Illuminate\Http\Request;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Alert;
use Orchid\Screen\Actions\Link;

class ListScreen extends Screen
{
    public function query(): iterable
    {
        // 1. Charger toutes les actualités locales
        $forums = Forum::all();

        // 2. Charger tous les pays depuis Supabase
        $paysModel = new Pays();
        $payss = collect($paysModel->all()); // Collection d'objets

        // 3. Charger toutes les langues depuis Supabase
        $langueModel = new Langue();
        $langues = collect($langueModel->all()); // Collection d'objets

        // 4. Associer à chaque actualité son pays et sa langue
        $forums->transform(function ($forum) use ($payss, $langues) {
            $forum->pays = $payss->firstWhere('id', $forum->pays_id);
            $forum->langue = $langues->firstWhere('id', $forum->langue_id);
            return $forum;
        });

        return [
            'forums' => $forums,
        ];
    }

    public function name(): ?string
    {
        return 'Liste des forums';
    }

    public function description(): ?string
    {
        return 'Tous les forums enregistrés';
    }

    /**
     * Barre d'action (boutons en haut)
     */
    public function commandBar(): iterable
    {
        return [
            Link::make('Créer un forum')
                ->icon('plus')
                ->route('platform.forum.edit'),
        ];
    }

    public function layout(): iterable
    {
        return [
            Layout::view('screens.forum.list'), 
        ];
    }

    public function toggleEtat(Request $request)
    {
        $forum = Forum::findOrFail($request->input('id'));
        $forum->etat = !$forum->etat;
        $forum->save();

        Alert::info("État modifié.");
        return redirect()->back();
    }

    public function toggleSpotlight(Request $request)
    {
        $forum = Forum::findOrFail($request->input('id'));
        $forum->spotlight = !$forum->spotlight;
        $forum->save();

        Alert::info("Spotlight modifié.");
        return redirect()->back();
    }

    public function delete(Request $request)
    {
        $forum = Forum::findOrFail($request->input('forum'));
        $forum->delete();

        Alert::info("Forum supprimé.");
        return redirect()->back();
    }
}
