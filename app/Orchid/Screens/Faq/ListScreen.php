<?php

namespace App\Orchid\Screens\Faq;

use App\Models\Faq;
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
        $faqs = Faq::all();

        // 2. Charger tous les pays depuis Supabase
        $paysModel = new Pays();
        $payss = collect($paysModel->all()); // Collection d'objets

        // 3. Charger toutes les langues depuis Supabase
        $langueModel = new Langue();
        $langues = collect($langueModel->all()); // Collection d'objets

        // 4. Associer à chaque actualité son pays et sa langue
        $faqs->transform(function ($faq) use ($payss, $langues) {
            $faq->pays = $payss->firstWhere('id', $faq->pays_id);
            $faq->langue = $langues->firstWhere('id', $faq->langue_id);
            return $faq;
        });

        return [
            'faqs' => $faqs,
        ];
    }

    public function name(): ?string
    {
        return 'Liste des questions de la FAQ';
    }

    public function description(): ?string
    {
        return 'Toutes les questions de la FAQ enregistrées';
    }

    /**
     * Barre d'action (boutons en haut)
     */
    public function commandBar(): iterable
    {
        return [
            Link::make('Créer une question')
                ->icon('plus')
                ->route('platform.faq.edit'),
        ];
    }

    public function layout(): iterable
    {
        return [
            Layout::view('screens.faq.list'), 
        ];
    }

    public function toggleEtat(Request $request)
    {
        $faq = Faq::findOrFail($request->input('id'));
        $faq->etat = !$faq->etat;
        $faq->save();

        Alert::info("État modifié.");
        return redirect()->back();
    }

    public function toggleSpotlight(Request $request)
    {
        $faq = Faq::findOrFail($request->input('id'));
        $faq->spotlight = !$faq->spotlight;
        $faq->save();

        Alert::info("Spotlight modifié.");
        return redirect()->back();
    }

    public function delete(Request $request)
    {
        $faq = Faq::findOrFail($request->input('faq'));
        $faq->delete();

        Alert::info("Question supprimée.");
        return redirect()->back();
    }
}
