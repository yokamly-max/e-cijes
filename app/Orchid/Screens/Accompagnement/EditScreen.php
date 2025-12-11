<?php

namespace App\Orchid\Screens\Accompagnement;

use Orchid\Screen\Screen;

use App\Models\Accompagnement;
use Illuminate\Http\Request;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\DateTimer;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Fields\Quill;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Actions\Button;
use Orchid\Support\Facades\Alert;

use App\Models\Entreprise;

use App\Services\SupabaseService;
use Illuminate\Support\Facades\Log;
use Orchid\Support\Facades\Toast;

use Illuminate\Support\Facades\Auth;

class EditScreen extends Screen
{
    /**
     * @var Accompagnement
     */
    public $accompagnement;

    /**
     * Query data.
     *
     * @param Accompagnement $accompagnement
     *
     * @return array
     */
    public function query(Accompagnement $accompagnement): array
    {
        return [
            'accompagnement' => $accompagnement
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return $this->accompagnement->exists ? 'Modification de l\'accompagnement' : 'Créer un accompagnement';
    }

    /**
     * The description is displayed on the user's screen under the heading
     */
    public function description(): ?string
    {
        return "Tous les accompagnements enregistrés";
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Button::make('Créer un accompagnement')
                ->icon('pencil')
                ->method('createOrUpdate')
                ->canSee(!$this->accompagnement->exists),

            Button::make('Modifier l\'accompagnement')
                ->icon('note')
                ->method('createOrUpdate')
                ->canSee($this->accompagnement->exists),

            Button::make('Supprimer')
                ->icon('trash')
                ->method('remove')
                ->canSee($this->accompagnement->exists),
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
            Layout::rows([
                DateTimer::make('accompagnement.dateaccompagnement')
                    ->title('Date de l\'accompagnement')
                    ->format('Y-m-d'),

                Select::make('accompagnement.membre_id')
                    ->title('Membre')
                    ->placeholder('Choisir le membre')
                    ->options(
                        \App\Models\Membre::all()
                            ->mapWithKeys(function ($membre) {
                                return [$membre->id => trim("{$membre->prenom} {$membre->nom}")];
                            })
                            ->toArray())
                    ->empty('Choisir', 0),

                Select::make('accompagnement.entreprise_id')
                    ->title('Entreprise')
                    ->placeholder('Choisir l\'entreprise')
                    ->fromModel(\App\Models\Entreprise::class, 'nom')
                    ->empty('Choisir', 0),


                Select::make('accompagnement.accompagnementniveau_id')
                    ->title('Type d\'accompagnement')
                    ->placeholder('Choisir le type')
                    ->fromModel(\App\Models\Accompagnementniveau::class, 'titre')
                    ->empty('Choisir', 0),

                Select::make('accompagnement.accompagnementstatut_id')
                    ->title('Statut d\'accompagnement')
                    ->placeholder('Choisir le statut')
                    ->fromModel(\App\Models\Accompagnementstatut::class, 'titre')
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
    $data = $request->get('accompagnement');

    $this->accompagnement->fill($data)->save();

    Alert::info('Accompagnement enregistré avec succès.');

    // ⚡ Passer le modèle Eloquent et non le tableau
    $this->afterStatutChanged($this->accompagnement);

    return redirect()->route('platform.accompagnement.list');
}

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function remove()
    {
        $this->accompagnement->delete();

        Alert::info('Vous avez supprimé l\'accompagnement avec succès.');

        return redirect()->route('platform.accompagnement.list');
    }


    protected function afterStatutChanged(Accompagnement $accompagnement)
{
    // ⚡ Vérifier le statut
    if ($accompagnement->accompagnementstatut_id != 2) {
        return;
    }

    // Charger l'entreprise liée
    $entreprise = Entreprise::find($accompagnement->entreprise_id);
    if (!$entreprise) {
        Toast::warning("Entreprise introuvable pour cet accompagnement.");
        \Log::warning("Entreprise introuvable pour accompagnement #{$accompagnement->id}");
        return;
    }

    $supabase = new \App\Services\SupabaseService();

    // Vérifier si la startup existe déjà
    try {
        $existing = $supabase->get('startups', [
            'name'   => 'eq.' . $entreprise->nom,
            'select' => 'id'
        ]);
    } catch (\Exception $e) {
        Toast::error("Impossible de vérifier l'existence de la startup : {$e->getMessage()}");
        \Log::error("Erreur Supabase get startups : " . $e->getMessage());
        return;
    }

    if (!empty($existing)) {
        Toast::warning("Cette startup existe déjà dans Supabase.");
        \Log::info("Startup déjà existante : {$entreprise->nom}");
        return;
    }

    // Vérifier country_id valide
    $countryId = $entreprise->pays_id;
    if (!$countryId) {
        Toast::error("Impossible de créer la startup : country_id manquant.");
        \Log::error("Country ID manquant pour entreprise #{$entreprise->id}");
        return;
    }

    $user = \Auth::user();

    // Données à insérer
    $startupData = [
        'name'        => $entreprise->nom,
        'user_id'     => $user->supabase_user_id,
        'description' => $entreprise->description ?? '',
        'logo_url'    => $entreprise->vignette ? env('APP_URL') . '/' . ltrim($entreprise->vignette, '/') : null,
        'phone'       => $entreprise->telephone ?? '',
        'email'       => $entreprise->email ?? '',
        'address'     => $entreprise->adresse ?? '',
        'country_id'  => $entreprise->pays_id,
        'is_formal'   => true,
        'is_validated'=> false,
        'created_at'  => now()->toIso8601String(),
        'updated_at'  => now()->toIso8601String(),
    ];

    try {
        $response = $supabase->insertWithServiceRole('startups', $startupData);
        \Log::info("Réponse Supabase insert startups : " . json_encode($response));
//dd(json_encode($response));
        // ✅ Récupérer l'ID de la startup créée depuis Supabase
        $startupId = null;
        if (!empty($response) && is_array($response)) {
            $startupId = $response[0]['id'] ?? null;
        }

        if ($startupId) {
            $entreprise->supabase_startup_id = $startupId;
            $entreprise->save();

            Toast::info("✅ Startup créée et liée à l'entreprise dans Supabase.");
            \Log::info("Startup #{$startupId} créée et liée à entreprise #{$entreprise->id}");
        } else {
            Toast::warning("Startup créée mais impossible de récupérer son ID (format inattendu). " . json_encode($response));
            \Log::warning("Réponse inattendue de Supabase : " . json_encode($response));
        }
    } catch (\Exception $e) {
        Toast::error("Erreur lors de l'insertion dans Supabase : {$e->getMessage()}");
        \Log::error("Exception création startup Supabase : " . $e->getMessage());
    }
}



}

    