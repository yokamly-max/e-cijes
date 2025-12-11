<?php

namespace App\Orchid\Screens\Contact;

use App\Models\Contact;
use App\Models\Pays;
use Orchid\Screen\Screen;
use Illuminate\Http\Request;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Alert;
use Orchid\Screen\Actions\Link;

class ListScreen extends Screen
{
    public function query(): iterable
    {
        // 1. Charger les régions locales
        $contacts = Contact::all();

        // 2. Récupérer les pays depuis Supabase
        $paysModel = new Pays();
        $payss = collect($paysModel->all()); // collection d'objets Supabase

        // 3. Associer chaque région avec son pays
        $contacts->transform(function ($contact) use ($payss) {
            $contact->pays = $payss->firstWhere('id', $contact->pays_id);
            return $contact;
        });

        return [
            'contacts' => $contacts,
        ];
    }

    public function name(): ?string
    {
        return 'Liste des contacts';
    }

    public function description(): ?string
    {
        return 'Tous les contacts enregistrés';
    }

    /**
     * Barre d'action (boutons en haut)
     */
    public function commandBar(): iterable
    {
        return [
            Link::make('Créer un contact')
                ->icon('plus')
                ->route('platform.contact.edit'),
        ];
    }

    public function layout(): iterable
    {
        return [
            Layout::view('screens.contact.list'), 
        ];
    }

    public function toggleEtat(Request $request)
    {
        $contact = Contact::findOrFail($request->input('id'));
        $contact->etat = !$contact->etat;
        $contact->save();

        Alert::info("État modifié.");
        return redirect()->back();
    }

    public function delete(Request $request)
    {
        $contact = Contact::findOrFail($request->input('contact'));
        $contact->delete();

        Alert::info("Contact supprimé.");
        return redirect()->back();
    }
}
