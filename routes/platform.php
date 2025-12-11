<?php

declare(strict_types=1);

use App\Orchid\Screens\Examples\ExampleActionsScreen;
use App\Orchid\Screens\Examples\ExampleCardsScreen;
use App\Orchid\Screens\Examples\ExampleChartsScreen;
use App\Orchid\Screens\Examples\ExampleFieldsAdvancedScreen;
use App\Orchid\Screens\Examples\ExampleFieldsScreen;
use App\Orchid\Screens\Examples\ExampleGridScreen;
use App\Orchid\Screens\Examples\ExampleLayoutsScreen;
use App\Orchid\Screens\Examples\ExampleScreen;
use App\Orchid\Screens\Examples\ExampleTextEditorsScreen;
use App\Orchid\Screens\PlatformScreen;
use App\Orchid\Screens\Role\RoleEditScreen;
use App\Orchid\Screens\Role\RoleListScreen;
use App\Orchid\Screens\User\UserEditScreen;
use App\Orchid\Screens\User\UserListScreen;
use App\Orchid\Screens\User\UserProfileScreen;
use Illuminate\Support\Facades\Route;
use Tabuna\Breadcrumbs\Trail;

use App\Orchid\Screens\Parametres\MembrestatutScreen;
use App\Orchid\Screens\Parametres\AccompagnementstatutScreen;
use App\Orchid\Screens\Parametres\PrestationrealiseestatutScreen;
use App\Orchid\Screens\Parametres\PaiementstatutScreen;
use App\Orchid\Screens\Parametres\SuivistatutScreen;
use App\Orchid\Screens\Parametres\CreditstatutScreen;
use App\Orchid\Screens\Parametres\BonstatutScreen;
use App\Orchid\Screens\Parametres\ReservationstatutScreen;
use App\Orchid\Screens\Parametres\ParticipantstatutScreen;
use App\Orchid\Screens\Parametres\DossierstatutScreen;
use App\Orchid\Screens\Parametres\EntreprisetypeScreen;
use App\Orchid\Screens\Parametres\PrestationtypeScreen;
use App\Orchid\Screens\Parametres\PiecetypeScreen;
use App\Orchid\Screens\Parametres\SuivitypeScreen;
use App\Orchid\Screens\Parametres\VeilletypeScreen;
use App\Orchid\Screens\Parametres\BontypeScreen;
use App\Orchid\Screens\Parametres\ForumtypeScreen;
use App\Orchid\Screens\Parametres\DocumenttypeScreen;
use App\Orchid\Screens\Parametres\EspacetypeScreen;
use App\Orchid\Screens\Parametres\RecommandationtypeScreen;
use App\Orchid\Screens\Parametres\RessourcetypeScreen;
use App\Orchid\Screens\Parametres\OperationtypeScreen;
use App\Orchid\Screens\Parametres\OffretypeScreen;
use App\Orchid\Screens\Parametres\PartenairetypeScreen;
use App\Orchid\Screens\Parametres\PartenaireactivitetypeScreen;
use App\Orchid\Screens\Parametres\AlertetypeScreen;
use App\Orchid\Screens\Parametres\SecteurScreen;
use App\Orchid\Screens\Parametres\AccompagnementniveauScreen;
use App\Orchid\Screens\Parametres\ExperttypeScreen;
use App\Orchid\Screens\Parametres\ExpertvalideScreen;
use App\Orchid\Screens\Parametres\RecommandationorigineScreen;
use App\Orchid\Screens\Parametres\FormationniveauScreen;
use App\Orchid\Screens\Parametres\FormationtypeScreen;
use App\Orchid\Screens\Parametres\NewslettertypeScreen;
//use App\Orchid\Screens\Parametres\LangueScreen;
use App\Orchid\Screens\Parametres\ActualitetypeScreen;
use App\Orchid\Screens\Parametres\EvenementinscriptiontypeScreen;
use App\Orchid\Screens\Parametres\SlidertypeScreen;
use App\Orchid\Screens\Parametres\ContacttypeScreen;
use App\Orchid\Screens\Parametres\MembretypeScreen;
use App\Orchid\Screens\Parametres\JourScreen;
use App\Orchid\Screens\Parametres\CredittypeScreen;
use App\Orchid\Screens\Parametres\EcheancierstatutScreen;
use App\Orchid\Screens\Parametres\DiagnostictypeScreen;
use App\Orchid\Screens\Parametres\DiagnosticstatutScreen;
use App\Orchid\Screens\Parametres\DiagnosticquestiontypeScreen;
use App\Orchid\Screens\Parametres\DiagnosticquestioncategorieScreen;
use App\Orchid\Screens\Parametres\EvenementtypeScreen;
use App\Orchid\Screens\Parametres\ConseillertypeScreen;
use App\Orchid\Screens\Parametres\ConseillervalideScreen;
use App\Orchid\Screens\Parametres\AccompagnementtypeScreen;
use App\Orchid\Screens\Parametres\DiagnosticmoduletypeScreen;
use App\Orchid\Screens\Parametres\QuizquestiontypeScreen;
use App\Orchid\Screens\Parametres\QuizresultatstatutScreen;

use App\Models\Langue;
use App\Models\Pays;
use App\Models\Region;
use App\Models\Prefecture;
use App\Models\Commune;
use App\Models\Quartier;
use App\Models\Pagelibre;
use App\Models\Actualite;
use App\Models\Evenement;
use App\Models\Partenaire;
use App\Models\Slider;
use App\Models\Service;
use App\Models\Chiffre;
use App\Models\Temoignage;
use App\Models\Contact;
use App\Models\Commentaire;
use App\Models\Faq;
use App\Models\Membre;
use App\Models\Entreprise;
use App\Models\Notification;
use App\Models\Alerte;
use App\Models\Bon;
use App\Models\Prestation;
use App\Models\Formation;
use App\Models\Entreprisemembre;
use App\Models\Accompagnement;
use App\Models\Evenementinscription;
use App\Models\Participant;
use App\Models\Suivi;
use App\Models\Prestationrealisee;
use App\Models\Bonutilise;
use App\Models\Plan;
use App\Models\Document;
use App\Models\Piece;
use App\Models\Accompagnementdocument;
use App\Models\Expert;
use App\Models\Disponibilite;
use App\Models\Evaluation;
use App\Models\Forum;
use App\Models\Sujet;
use App\Models\Messageforum;
use App\Models\Conversation;
use App\Models\Message;
use App\Models\Espace;
use App\Models\Reservation;
use App\Models\Credit;
use App\Models\Echeancier;
use App\Models\Diagnostic;
use App\Models\Diagnosticmodule;
use App\Models\Diagnosticquestion;
use App\Models\Diagnosticreponse;
use App\Models\Diagnosticresultat;
use App\Models\Conseiller;
use App\Models\Conseillerentreprise;
use App\Models\Conseillerprescription;
use App\Models\Accompagnementconseiller;
use App\Models\Ressourcecompte;
use App\Models\Ressourcetransaction;
use App\Models\Parrainage;
use App\Models\Conversion;
use App\Models\Prestationressource;
use App\Models\Formationressource;
use App\Models\Espaceressource;
use App\Models\Evenementressource;
use App\Models\Ressourcetypeoffretype;
use App\Models\Newsletter;
use App\Models\Quiz;
use App\Models\Quizquestion;
use App\Models\Quizreponse;
use App\Models\Quizmembre;
use App\Models\Quizresultat;
use App\Models\Action;
use App\Models\Recompense;

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Dashboard Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the need "dashboard" middleware group. Now create something great!
|
*/

// Main
Route::screen('/main', PlatformScreen::class)
    ->name('platform.main');

// Platform > Profile
Route::screen('profile', UserProfileScreen::class)
    ->name('platform.profile')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.index')
        ->push(__('Profile'), route('platform.profile')));

// Platform > System > Users > User
Route::screen('users/{user}/edit', UserEditScreen::class)
    ->name('platform.systems.users.edit')
    ->breadcrumbs(fn (Trail $trail, $user) => $trail
        ->parent('platform.systems.users')
        ->push($user->name, route('platform.systems.users.edit', $user)));

// Platform > System > Users > Create
Route::screen('users/create', UserEditScreen::class)
    ->name('platform.systems.users.create')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.systems.users')
        ->push(__('Create'), route('platform.systems.users.create')));

// Platform > System > Users
Route::screen('users', UserListScreen::class)
    ->name('platform.systems.users')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.index')
        ->push(__('Users'), route('platform.systems.users')));

// Platform > System > Roles > Role
Route::screen('roles/{role}/edit', RoleEditScreen::class)
    ->name('platform.systems.roles.edit')
    ->breadcrumbs(fn (Trail $trail, $role) => $trail
        ->parent('platform.systems.roles')
        ->push($role->name, route('platform.systems.roles.edit', $role)));

// Platform > System > Roles > Create
Route::screen('roles/create', RoleEditScreen::class)
    ->name('platform.systems.roles.create')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.systems.roles')
        ->push(__('Create'), route('platform.systems.roles.create')));

// Platform > System > Roles
Route::screen('roles', RoleListScreen::class)
    ->name('platform.systems.roles')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.index')
        ->push(__('Roles'), route('platform.systems.roles')));

// Example...
Route::screen('example', ExampleScreen::class)
    ->name('platform.example')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.index')
        ->push('Example Screen'));

Route::screen('/examples/form/fields', ExampleFieldsScreen::class)->name('platform.example.fields');
Route::screen('/examples/form/advanced', ExampleFieldsAdvancedScreen::class)->name('platform.example.advanced');
Route::screen('/examples/form/editors', ExampleTextEditorsScreen::class)->name('platform.example.editors');
Route::screen('/examples/form/actions', ExampleActionsScreen::class)->name('platform.example.actions');

Route::screen('/examples/layouts', ExampleLayoutsScreen::class)->name('platform.example.layouts');
Route::screen('/examples/grid', ExampleGridScreen::class)->name('platform.example.grid');
Route::screen('/examples/charts', ExampleChartsScreen::class)->name('platform.example.charts');
Route::screen('/examples/cards', ExampleCardsScreen::class)->name('platform.example.cards');

// Route::screen('idea', Idea::class, 'platform.screens.idea');


Route::screen('membrestatut', MembrestatutScreen::class)
    ->name('platform.membrestatut')
    ->breadcrumbs(function (Trail $trail){
        return $trail
            ->parent('platform.index')
            ->push('Statuts de membres');
    });

Route::screen('accompagnementstatut', AccompagnementstatutScreen::class)
    ->name('platform.accompagnementstatut')
    ->breadcrumbs(function (Trail $trail){
        return $trail
            ->parent('platform.index')
            ->push('Statuts d\'accompagnements');
    });

Route::screen('prestationrealiseestatut', PrestationrealiseestatutScreen::class)
    ->name('platform.prestationrealiseestatut')
    ->breadcrumbs(function (Trail $trail){
        return $trail
            ->parent('platform.index')
            ->push('Statuts de la prestation realisée');
    });

Route::screen('paiementstatut', PaiementstatutScreen::class)
    ->name('platform.paiementstatut')
    ->breadcrumbs(function (Trail $trail){
        return $trail
            ->parent('platform.index')
            ->push('Statuts du paiement');
    });

Route::screen('suivistatut', SuivistatutScreen::class)
    ->name('platform.suivistatut')
    ->breadcrumbs(function (Trail $trail){
        return $trail
            ->parent('platform.index')
            ->push('Statuts de suivis');
    });

Route::screen('creditstatut', CreditstatutScreen::class)
    ->name('platform.creditstatut')
    ->breadcrumbs(function (Trail $trail){
        return $trail
            ->parent('platform.index')
            ->push('Statuts de crédits');
    });

Route::screen('bonstatut', BonstatutScreen::class)
    ->name('platform.bonstatut')
    ->breadcrumbs(function (Trail $trail){
        return $trail
            ->parent('platform.index')
            ->push('Statuts de bons');
    });

Route::screen('reservationstatut', ReservationstatutScreen::class)
    ->name('platform.reservationstatut')
    ->breadcrumbs(function (Trail $trail){
        return $trail
            ->parent('platform.index')
            ->push('Statuts de la réservation');
    });

Route::screen('participantstatut', ParticipantstatutScreen::class)
    ->name('platform.participantstatut')
    ->breadcrumbs(function (Trail $trail){
        return $trail
            ->parent('platform.index')
            ->push('Statuts des participants');
    });

Route::screen('dossierstatut', DossierstatutScreen::class)
    ->name('platform.dossierstatut')
    ->breadcrumbs(function (Trail $trail){
        return $trail
            ->parent('platform.index')
            ->push('Statuts des dossiers');
    });

Route::screen('echeancierstatut', EcheancierstatutScreen::class)
    ->name('platform.echeancierstatut')
    ->breadcrumbs(function (Trail $trail){
        return $trail
            ->parent('platform.index')
            ->push('Statuts d\'échéanciers');
    });

Route::screen('entreprisetype', EntreprisetypeScreen::class)
    ->name('platform.entreprisetype')
    ->breadcrumbs(function (Trail $trail){
        return $trail
            ->parent('platform.index')
            ->push('Types d\'entreprises');
    });

Route::screen('prestationtype', PrestationtypeScreen::class)
    ->name('platform.prestationtype')
    ->breadcrumbs(function (Trail $trail){
        return $trail
            ->parent('platform.index')
            ->push('Types de prestations');
    });

Route::screen('piecetype', PiecetypeScreen::class)
    ->name('platform.piecetype')
    ->breadcrumbs(function (Trail $trail){
        return $trail
            ->parent('platform.index')
            ->push('Types de pieces');
    });

Route::screen('suivitype', SuivitypeScreen::class)
    ->name('platform.suivitype')
    ->breadcrumbs(function (Trail $trail){
        return $trail
            ->parent('platform.index')
            ->push('Types de suivis');
    });

Route::screen('veilletype', VeilletypeScreen::class)
    ->name('platform.veilletype')
    ->breadcrumbs(function (Trail $trail){
        return $trail
            ->parent('platform.index')
            ->push('Types de veilles');
    });

Route::screen('bontype', BontypeScreen::class)
    ->name('platform.bontype')
    ->breadcrumbs(function (Trail $trail){
        return $trail
            ->parent('platform.index')
            ->push('Types de bons');
    });

Route::screen('jour', JourScreen::class)
    ->name('platform.jour')
    ->breadcrumbs(function (Trail $trail){
        return $trail
            ->parent('platform.index')
            ->push('Jours');
    });

Route::screen('membretype', MembretypeScreen::class)
    ->name('platform.membretype')
    ->breadcrumbs(function (Trail $trail){
        return $trail
            ->parent('platform.index')
            ->push('Types de membres');
    });

Route::screen('forumtype', ForumtypeScreen::class)
    ->name('platform.forumtype')
    ->breadcrumbs(function (Trail $trail){
        return $trail
            ->parent('platform.index')
            ->push('Types de forums');
    });

Route::screen('documenttype', DocumenttypeScreen::class)
    ->name('platform.documenttype')
    ->breadcrumbs(function (Trail $trail){
        return $trail
            ->parent('platform.index')
            ->push('Types de documents');
    });

Route::screen('espacetype', EspacetypeScreen::class)
    ->name('platform.espacetype')
    ->breadcrumbs(function (Trail $trail){
        return $trail
            ->parent('platform.index')
            ->push('Types d\'espaces');
    });

Route::screen('recommandationtype', RecommandationtypeScreen::class)
    ->name('platform.recommandationtype')
    ->breadcrumbs(function (Trail $trail){
        return $trail
            ->parent('platform.index')
            ->push('Types de recommandations');
    });

Route::screen('ressourcetype', RessourcetypeScreen::class)
    ->name('platform.ressourcetype')
    ->breadcrumbs(function (Trail $trail){
        return $trail
            ->parent('platform.index')
            ->push('Types de ressources');
    });

Route::screen('operationtype', OperationtypeScreen::class)
    ->name('platform.operationtype')
    ->breadcrumbs(function (Trail $trail){
        return $trail
            ->parent('platform.index')
            ->push('Types de operations');
    });

Route::screen('offretype', OffretypeScreen::class)
    ->name('platform.offretype')
    ->breadcrumbs(function (Trail $trail){
        return $trail
            ->parent('platform.index')
            ->push('Types de offres');
    });

Route::screen('partenairetype', PartenairetypeScreen::class)
    ->name('platform.partenairetype')
    ->breadcrumbs(function (Trail $trail){
        return $trail
            ->parent('platform.index')
            ->push('Types de partenaires');
    });

Route::screen('partenaireactivitetype', PartenaireactivitetypeScreen::class)
    ->name('platform.partenaireactivitetype')
    ->breadcrumbs(function (Trail $trail){
        return $trail
            ->parent('platform.index')
            ->push('Types d\'activités des partenaires');
    });

Route::screen('alertetype', AlertetypeScreen::class)
    ->name('platform.alertetype')
    ->breadcrumbs(function (Trail $trail){
        return $trail
            ->parent('platform.index')
            ->push('Types d\'alertes');
    });

Route::screen('secteur', SecteurScreen::class)
    ->name('platform.secteur')
    ->breadcrumbs(function (Trail $trail){
        return $trail
            ->parent('platform.index')
            ->push('Secteurs');
    });

Route::screen('accompagnementniveau', AccompagnementniveauScreen::class)
    ->name('platform.accompagnementniveau')
    ->breadcrumbs(function (Trail $trail){
        return $trail
            ->parent('platform.index')
            ->push('Niveaux d\'accompagnements');
    });

Route::screen('experttype', ExperttypeScreen::class)
    ->name('platform.experttype')
    ->breadcrumbs(function (Trail $trail){
        return $trail
            ->parent('platform.index')
            ->push('Types d\'experts');
    });

Route::screen('expertvalide', ExpertvalideScreen::class)
    ->name('platform.expertvalide')
    ->breadcrumbs(function (Trail $trail){
        return $trail
            ->parent('platform.index')
            ->push('Validation d\'experts');
    });

Route::screen('conseillertype', ConseillertypeScreen::class)
    ->name('platform.conseillertype')
    ->breadcrumbs(function (Trail $trail){
        return $trail
            ->parent('platform.index')
            ->push('Types de conseillers');
    });

Route::screen('conseillervalide', ConseillervalideScreen::class)
    ->name('platform.conseillervalide')
    ->breadcrumbs(function (Trail $trail){
        return $trail
            ->parent('platform.index')
            ->push('Validation de conseillers');
    });

Route::screen('recommandationorigine', RecommandationorigineScreen::class)
    ->name('platform.recommandationorigine')
    ->breadcrumbs(function (Trail $trail){
        return $trail
            ->parent('platform.index')
            ->push('Origines des recommandations');
    });

Route::screen('formationniveau', FormationniveauScreen::class)
    ->name('platform.formationniveau')
    ->breadcrumbs(function (Trail $trail){
        return $trail
            ->parent('platform.index')
            ->push('Niveaux des formations');
    });

Route::screen('formationtype', FormationtypeScreen::class)
    ->name('platform.formationtype')
    ->breadcrumbs(function (Trail $trail){
        return $trail
            ->parent('platform.index')
            ->push('Type des formations');
    });

Route::screen('newslettertype', NewslettertypeScreen::class)
    ->name('platform.newslettertype')
    ->breadcrumbs(function (Trail $trail){
        return $trail
            ->parent('platform.index')
            ->push('Type des newsletters');
    });

/*Route::screen('langue', LangueScreen::class)
    ->name('platform.langue.list')
    ->breadcrumbs(function (Trail $trail){
        return $trail
            ->parent('platform.index')
            ->push('Langues');
    });*/

Route::screen('actualitetype', ActualitetypeScreen::class)
    ->name('platform.actualitetype')
    ->breadcrumbs(function (Trail $trail){
        return $trail
            ->parent('platform.index')
            ->push('Types d\'actualités');
    });

Route::screen('evenementinscriptiontype', EvenementinscriptiontypeScreen::class)
    ->name('platform.evenementinscriptiontype')
    ->breadcrumbs(function (Trail $trail){
        return $trail
            ->parent('platform.index')
            ->push('Types d\'inscription à un évènement');
    });

Route::screen('evenementtype', EvenementtypeScreen::class)
    ->name('platform.evenementtype')
    ->breadcrumbs(function (Trail $trail){
        return $trail
            ->parent('platform.index')
            ->push('Types d\'évènements');
    });

Route::screen('slidertype', SlidertypeScreen::class)
    ->name('platform.slidertype')
    ->breadcrumbs(function (Trail $trail){
        return $trail
            ->parent('platform.index')
            ->push('Types de sliders');
    });

Route::screen('contacttype', ContacttypeScreen::class)
    ->name('platform.contacttype')
    ->breadcrumbs(function (Trail $trail){
        return $trail
            ->parent('platform.index')
            ->push('Types de contacts');
    });

Route::screen('credittype', CredittypeScreen::class)
    ->name('platform.credittype')
    ->breadcrumbs(function (Trail $trail){
        return $trail
            ->parent('platform.index')
            ->push('Types de credits');
    });

Route::screen('diagnostictype', DiagnostictypeScreen::class)
    ->name('platform.diagnostictype')
    ->breadcrumbs(function (Trail $trail){
        return $trail
            ->parent('platform.index')
            ->push('Profil émotionnel');
    });

Route::screen('diagnosticstatut', DiagnosticstatutScreen::class)
    ->name('platform.diagnosticstatut')
    ->breadcrumbs(function (Trail $trail){
        return $trail
            ->parent('platform.index')
            ->push('Statuts des diagnostics');
    });

Route::screen('diagnosticquestiontype', DiagnosticquestiontypeScreen::class)
    ->name('platform.diagnosticquestiontype')
    ->breadcrumbs(function (Trail $trail){
        return $trail
            ->parent('platform.index')
            ->push('Types des questions du diagnostic');
    });

Route::screen('diagnosticmoduletype', DiagnosticmoduletypeScreen::class)
    ->name('platform.diagnosticmoduletype')
    ->breadcrumbs(function (Trail $trail){
        return $trail
            ->parent('platform.index')
            ->push('Types des modules du diagnostic');
    });

Route::screen('quizquestiontype', QuizquestiontypeScreen::class)
    ->name('platform.quizquestiontype')
    ->breadcrumbs(function (Trail $trail){
        return $trail
            ->parent('platform.index')
            ->push('Types des questions du quiz');
    });

Route::screen('quizresultatstatut', QuizresultatstatutScreen::class)
    ->name('platform.quizresultatstatut')
    ->breadcrumbs(function (Trail $trail){
        return $trail
            ->parent('platform.index')
            ->push('Statuts des resultats du quiz');
    });

Route::screen('diagnosticquestioncategorie', DiagnosticquestioncategorieScreen::class)
    ->name('platform.diagnosticquestioncategorie')
    ->breadcrumbs(function (Trail $trail){
        return $trail
            ->parent('platform.index')
            ->push('Categories des questions du diagnostic');
    });

Route::screen('accompagnementtype', AccompagnementtypeScreen::class)
    ->name('platform.accompagnementtype')
    ->breadcrumbs(function (Trail $trail){
        return $trail
            ->parent('platform.index')
            ->push('Types d\'accompagnements');
    });

//langue//////////////////////
Route::screen('langue/{langue?}', App\Orchid\Screens\Langue\EditScreen::class)->name('platform.langue.edit')
    ->breadcrumbs(function (Trail $trail, $langue = null) {
        $trail->parent('platform.langue.list');
        if ($langue && $langue->exists) {
            $trail->push('Modifier la langue', route('platform.langue.edit', $langue));
        } else {
            $trail->push('Créer une nouvelle langue', route('platform.langue.edit'));
        }
    });
Route::screen('langues', App\Orchid\Screens\Langue\ListScreen::class)->name('platform.langue.list')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.index')
        ->push('Langue', route('platform.langue.list')));
Route::screen('langues/{langue}/show', App\Orchid\Screens\Langue\ShowScreen::class)->name('platform.langue.show')
    ->breadcrumbs(function (Trail $trail, $langue) {
        return $trail
            ->parent('platform.langue.list') 
            ->push('Détail de la langue');
    });
Route::post('langues/toggleEtat', [App\Orchid\Screens\Langue\ListScreen::class, 'toggleEtat'])->name('platform.langue.toggleEtat');
Route::post('langues/delete', [App\Orchid\Screens\Langue\ListScreen::class, 'delete'])->name('platform.langue.delete');

//pays//////////////////////
Route::screen('pays/{pays?}', App\Orchid\Screens\Pays\EditScreen::class)->name('platform.pays.edit')
    ->breadcrumbs(function (Trail $trail, $pays = null) {
        $trail->parent('platform.pays.list');
        if ($pays && $pays->exists) {
            $trail->push('Modifier le pays', route('platform.pays.edit', $pays));
        } else {
            $trail->push('Créer un nouveau pays', route('platform.pays.edit'));
        }
    });
Route::screen('payss', App\Orchid\Screens\Pays\ListScreen::class)->name('platform.pays.list')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.index')
        ->push('Pays', route('platform.pays.list')));
Route::screen('payss/{pays}/show', App\Orchid\Screens\Pays\ShowScreen::class)->name('platform.pays.show')
    ->breadcrumbs(function (Trail $trail, $pays) {
        return $trail
            ->parent('platform.pays.list') 
            ->push('Détail du pays');
    });
Route::post('payss/toggleEtat', [App\Orchid\Screens\Pays\ListScreen::class, 'toggleEtat'])->name('platform.pays.toggleEtat');
Route::post('payss/delete', [App\Orchid\Screens\Pays\ListScreen::class, 'delete'])->name('platform.pays.delete');

//region//////////////////////
Route::screen('region/{region?}', App\Orchid\Screens\Region\EditScreen::class)->name('platform.region.edit')
    ->breadcrumbs(function (Trail $trail, $region = null) {
        $trail->parent('platform.region.list');
        if ($region && $region->exists) {
            $trail->push('Modifier la région', route('platform.region.edit', $region));
        } else {
            $trail->push('Créer une nouvelle région', route('platform.region.edit'));
        }
    });
Route::screen('regions', App\Orchid\Screens\Region\ListScreen::class)->name('platform.region.list')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.index')
        ->push('Région', route('platform.region.list')));
Route::screen('regions/{region}/show', App\Orchid\Screens\Region\ShowScreen::class)->name('platform.region.show')
    ->breadcrumbs(function (Trail $trail, $region) {
        return $trail
            ->parent('platform.region.list') 
            ->push('Détail de la région');
    });
Route::post('regions/toggleEtat', [App\Orchid\Screens\Region\ListScreen::class, 'toggleEtat'])->name('platform.region.toggleEtat');
Route::post('regions/delete', [App\Orchid\Screens\Region\ListScreen::class, 'delete'])->name('platform.region.delete');

//prefecture//////////////////////
Route::screen('prefecture/{prefecture?}', App\Orchid\Screens\Prefecture\EditScreen::class)->name('platform.prefecture.edit')
    ->breadcrumbs(function (Trail $trail, $prefecture = null) {
        $trail->parent('platform.prefecture.list');
        if ($prefecture && $prefecture->exists) {
            $trail->push('Modifier la préfecture', route('platform.prefecture.edit', $prefecture));
        } else {
            $trail->push('Créer une nouvelle préfecture', route('platform.prefecture.edit'));
        }
    });
Route::screen('prefectures', App\Orchid\Screens\Prefecture\ListScreen::class)->name('platform.prefecture.list')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.index')
        ->push('Préfecture', route('platform.prefecture.list')));
Route::screen('prefectures/{prefecture}/show', App\Orchid\Screens\Prefecture\ShowScreen::class)->name('platform.prefecture.show')
    ->breadcrumbs(function (Trail $trail, $prefecture) {
        return $trail
            ->parent('platform.prefecture.list') 
            ->push('Détail de la préfecture');
    });
Route::post('prefectures/toggleEtat', [App\Orchid\Screens\Prefecture\ListScreen::class, 'toggleEtat'])->name('platform.prefecture.toggleEtat');
Route::post('prefectures/delete', [App\Orchid\Screens\Prefecture\ListScreen::class, 'delete'])->name('platform.prefecture.delete');

//commune//////////////////////
Route::screen('commune/{commune?}', App\Orchid\Screens\Commune\EditScreen::class)->name('platform.commune.edit')
    ->breadcrumbs(function (Trail $trail, $commune = null) {
        $trail->parent('platform.commune.list');
        if ($commune && $commune->exists) {
            $trail->push('Modifier la commune', route('platform.commune.edit', $commune));
        } else {
            $trail->push('Créer une nouvelle commune', route('platform.commune.edit'));
        }
    });
Route::screen('communes', App\Orchid\Screens\Commune\ListScreen::class)->name('platform.commune.list')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.index')
        ->push('Commune', route('platform.commune.list')));
Route::screen('communes/{commune}/show', App\Orchid\Screens\Commune\ShowScreen::class)->name('platform.commune.show')
    ->breadcrumbs(function (Trail $trail, $commune) {
        return $trail
            ->parent('platform.commune.list') 
            ->push('Détail de la commune');
    });
Route::post('communes/toggleEtat', [App\Orchid\Screens\Commune\ListScreen::class, 'toggleEtat'])->name('platform.commune.toggleEtat');
Route::post('communes/delete', [App\Orchid\Screens\Commune\ListScreen::class, 'delete'])->name('platform.commune.delete');

//quartier//////////////////////
Route::screen('quartier/{quartier?}', App\Orchid\Screens\Quartier\EditScreen::class)->name('platform.quartier.edit')
    ->breadcrumbs(function (Trail $trail, $quartier = null) {
        $trail->parent('platform.quartier.list');
        if ($quartier && $quartier->exists) {
            $trail->push('Modifier le quartier', route('platform.quartier.edit', $quartier));
        } else {
            $trail->push('Créer un nouveau quartier', route('platform.quartier.edit'));
        }
    });
Route::screen('quartiers', App\Orchid\Screens\Quartier\ListScreen::class)->name('platform.quartier.list')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.index')
        ->push('Quartier', route('platform.quartier.list')));
Route::screen('quartiers/{quartier}/show', App\Orchid\Screens\Quartier\ShowScreen::class)->name('platform.quartier.show')
    ->breadcrumbs(function (Trail $trail, $quartier) {
        return $trail
            ->parent('platform.quartier.list') 
            ->push('Détail du quartier');
    });
Route::post('quartiers/toggleEtat', [App\Orchid\Screens\Quartier\ListScreen::class, 'toggleEtat'])->name('platform.quartier.toggleEtat');
Route::post('quartiers/delete', [App\Orchid\Screens\Quartier\ListScreen::class, 'delete'])->name('platform.quartier.delete');

//pagelibre//////////////////////
Route::screen('pagelibre/{pagelibre?}', App\Orchid\Screens\Pagelibre\EditScreen::class)->name('platform.pagelibre.edit')
    ->breadcrumbs(function (Trail $trail, $pagelibre = null) {
        $trail->parent('platform.pagelibre.list');
        if ($pagelibre && $pagelibre->exists) {
            $trail->push('Modifier la page de présentation', route('platform.pagelibre.edit', $pagelibre));
        } else {
            $trail->push('Créer une nouvelle page de présentation', route('platform.pagelibre.edit'));
        }
    });
Route::screen('pagelibres', App\Orchid\Screens\Pagelibre\ListScreen::class)->name('platform.pagelibre.list')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.index')
        ->push('Pages de présentation', route('platform.pagelibre.list')));
Route::screen('pagelibres/{pagelibre}/show', App\Orchid\Screens\Pagelibre\ShowScreen::class)->name('platform.pagelibre.show')
    ->breadcrumbs(function (Trail $trail, $pagelibre) {
        return $trail
            ->parent('platform.pagelibre.list') 
            ->push('Détail de la page de présentation');
    });
Route::post('pagelibres/toggleSpotlight', [App\Orchid\Screens\Pagelibre\ListScreen::class, 'toggleSpotlight'])->name('platform.pagelibre.toggleSpotlight');
Route::post('pagelibres/toggleEtat', [App\Orchid\Screens\Pagelibre\ListScreen::class, 'toggleEtat'])->name('platform.pagelibre.toggleEtat');
Route::post('pagelibres/delete', [App\Orchid\Screens\Pagelibre\ListScreen::class, 'delete'])->name('platform.pagelibre.delete');

//actualite//////////////////////
Route::screen('actualite/{actualite?}', App\Orchid\Screens\Actualite\EditScreen::class)->name('platform.actualite.edit')
    ->breadcrumbs(function (Trail $trail, $actualite = null) {
        $trail->parent('platform.actualite.list');
        if ($actualite && $actualite->exists) {
            $trail->push('Modifier l\'actualité', route('platform.actualite.edit', $actualite));
        } else {
            $trail->push('Créer une actualité', route('platform.actualite.edit'));
        }
    });
Route::screen('actualites', App\Orchid\Screens\Actualite\ListScreen::class)->name('platform.actualite.list')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.index')
        ->push('Actualités', route('platform.actualite.list')));
Route::screen('actualites/{actualite}/show', App\Orchid\Screens\Actualite\ShowScreen::class)->name('platform.actualite.show')
    ->breadcrumbs(function (Trail $trail, $actualite) {
        return $trail
            ->parent('platform.actualite.list') 
            ->push('Détail de l\'actualité');
    });
Route::post('actualites/toggleSpotlight', [App\Orchid\Screens\Actualite\ListScreen::class, 'toggleSpotlight'])->name('platform.actualite.toggleSpotlight');
Route::post('actualites/toggleEtat', [App\Orchid\Screens\Actualite\ListScreen::class, 'toggleEtat'])->name('platform.actualite.toggleEtat');
Route::post('actualites/delete', [App\Orchid\Screens\Actualite\ListScreen::class, 'delete'])->name('platform.actualite.delete');

//evenement//////////////////////
Route::screen('evenement/{evenement?}', App\Orchid\Screens\Evenement\EditScreen::class)->name('platform.evenement.edit')
    ->breadcrumbs(function (Trail $trail, $evenement = null) {
        $trail->parent('platform.evenement.list');
        if ($evenement && $evenement->exists) {
            $trail->push('Modifier l\'évènement', route('platform.evenement.edit', $evenement));
        } else {
            $trail->push('Créer un évènement', route('platform.evenement.edit'));
        }
    });
Route::screen('evenements', App\Orchid\Screens\Evenement\ListScreen::class)->name('platform.evenement.list')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.index')
        ->push('Évènements', route('platform.evenement.list')));
Route::screen('evenements/{evenement}/show', App\Orchid\Screens\Evenement\ShowScreen::class)->name('platform.evenement.show')
    ->breadcrumbs(function (Trail $trail, $evenement) {
        return $trail
            ->parent('platform.evenement.list') 
            ->push('Détail de l\'évènement');
    });
Route::post('evenements/toggleSpotlight', [App\Orchid\Screens\Evenement\ListScreen::class, 'toggleSpotlight'])->name('platform.evenement.toggleSpotlight');
Route::post('evenements/toggleEtat', [App\Orchid\Screens\Evenement\ListScreen::class, 'toggleEtat'])->name('platform.evenement.toggleEtat');
Route::post('evenements/delete', [App\Orchid\Screens\Evenement\ListScreen::class, 'delete'])->name('platform.evenement.delete');

//partenaire//////////////////////
Route::screen('partenaire/{partenaire?}', App\Orchid\Screens\Partenaire\EditScreen::class)->name('platform.partenaire.edit')
    ->breadcrumbs(function (Trail $trail, $partenaire = null) {
        $trail->parent('platform.partenaire.list');
        if ($partenaire && $partenaire->exists) {
            $trail->push('Modifier le partenaire', route('platform.partenaire.edit', $partenaire));
        } else {
            $trail->push('Créer un partenaire', route('platform.partenaire.edit'));
        }
    });
Route::screen('partenaires', App\Orchid\Screens\Partenaire\ListScreen::class)->name('platform.partenaire.list')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.index')
        ->push('Partenaires', route('platform.partenaire.list')));
Route::screen('partenaires/{partenaire}/show', App\Orchid\Screens\Partenaire\ShowScreen::class)->name('platform.partenaire.show')
    ->breadcrumbs(function (Trail $trail, $partenaire) {
        return $trail
            ->parent('platform.partenaire.list') 
            ->push('Détail du partenaire');
    });
Route::post('partenaires/toggleSpotlight', [App\Orchid\Screens\Partenaire\ListScreen::class, 'toggleSpotlight'])->name('platform.partenaire.toggleSpotlight');
Route::post('partenaires/toggleEtat', [App\Orchid\Screens\Partenaire\ListScreen::class, 'toggleEtat'])->name('platform.partenaire.toggleEtat');
Route::post('partenaires/delete', [App\Orchid\Screens\Partenaire\ListScreen::class, 'delete'])->name('platform.partenaire.delete');

//slider//////////////////////
Route::screen('slider/{slider?}', App\Orchid\Screens\Slider\EditScreen::class)->name('platform.slider.edit')
    ->breadcrumbs(function (Trail $trail, $slider = null) {
        $trail->parent('platform.slider.list');
        if ($slider && $slider->exists) {
            $trail->push('Modifier le slider', route('platform.slider.edit', $slider));
        } else {
            $trail->push('Créer un slider', route('platform.slider.edit'));
        }
    });
Route::screen('sliders', App\Orchid\Screens\Slider\ListScreen::class)->name('platform.slider.list')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.index')
        ->push('Sliders', route('platform.slider.list')));
Route::screen('sliders/{slider}/show', App\Orchid\Screens\Slider\ShowScreen::class)->name('platform.slider.show')
    ->breadcrumbs(function (Trail $trail, $slider) {
        return $trail
            ->parent('platform.slider.list') 
            ->push('Détail du slider');
    });
Route::post('sliders/toggleSpotlight', [App\Orchid\Screens\Slider\ListScreen::class, 'toggleSpotlight'])->name('platform.slider.toggleSpotlight');
Route::post('sliders/toggleEtat', [App\Orchid\Screens\Slider\ListScreen::class, 'toggleEtat'])->name('platform.slider.toggleEtat');
Route::post('sliders/delete', [App\Orchid\Screens\Slider\ListScreen::class, 'delete'])->name('platform.slider.delete');

//service//////////////////////
Route::screen('service/{service?}', App\Orchid\Screens\Service\EditScreen::class)->name('platform.service.edit')
    ->breadcrumbs(function (Trail $trail, $service = null) {
        $trail->parent('platform.service.list');
        if ($service && $service->exists) {
            $trail->push('Modifier le service', route('platform.service.edit', $service));
        } else {
            $trail->push('Créer un service', route('platform.service.edit'));
        }
    });
Route::screen('services', App\Orchid\Screens\Service\ListScreen::class)->name('platform.service.list')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.index')
        ->push('Services', route('platform.service.list')));
Route::screen('services/{service}/show', App\Orchid\Screens\Service\ShowScreen::class)->name('platform.service.show')
    ->breadcrumbs(function (Trail $trail, $service) {
        return $trail
            ->parent('platform.service.list') 
            ->push('Détail du service');
    });
Route::post('services/toggleSpotlight', [App\Orchid\Screens\Service\ListScreen::class, 'toggleSpotlight'])->name('platform.service.toggleSpotlight');
Route::post('services/toggleEtat', [App\Orchid\Screens\Service\ListScreen::class, 'toggleEtat'])->name('platform.service.toggleEtat');
Route::post('services/delete', [App\Orchid\Screens\Service\ListScreen::class, 'delete'])->name('platform.service.delete');

//chiffre//////////////////////
Route::screen('chiffre/{chiffre?}', App\Orchid\Screens\Chiffre\EditScreen::class)->name('platform.chiffre.edit')
    ->breadcrumbs(function (Trail $trail, $chiffre = null) {
        $trail->parent('platform.chiffre.list');
        if ($chiffre && $chiffre->exists) {
            $trail->push('Modifier le chiffre', route('platform.chiffre.edit', $chiffre));
        } else {
            $trail->push('Créer un chiffre', route('platform.chiffre.edit'));
        }
    });
Route::screen('chiffres', App\Orchid\Screens\Chiffre\ListScreen::class)->name('platform.chiffre.list')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.index')
        ->push('Chiffres', route('platform.chiffre.list')));
Route::screen('chiffres/{chiffre}/show', App\Orchid\Screens\Chiffre\ShowScreen::class)->name('platform.chiffre.show')
    ->breadcrumbs(function (Trail $trail, $chiffre) {
        return $trail
            ->parent('platform.chiffre.list') 
            ->push('Détail du chiffre');
    });
Route::post('chiffres/toggleSpotlight', [App\Orchid\Screens\Chiffre\ListScreen::class, 'toggleSpotlight'])->name('platform.chiffre.toggleSpotlight');
Route::post('chiffres/toggleEtat', [App\Orchid\Screens\Chiffre\ListScreen::class, 'toggleEtat'])->name('platform.chiffre.toggleEtat');
Route::post('chiffres/delete', [App\Orchid\Screens\Chiffre\ListScreen::class, 'delete'])->name('platform.chiffre.delete');

//temoignage//////////////////////
Route::screen('temoignage/{temoignage?}', App\Orchid\Screens\Temoignage\EditScreen::class)->name('platform.temoignage.edit')
    ->breadcrumbs(function (Trail $trail, $temoignage = null) {
        $trail->parent('platform.temoignage.list');
        if ($temoignage && $temoignage->exists) {
            $trail->push('Modifier le témoignage', route('platform.temoignage.edit', $temoignage));
        } else {
            $trail->push('Créer un témoignage', route('platform.temoignage.edit'));
        }
    });
Route::screen('temoignages', App\Orchid\Screens\Temoignage\ListScreen::class)->name('platform.temoignage.list')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.index')
        ->push('Témoignages', route('platform.temoignage.list')));
Route::screen('temoignages/{temoignage}/show', App\Orchid\Screens\Temoignage\ShowScreen::class)->name('platform.temoignage.show')
    ->breadcrumbs(function (Trail $trail, $temoignage) {
        return $trail
            ->parent('platform.temoignage.list') 
            ->push('Détail du témoignage');
    });
Route::post('temoignages/toggleSpotlight', [App\Orchid\Screens\Temoignage\ListScreen::class, 'toggleSpotlight'])->name('platform.temoignage.toggleSpotlight');
Route::post('temoignages/toggleEtat', [App\Orchid\Screens\Temoignage\ListScreen::class, 'toggleEtat'])->name('platform.temoignage.toggleEtat');
Route::post('temoignages/delete', [App\Orchid\Screens\Temoignage\ListScreen::class, 'delete'])->name('platform.temoignage.delete');

//contact//////////////////////
Route::screen('contact/{contact?}', App\Orchid\Screens\Contact\EditScreen::class)->name('platform.contact.edit')
    ->breadcrumbs(function (Trail $trail, $contact = null) {
        $trail->parent('platform.contact.list');
        if ($contact && $contact->exists) {
            $trail->push('Modifier le contact', route('platform.contact.edit', $contact));
        } else {
            $trail->push('Créer un contact', route('platform.contact.edit'));
        }
    });
Route::screen('contacts', App\Orchid\Screens\Contact\ListScreen::class)->name('platform.contact.list')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.index')
        ->push('Contacts', route('platform.contact.list')));
Route::screen('contacts/{contact}/show', App\Orchid\Screens\Contact\ShowScreen::class)->name('platform.contact.show')
    ->breadcrumbs(function (Trail $trail, $contact) {
        return $trail
            ->parent('platform.contact.list') 
            ->push('Détail du contact');
    });
Route::post('contacts/toggleSpotlight', [App\Orchid\Screens\Contact\ListScreen::class, 'toggleSpotlight'])->name('platform.contact.toggleSpotlight');
Route::post('contacts/toggleEtat', [App\Orchid\Screens\Contact\ListScreen::class, 'toggleEtat'])->name('platform.contact.toggleEtat');
Route::post('contacts/delete', [App\Orchid\Screens\Contact\ListScreen::class, 'delete'])->name('platform.contact.delete');

//commentaire//////////////////////
Route::screen('commentaire/{commentaire?}', App\Orchid\Screens\Commentaire\EditScreen::class)->name('platform.commentaire.edit')
    ->breadcrumbs(function (Trail $trail, $commentaire = null) {
        $trail->parent('platform.commentaire.list');
        if ($commentaire && $commentaire->exists) {
            $trail->push('Modifier le commentaire', route('platform.commentaire.edit', $commentaire));
        } else {
            $trail->push('Créer un commentaire', route('platform.commentaire.edit'));
        }
    });
Route::screen('commentaires', App\Orchid\Screens\Commentaire\ListScreen::class)->name('platform.commentaire.list')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.index')
        ->push('Commentaires', route('platform.commentaire.list')));
Route::screen('commentaires/{commentaire}/show', App\Orchid\Screens\Commentaire\ShowScreen::class)->name('platform.commentaire.show')
    ->breadcrumbs(function (Trail $trail, $commentaire) {
        return $trail
            ->parent('platform.commentaire.list') 
            ->push('Détail du commentaire');
    });
Route::post('commentaires/toggleSpotlight', [App\Orchid\Screens\Commentaire\ListScreen::class, 'toggleSpotlight'])->name('platform.commentaire.toggleSpotlight');
Route::post('commentaires/toggleEtat', [App\Orchid\Screens\Commentaire\ListScreen::class, 'toggleEtat'])->name('platform.commentaire.toggleEtat');
Route::post('commentaires/delete', [App\Orchid\Screens\Commentaire\ListScreen::class, 'delete'])->name('platform.commentaire.delete');

//faq//////////////////////
Route::screen('faq/{faq?}', App\Orchid\Screens\Faq\EditScreen::class)->name('platform.faq.edit')
    ->breadcrumbs(function (Trail $trail, $faq = null) {
        $trail->parent('platform.faq.list');
        if ($faq && $faq->exists) {
            $trail->push('Modifier la question', route('platform.faq.edit', $faq));
        } else {
            $trail->push('Créer une question', route('platform.faq.edit'));
        }
    });
Route::screen('faqs', App\Orchid\Screens\Faq\ListScreen::class)->name('platform.faq.list')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.index')
        ->push('FAQs', route('platform.faq.list')));
Route::screen('faqs/{faq}/show', App\Orchid\Screens\Faq\ShowScreen::class)->name('platform.faq.show')
    ->breadcrumbs(function (Trail $trail, $faq) {
        return $trail
            ->parent('platform.faq.list') 
            ->push('Détail de la question');
    });
Route::post('faqs/toggleSpotlight', [App\Orchid\Screens\Faq\ListScreen::class, 'toggleSpotlight'])->name('platform.faq.toggleSpotlight');
Route::post('faqs/toggleEtat', [App\Orchid\Screens\Faq\ListScreen::class, 'toggleEtat'])->name('platform.faq.toggleEtat');
Route::post('faqs/delete', [App\Orchid\Screens\Faq\ListScreen::class, 'delete'])->name('platform.faq.delete');

//membre//////////////////////
Route::screen('membre/{membre?}', App\Orchid\Screens\Membre\EditScreen::class)->name('platform.membre.edit')
    ->breadcrumbs(function (Trail $trail, $membre = null) {
        $trail->parent('platform.membre.list');
        if ($membre && $membre->exists) {
            $trail->push('Modifier le membre', route('platform.membre.edit', $membre));
        } else {
            $trail->push('Créer un membre', route('platform.membre.edit'));
        }
    });
Route::screen('membres', App\Orchid\Screens\Membre\ListScreen::class)->name('platform.membre.list')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.index')
        ->push('Membres', route('platform.membre.list')));
Route::screen('membres/{membre}/show', App\Orchid\Screens\Membre\ShowScreen::class)->name('platform.membre.show')
    ->breadcrumbs(function (Trail $trail, $membre) {
        return $trail
            ->parent('platform.membre.list') 
            ->push('Détail du membre');
    });
Route::post('membres/toggleSpotlight', [App\Orchid\Screens\Membre\ListScreen::class, 'toggleSpotlight'])->name('platform.membre.toggleSpotlight');
Route::post('membres/toggleEtat', [App\Orchid\Screens\Membre\ListScreen::class, 'toggleEtat'])->name('platform.membre.toggleEtat');
Route::post('membres/delete', [App\Orchid\Screens\Membre\ListScreen::class, 'delete'])->name('platform.membre.delete');

//entreprise//////////////////////
Route::screen('entreprise/{entreprise?}', App\Orchid\Screens\Entreprise\EditScreen::class)->name('platform.entreprise.edit')
    ->breadcrumbs(function (Trail $trail, $entreprise = null) {
        $trail->parent('platform.entreprise.list');
        if ($entreprise && $entreprise->exists) {
            $trail->push('Modifier l\'entreprise', route('platform.entreprise.edit', $entreprise));
        } else {
            $trail->push('Créer une entreprise', route('platform.entreprise.edit'));
        }
    });
Route::screen('entreprises', App\Orchid\Screens\Entreprise\ListScreen::class)->name('platform.entreprise.list')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.index')
        ->push('Entreprises', route('platform.entreprise.list')));
Route::screen('entreprises/{entreprise}/show', App\Orchid\Screens\Entreprise\ShowScreen::class)->name('platform.entreprise.show')
    ->breadcrumbs(function (Trail $trail, $entreprise) {
        return $trail
            ->parent('platform.entreprise.list') 
            ->push('Détail de l\'entreprise');
    });
Route::post('entreprises/toggleSpotlight', [App\Orchid\Screens\Entreprise\ListScreen::class, 'toggleSpotlight'])->name('platform.entreprise.toggleSpotlight');
Route::post('entreprises/toggleEtat', [App\Orchid\Screens\Entreprise\ListScreen::class, 'toggleEtat'])->name('platform.entreprise.toggleEtat');
Route::post('entreprises/delete', [App\Orchid\Screens\Entreprise\ListScreen::class, 'delete'])->name('platform.entreprise.delete');

//alerte//////////////////////
Route::screen('alerte/{alerte?}', App\Orchid\Screens\Alerte\EditScreen::class)->name('platform.alerte.edit')
    ->breadcrumbs(function (Trail $trail, $alerte = null) {
        $trail->parent('platform.alerte.list');
        if ($alerte && $alerte->exists) {
            $trail->push('Modifier l\'alerte', route('platform.alerte.edit', $alerte));
        } else {
            $trail->push('Créer une alerte', route('platform.alerte.edit'));
        }
    });
Route::screen('alertes', App\Orchid\Screens\Alerte\ListScreen::class)->name('platform.alerte.list')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.index')
        ->push('Alertes', route('platform.alerte.list')));
Route::screen('alertes/{alerte}/show', App\Orchid\Screens\Alerte\ShowScreen::class)->name('platform.alerte.show')
    ->breadcrumbs(function (Trail $trail, $alerte) {
        return $trail
            ->parent('platform.alerte.list') 
            ->push('Détail de l\'alerte');
    });
Route::post('alertes/toggleLu', [App\Orchid\Screens\Alerte\ListScreen::class, 'toggleLu'])->name('platform.alerte.toggleLu');
Route::post('alertes/toggleEtat', [App\Orchid\Screens\Alerte\ListScreen::class, 'toggleEtat'])->name('platform.alerte.toggleEtat');
Route::post('alertes/delete', [App\Orchid\Screens\Alerte\ListScreen::class, 'delete'])->name('platform.alerte.delete');

//bon//////////////////////
Route::screen('bon/{bon?}', App\Orchid\Screens\Bon\EditScreen::class)->name('platform.bon.edit')
    ->breadcrumbs(function (Trail $trail, $bon = null) {
        $trail->parent('platform.bon.list');
        if ($bon && $bon->exists) {
            $trail->push('Modifier le bon', route('platform.bon.edit', $bon));
        } else {
            $trail->push('Créer un bon', route('platform.bon.edit'));
        }
    });
Route::screen('bons', App\Orchid\Screens\Bon\ListScreen::class)->name('platform.bon.list')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.index')
        ->push('Bons', route('platform.bon.list')));
Route::screen('bons/{bon}/show', App\Orchid\Screens\Bon\ShowScreen::class)->name('platform.bon.show')
    ->breadcrumbs(function (Trail $trail, $bon) {
        return $trail
            ->parent('platform.bon.list') 
            ->push('Détail du bon');
    });
Route::post('bons/toggleSpotlight', [App\Orchid\Screens\Bon\ListScreen::class, 'toggleSpotlight'])->name('platform.bon.toggleSpotlight');
Route::post('bons/toggleEtat', [App\Orchid\Screens\Bon\ListScreen::class, 'toggleEtat'])->name('platform.bon.toggleEtat');
Route::post('bons/delete', [App\Orchid\Screens\Bon\ListScreen::class, 'delete'])->name('platform.bon.delete');

//prestation//////////////////////
Route::screen('prestation/{prestation?}', App\Orchid\Screens\Prestation\EditScreen::class)->name('platform.prestation.edit')
    ->breadcrumbs(function (Trail $trail, $prestation = null) {
        $trail->parent('platform.prestation.list');
        if ($prestation && $prestation->exists) {
            $trail->push('Modifier l\'prestation', route('platform.prestation.edit', $prestation));
        } else {
            $trail->push('Créer une prestation', route('platform.prestation.edit'));
        }
    });
Route::screen('prestations', App\Orchid\Screens\Prestation\ListScreen::class)->name('platform.prestation.list')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.index')
        ->push('Prestations', route('platform.prestation.list')));
Route::screen('prestations/{prestation}/show', App\Orchid\Screens\Prestation\ShowScreen::class)->name('platform.prestation.show')
    ->breadcrumbs(function (Trail $trail, $prestation) {
        return $trail
            ->parent('platform.prestation.list') 
            ->push('Détail de l\'prestation');
    });
Route::post('prestations/toggleSpotlight', [App\Orchid\Screens\Prestation\ListScreen::class, 'toggleSpotlight'])->name('platform.prestation.toggleSpotlight');
Route::post('prestations/toggleEtat', [App\Orchid\Screens\Prestation\ListScreen::class, 'toggleEtat'])->name('platform.prestation.toggleEtat');
Route::post('prestations/delete', [App\Orchid\Screens\Prestation\ListScreen::class, 'delete'])->name('platform.prestation.delete');

//formation//////////////////////
Route::screen('formation/{formation?}', App\Orchid\Screens\Formation\EditScreen::class)->name('platform.formation.edit')
    ->breadcrumbs(function (Trail $trail, $formation = null) {
        $trail->parent('platform.formation.list');
        if ($formation && $formation->exists) {
            $trail->push('Modifier la formation', route('platform.formation.edit', $formation));
        } else {
            $trail->push('Créer une formation', route('platform.formation.edit'));
        }
    });
Route::screen('formations', App\Orchid\Screens\Formation\ListScreen::class)->name('platform.formation.list')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.index')
        ->push('Formations', route('platform.formation.list')));
Route::screen('formations/{formation}/show', App\Orchid\Screens\Formation\ShowScreen::class)->name('platform.formation.show')
    ->breadcrumbs(function (Trail $trail, $formation) {
        return $trail
            ->parent('platform.formation.list') 
            ->push('Détail de la formation');
    });
Route::post('formations/toggleSpotlight', [App\Orchid\Screens\Formation\ListScreen::class, 'toggleSpotlight'])->name('platform.formation.toggleSpotlight');
Route::post('formations/toggleEtat', [App\Orchid\Screens\Formation\ListScreen::class, 'toggleEtat'])->name('platform.formation.toggleEtat');
Route::post('formations/delete', [App\Orchid\Screens\Formation\ListScreen::class, 'delete'])->name('platform.formation.delete');

//entreprisemembre//////////////////////
Route::screen('entreprisemembre/{entreprisemembre?}', App\Orchid\Screens\Entreprisemembre\EditScreen::class)->name('platform.entreprisemembre.edit')
    ->breadcrumbs(function (Trail $trail, $entreprisemembre = null) {
        $trail->parent('platform.entreprisemembre.list');
        if ($entreprisemembre && $entreprisemembre->exists) {
            $trail->push('Modifier le membre de l\'entreprise', route('platform.entreprisemembre.edit', $entreprisemembre));
        } else {
            $trail->push('Créer un membre de l\'entreprise', route('platform.entreprisemembre.edit'));
        }
    });
Route::screen('entreprisemembres', App\Orchid\Screens\Entreprisemembre\ListScreen::class)->name('platform.entreprisemembre.list')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.index')
        ->push('Membre de l\'entreprise', route('platform.entreprisemembre.list')));
Route::screen('entreprisemembres/{entreprisemembre}/show', App\Orchid\Screens\Entreprisemembre\ShowScreen::class)->name('platform.entreprisemembre.show')
    ->breadcrumbs(function (Trail $trail, $entreprisemembre) {
        return $trail
            ->parent('platform.entreprisemembre.list') 
            ->push('Détail du membre de l\'entreprise');
    });
Route::post('entreprisemembres/toggleSpotlight', [App\Orchid\Screens\Entreprisemembre\ListScreen::class, 'toggleSpotlight'])->name('platform.entreprisemembre.toggleSpotlight');
Route::post('entreprisemembres/toggleEtat', [App\Orchid\Screens\Entreprisemembre\ListScreen::class, 'toggleEtat'])->name('platform.entreprisemembre.toggleEtat');
Route::post('entreprisemembres/delete', [App\Orchid\Screens\Entreprisemembre\ListScreen::class, 'delete'])->name('platform.entreprisemembre.delete');

//accompagnement//////////////////////
Route::screen('accompagnement/{accompagnement?}', App\Orchid\Screens\Accompagnement\EditScreen::class)->name('platform.accompagnement.edit')
    ->breadcrumbs(function (Trail $trail, $accompagnement = null) {
        $trail->parent('platform.accompagnement.list');
        if ($accompagnement && $accompagnement->exists) {
            $trail->push('Modifier l\'accompagnement', route('platform.accompagnement.edit', $accompagnement));
        } else {
            $trail->push('Créer un accompagnement', route('platform.accompagnement.edit'));
        }
    });
Route::screen('accompagnements', App\Orchid\Screens\Accompagnement\ListScreen::class)->name('platform.accompagnement.list')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.index')
        ->push('Accompagnements', route('platform.accompagnement.list')));
Route::screen('accompagnements/{accompagnement}/show', App\Orchid\Screens\Accompagnement\ShowScreen::class)->name('platform.accompagnement.show')
    ->breadcrumbs(function (Trail $trail, $accompagnement) {
        return $trail
            ->parent('platform.accompagnement.list') 
            ->push('Détail de l\'accompagnement');
    });
Route::post('accompagnements/toggleSpotlight', [App\Orchid\Screens\Accompagnement\ListScreen::class, 'toggleSpotlight'])->name('platform.accompagnement.toggleSpotlight');
Route::post('accompagnements/toggleEtat', [App\Orchid\Screens\Accompagnement\ListScreen::class, 'toggleEtat'])->name('platform.accompagnement.toggleEtat');
Route::post('accompagnements/delete', [App\Orchid\Screens\Accompagnement\ListScreen::class, 'delete'])->name('platform.accompagnement.delete');

//evenementinscription//////////////////////
Route::screen('evenementinscription/{evenementinscription?}', App\Orchid\Screens\Evenementinscription\EditScreen::class)->name('platform.evenementinscription.edit')
    ->breadcrumbs(function (Trail $trail, $evenementinscription = null) {
        $trail->parent('platform.evenementinscription.list');
        if ($evenementinscription && $evenementinscription->exists) {
            $trail->push('Modifier l\'inscription à l\'évènement', route('platform.evenementinscription.edit', $evenementinscription));
        } else {
            $trail->push('Créer une inscription à l\'évènement', route('platform.evenementinscription.edit'));
        }
    });
Route::screen('evenementinscriptions', App\Orchid\Screens\Evenementinscription\ListScreen::class)->name('platform.evenementinscription.list')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.index')
        ->push('Inscription à l\'évènement', route('platform.evenementinscription.list')));
Route::screen('evenementinscriptions/{evenementinscription}/show', App\Orchid\Screens\Evenementinscription\ShowScreen::class)->name('platform.evenementinscription.show')
    ->breadcrumbs(function (Trail $trail, $evenementinscription) {
        return $trail
            ->parent('platform.evenementinscription.list') 
            ->push('Détail de l\'inscription à l\'évènement');
    });
Route::post('evenementinscriptions/toggleSpotlight', [App\Orchid\Screens\Evenementinscription\ListScreen::class, 'toggleSpotlight'])->name('platform.evenementinscription.toggleSpotlight');
Route::post('evenementinscriptions/toggleEtat', [App\Orchid\Screens\Evenementinscription\ListScreen::class, 'toggleEtat'])->name('platform.evenementinscription.toggleEtat');
Route::post('evenementinscriptions/delete', [App\Orchid\Screens\Evenementinscription\ListScreen::class, 'delete'])->name('platform.evenementinscription.delete');

//participant//////////////////////
Route::screen('participant/{participant?}', App\Orchid\Screens\Participant\EditScreen::class)->name('platform.participant.edit')
    ->breadcrumbs(function (Trail $trail, $participant = null) {
        $trail->parent('platform.participant.list');
        if ($participant && $participant->exists) {
            $trail->push('Modifier le participant', route('platform.participant.edit', $participant));
        } else {
            $trail->push('Créer un participant', route('platform.participant.edit'));
        }
    });
Route::screen('participants', App\Orchid\Screens\Participant\ListScreen::class)->name('platform.participant.list')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.index')
        ->push('Participants', route('platform.participant.list')));
Route::screen('participants/{participant}/show', App\Orchid\Screens\Participant\ShowScreen::class)->name('platform.participant.show')
    ->breadcrumbs(function (Trail $trail, $participant) {
        return $trail
            ->parent('platform.participant.list') 
            ->push('Détail du participant');
    });
Route::post('participants/toggleSpotlight', [App\Orchid\Screens\Participant\ListScreen::class, 'toggleSpotlight'])->name('platform.participant.toggleSpotlight');
Route::post('participants/toggleEtat', [App\Orchid\Screens\Participant\ListScreen::class, 'toggleEtat'])->name('platform.participant.toggleEtat');
Route::post('participants/delete', [App\Orchid\Screens\Participant\ListScreen::class, 'delete'])->name('platform.participant.delete');

//suivi//////////////////////
Route::screen('suivi/{suivi?}', App\Orchid\Screens\Suivi\EditScreen::class)->name('platform.suivi.edit')
    ->breadcrumbs(function (Trail $trail, $suivi = null) {
        $trail->parent('platform.suivi.list');
        if ($suivi && $suivi->exists) {
            $trail->push('Modifier le suivi', route('platform.suivi.edit', $suivi));
        } else {
            $trail->push('Créer un suivi', route('platform.suivi.edit'));
        }
    });
Route::screen('suivis', App\Orchid\Screens\Suivi\ListScreen::class)->name('platform.suivi.list')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.index')
        ->push('Suivis', route('platform.suivi.list')));
Route::screen('suivis/{suivi}/show', App\Orchid\Screens\Suivi\ShowScreen::class)->name('platform.suivi.show')
    ->breadcrumbs(function (Trail $trail, $suivi) {
        return $trail
            ->parent('platform.suivi.list') 
            ->push('Détail du suivi');
    });
Route::post('suivis/toggleSpotlight', [App\Orchid\Screens\Suivi\ListScreen::class, 'toggleSpotlight'])->name('platform.suivi.toggleSpotlight');
Route::post('suivis/toggleEtat', [App\Orchid\Screens\Suivi\ListScreen::class, 'toggleEtat'])->name('platform.suivi.toggleEtat');
Route::post('suivis/delete', [App\Orchid\Screens\Suivi\ListScreen::class, 'delete'])->name('platform.suivi.delete');

//prestationrealisee//////////////////////
Route::screen('prestationrealisee/{prestationrealisee?}', App\Orchid\Screens\Prestationrealisee\EditScreen::class)->name('platform.prestationrealisee.edit')
    ->breadcrumbs(function (Trail $trail, $prestationrealisee = null) {
        $trail->parent('platform.prestationrealisee.list');
        if ($prestationrealisee && $prestationrealisee->exists) {
            $trail->push('Modifier la réalisation', route('platform.prestationrealisee.edit', $prestationrealisee));
        } else {
            $trail->push('Créer une réalisation', route('platform.prestationrealisee.edit'));
        }
    });
Route::screen('prestationrealisees', App\Orchid\Screens\Prestationrealisee\ListScreen::class)->name('platform.prestationrealisee.list')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.index')
        ->push('Réalisations', route('platform.prestationrealisee.list')));
Route::screen('prestationrealisees/{prestationrealisee}/show', App\Orchid\Screens\Prestationrealisee\ShowScreen::class)->name('platform.prestationrealisee.show')
    ->breadcrumbs(function (Trail $trail, $prestationrealisee) {
        return $trail
            ->parent('platform.prestationrealisee.list') 
            ->push('Détail de la réalisation');
    });
Route::post('prestationrealisees/toggleSpotlight', [App\Orchid\Screens\Prestationrealisee\ListScreen::class, 'toggleSpotlight'])->name('platform.prestationrealisee.toggleSpotlight');
Route::post('prestationrealisees/toggleEtat', [App\Orchid\Screens\Prestationrealisee\ListScreen::class, 'toggleEtat'])->name('platform.prestationrealisee.toggleEtat');
Route::post('prestationrealisees/delete', [App\Orchid\Screens\Prestationrealisee\ListScreen::class, 'delete'])->name('platform.prestationrealisee.delete');

//bonutilise//////////////////////
Route::screen('bonutilise/{bonutilise?}', App\Orchid\Screens\Bonutilise\EditScreen::class)->name('platform.bonutilise.edit')
    ->breadcrumbs(function (Trail $trail, $bonutilise = null) {
        $trail->parent('platform.bonutilise.list');
        if ($bonutilise && $bonutilise->exists) {
            $trail->push('Modifier le bon utilisé', route('platform.bonutilise.edit', $bonutilise));
        } else {
            $trail->push('Créer un bon utilisé', route('platform.bonutilise.edit'));
        }
    });
Route::screen('bonutilises', App\Orchid\Screens\Bonutilise\ListScreen::class)->name('platform.bonutilise.list')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.index')
        ->push('Bons utilisés', route('platform.bonutilise.list')));
Route::screen('bonutilises/{bonutilise}/show', App\Orchid\Screens\Bonutilise\ShowScreen::class)->name('platform.bonutilise.show')
    ->breadcrumbs(function (Trail $trail, $bonutilise) {
        return $trail
            ->parent('platform.bonutilise.list') 
            ->push('Détail du bon utilisé');
    });
Route::post('bonutilises/toggleSpotlight', [App\Orchid\Screens\Bonutilise\ListScreen::class, 'toggleSpotlight'])->name('platform.bonutilise.toggleSpotlight');
Route::post('bonutilises/toggleEtat', [App\Orchid\Screens\Bonutilise\ListScreen::class, 'toggleEtat'])->name('platform.bonutilise.toggleEtat');
Route::post('bonutilises/delete', [App\Orchid\Screens\Bonutilise\ListScreen::class, 'delete'])->name('platform.bonutilise.delete');

//plan//////////////////////
Route::screen('plan/{plan?}', App\Orchid\Screens\Plan\EditScreen::class)->name('platform.plan.edit')
    ->breadcrumbs(function (Trail $trail, $plan = null) {
        $trail->parent('platform.plan.list');
        if ($plan && $plan->exists) {
            $trail->push('Modifier l\'plan', route('platform.plan.edit', $plan));
        } else {
            $trail->push('Créer une plan', route('platform.plan.edit'));
        }
    });
Route::screen('plans', App\Orchid\Screens\Plan\ListScreen::class)->name('platform.plan.list')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.index')
        ->push('Plans', route('platform.plan.list')));
Route::screen('plans/{plan}/show', App\Orchid\Screens\Plan\ShowScreen::class)->name('platform.plan.show')
    ->breadcrumbs(function (Trail $trail, $plan) {
        return $trail
            ->parent('platform.plan.list') 
            ->push('Détail de l\'plan');
    });
Route::post('plans/toggleSpotlight', [App\Orchid\Screens\Plan\ListScreen::class, 'toggleSpotlight'])->name('platform.plan.toggleSpotlight');
Route::post('plans/toggleEtat', [App\Orchid\Screens\Plan\ListScreen::class, 'toggleEtat'])->name('platform.plan.toggleEtat');
Route::post('plans/delete', [App\Orchid\Screens\Plan\ListScreen::class, 'delete'])->name('platform.plan.delete');

//document//////////////////////
Route::screen('document/{document?}', App\Orchid\Screens\Document\EditScreen::class)->name('platform.document.edit')
    ->breadcrumbs(function (Trail $trail, $document = null) {
        $trail->parent('platform.document.list');
        if ($document && $document->exists) {
            $trail->push('Modifier l\'document', route('platform.document.edit', $document));
        } else {
            $trail->push('Créer une document', route('platform.document.edit'));
        }
    });
Route::screen('documents', App\Orchid\Screens\Document\ListScreen::class)->name('platform.document.list')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.index')
        ->push('Documents', route('platform.document.list')));
Route::screen('documents/{document}/show', App\Orchid\Screens\Document\ShowScreen::class)->name('platform.document.show')
    ->breadcrumbs(function (Trail $trail, $document) {
        return $trail
            ->parent('platform.document.list') 
            ->push('Détail de l\'document');
    });
Route::post('documents/toggleSpotlight', [App\Orchid\Screens\Document\ListScreen::class, 'toggleSpotlight'])->name('platform.document.toggleSpotlight');
Route::post('documents/toggleEtat', [App\Orchid\Screens\Document\ListScreen::class, 'toggleEtat'])->name('platform.document.toggleEtat');
Route::post('documents/delete', [App\Orchid\Screens\Document\ListScreen::class, 'delete'])->name('platform.document.delete');

//piece//////////////////////
Route::screen('piece/{piece?}', App\Orchid\Screens\Piece\EditScreen::class)->name('platform.piece.edit')
    ->breadcrumbs(function (Trail $trail, $piece = null) {
        $trail->parent('platform.piece.list');
        if ($piece && $piece->exists) {
            $trail->push('Modifier la pièce', route('platform.piece.edit', $piece));
        } else {
            $trail->push('Créer une pièce', route('platform.piece.edit'));
        }
    });
Route::screen('pieces', App\Orchid\Screens\Piece\ListScreen::class)->name('platform.piece.list')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.index')
        ->push('Pièces', route('platform.piece.list')));
Route::screen('pieces/{piece}/show', App\Orchid\Screens\Piece\ShowScreen::class)->name('platform.piece.show')
    ->breadcrumbs(function (Trail $trail, $piece) {
        return $trail
            ->parent('platform.piece.list') 
            ->push('Détail de la pièce');
    });
Route::post('pieces/toggleSpotlight', [App\Orchid\Screens\Piece\ListScreen::class, 'toggleSpotlight'])->name('platform.piece.toggleSpotlight');
Route::post('pieces/toggleEtat', [App\Orchid\Screens\Piece\ListScreen::class, 'toggleEtat'])->name('platform.piece.toggleEtat');
Route::post('pieces/delete', [App\Orchid\Screens\Piece\ListScreen::class, 'delete'])->name('platform.piece.delete');

//accompagnementdocument//////////////////////
Route::screen('accompagnementdocument/{accompagnementdocument?}', App\Orchid\Screens\Accompagnementdocument\EditScreen::class)->name('platform.accompagnementdocument.edit')
    ->breadcrumbs(function (Trail $trail, $accompagnementdocument = null) {
        $trail->parent('platform.accompagnementdocument.list');
        if ($accompagnementdocument && $accompagnementdocument->exists) {
            $trail->push('Modifier le document', route('platform.accompagnementdocument.edit', $accompagnementdocument));
        } else {
            $trail->push('Créer un document', route('platform.accompagnementdocument.edit'));
        }
    });
Route::screen('accompagnementdocuments', App\Orchid\Screens\Accompagnementdocument\ListScreen::class)->name('platform.accompagnementdocument.list')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.index')
        ->push('Documents d\'accompagnement', route('platform.accompagnementdocument.list')));
Route::screen('accompagnementdocuments/{accompagnementdocument}/show', App\Orchid\Screens\Accompagnementdocument\ShowScreen::class)->name('platform.accompagnementdocument.show')
    ->breadcrumbs(function (Trail $trail, $accompagnementdocument) {
        return $trail
            ->parent('platform.accompagnementdocument.list') 
            ->push('Détail du document');
    });
Route::post('accompagnementdocuments/toggleSpotlight', [App\Orchid\Screens\Accompagnementdocument\ListScreen::class, 'toggleSpotlight'])->name('platform.accompagnementdocument.toggleSpotlight');
Route::post('accompagnementdocuments/toggleEtat', [App\Orchid\Screens\Accompagnementdocument\ListScreen::class, 'toggleEtat'])->name('platform.accompagnementdocument.toggleEtat');
Route::post('accompagnementdocuments/delete', [App\Orchid\Screens\Accompagnementdocument\ListScreen::class, 'delete'])->name('platform.accompagnementdocument.delete');

//expert//////////////////////
Route::screen('expert/{expert?}', App\Orchid\Screens\Expert\EditScreen::class)->name('platform.expert.edit')
    ->breadcrumbs(function (Trail $trail, $expert = null) {
        $trail->parent('platform.expert.list');
        if ($expert && $expert->exists) {
            $trail->push('Modifier l\'expert', route('platform.expert.edit', $expert));
        } else {
            $trail->push('Créer un expert', route('platform.expert.edit'));
        }
    });
Route::screen('experts', App\Orchid\Screens\Expert\ListScreen::class)->name('platform.expert.list')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.index')
        ->push('Experts', route('platform.expert.list')));
Route::screen('experts/{expert}/show', App\Orchid\Screens\Expert\ShowScreen::class)->name('platform.expert.show')
    ->breadcrumbs(function (Trail $trail, $expert) {
        return $trail
            ->parent('platform.expert.list') 
            ->push('Détail de l\'expert');
    });
Route::post('experts/toggleSpotlight', [App\Orchid\Screens\Expert\ListScreen::class, 'toggleSpotlight'])->name('platform.expert.toggleSpotlight');
Route::post('experts/toggleEtat', [App\Orchid\Screens\Expert\ListScreen::class, 'toggleEtat'])->name('platform.expert.toggleEtat');
Route::post('experts/delete', [App\Orchid\Screens\Expert\ListScreen::class, 'delete'])->name('platform.expert.delete');

//conseiller//////////////////////
Route::screen('conseiller/{conseiller?}', App\Orchid\Screens\Conseiller\EditScreen::class)->name('platform.conseiller.edit')
    ->breadcrumbs(function (Trail $trail, $conseiller = null) {
        $trail->parent('platform.conseiller.list');
        if ($conseiller && $conseiller->exists) {
            $trail->push('Modifier le type de paiement', route('platform.conseiller.edit', $conseiller));
        } else {
            $trail->push('Créer un type de paiement', route('platform.conseiller.edit'));
        }
    });
Route::screen('conseillers', App\Orchid\Screens\Conseiller\ListScreen::class)->name('platform.conseiller.list')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.index')
        ->push('Types des paiements', route('platform.conseiller.list')));
Route::screen('conseillers/{conseiller}/show', App\Orchid\Screens\Conseiller\ShowScreen::class)->name('platform.conseiller.show')
    ->breadcrumbs(function (Trail $trail, $conseiller) {
        return $trail
            ->parent('platform.conseiller.list') 
            ->push('Détail du type de paiement');
    });
Route::post('conseillers/toggleSpotlight', [App\Orchid\Screens\Conseiller\ListScreen::class, 'toggleSpotlight'])->name('platform.conseiller.toggleSpotlight');
Route::post('conseillers/toggleEtat', [App\Orchid\Screens\Conseiller\ListScreen::class, 'toggleEtat'])->name('platform.conseiller.toggleEtat');
Route::post('conseillers/delete', [App\Orchid\Screens\Conseiller\ListScreen::class, 'delete'])->name('platform.conseiller.delete');

//ressourcetypeoffretype//////////////////////
Route::screen('ressourcetypeoffretype/{ressourcetypeoffretype?}', App\Orchid\Screens\Ressourcetypeoffretype\EditScreen::class)->name('platform.ressourcetypeoffretype.edit')
    ->breadcrumbs(function (Trail $trail, $ressourcetypeoffretype = null) {
        $trail->parent('platform.ressourcetypeoffretype.list');
        if ($ressourcetypeoffretype && $ressourcetypeoffretype->exists) {
            $trail->push('Modifier le ressourcetypeoffretype', route('platform.ressourcetypeoffretype.edit', $ressourcetypeoffretype));
        } else {
            $trail->push('Créer un ressourcetypeoffretype', route('platform.ressourcetypeoffretype.edit'));
        }
    });
Route::screen('ressourcetypeoffretypes', App\Orchid\Screens\Ressourcetypeoffretype\ListScreen::class)->name('platform.ressourcetypeoffretype.list')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.index')
        ->push('Ressourcetypeoffretypes', route('platform.ressourcetypeoffretype.list')));
Route::screen('ressourcetypeoffretypes/{ressourcetypeoffretype}/show', App\Orchid\Screens\Ressourcetypeoffretype\ShowScreen::class)->name('platform.ressourcetypeoffretype.show')
    ->breadcrumbs(function (Trail $trail, $ressourcetypeoffretype) {
        return $trail
            ->parent('platform.ressourcetypeoffretype.list') 
            ->push('Détail du ressourcetypeoffretype');
    });
Route::post('ressourcetypeoffretypes/toggleSpotlight', [App\Orchid\Screens\Ressourcetypeoffretype\ListScreen::class, 'toggleSpotlight'])->name('platform.ressourcetypeoffretype.toggleSpotlight');
Route::post('ressourcetypeoffretypes/toggleEtat', [App\Orchid\Screens\Ressourcetypeoffretype\ListScreen::class, 'toggleEtat'])->name('platform.ressourcetypeoffretype.toggleEtat');
Route::post('ressourcetypeoffretypes/delete', [App\Orchid\Screens\Ressourcetypeoffretype\ListScreen::class, 'delete'])->name('platform.ressourcetypeoffretype.delete');

//disponibilite//////////////////////
Route::screen('disponibilite/{disponibilite?}', App\Orchid\Screens\Disponibilite\EditScreen::class)->name('platform.disponibilite.edit')
    ->breadcrumbs(function (Trail $trail, $disponibilite = null) {
        $trail->parent('platform.disponibilite.list');
        if ($disponibilite && $disponibilite->exists) {
            $trail->push('Modifier la disponibilité', route('platform.disponibilite.edit', $disponibilite));
        } else {
            $trail->push('Créer une disponibilité', route('platform.disponibilite.edit'));
        }
    });
Route::screen('disponibilites', App\Orchid\Screens\Disponibilite\ListScreen::class)->name('platform.disponibilite.list')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.index')
        ->push('Disponibilités des experts', route('platform.disponibilite.list')));
Route::screen('disponibilites/{disponibilite}/show', App\Orchid\Screens\Disponibilite\ShowScreen::class)->name('platform.disponibilite.show')
    ->breadcrumbs(function (Trail $trail, $disponibilite) {
        return $trail
            ->parent('platform.disponibilite.list') 
            ->push('Détail de la disponibilité');
    });
Route::post('disponibilites/toggleSpotlight', [App\Orchid\Screens\Disponibilite\ListScreen::class, 'toggleSpotlight'])->name('platform.disponibilite.toggleSpotlight');
Route::post('disponibilites/toggleEtat', [App\Orchid\Screens\Disponibilite\ListScreen::class, 'toggleEtat'])->name('platform.disponibilite.toggleEtat');
Route::post('disponibilites/delete', [App\Orchid\Screens\Disponibilite\ListScreen::class, 'delete'])->name('platform.disponibilite.delete');

//evaluation//////////////////////
Route::screen('evaluation/{evaluation?}', App\Orchid\Screens\Evaluation\EditScreen::class)->name('platform.evaluation.edit')
    ->breadcrumbs(function (Trail $trail, $evaluation = null) {
        $trail->parent('platform.evaluation.list');
        if ($evaluation && $evaluation->exists) {
            $trail->push('Modifier l\'évaluation', route('platform.evaluation.edit', $evaluation));
        } else {
            $trail->push('Créer une évaluation', route('platform.evaluation.edit'));
        }
    });
Route::screen('evaluations', App\Orchid\Screens\Evaluation\ListScreen::class)->name('platform.evaluation.list')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.index')
        ->push('Evaluations', route('platform.evaluation.list')));
Route::screen('evaluations/{evaluation}/show', App\Orchid\Screens\Evaluation\ShowScreen::class)->name('platform.evaluation.show')
    ->breadcrumbs(function (Trail $trail, $evaluation) {
        return $trail
            ->parent('platform.evaluation.list') 
            ->push('Détail de l\'évaluation');
    });
Route::post('evaluations/toggleSpotlight', [App\Orchid\Screens\Evaluation\ListScreen::class, 'toggleSpotlight'])->name('platform.evaluation.toggleSpotlight');
Route::post('evaluations/toggleEtat', [App\Orchid\Screens\Evaluation\ListScreen::class, 'toggleEtat'])->name('platform.evaluation.toggleEtat');
Route::post('evaluations/delete', [App\Orchid\Screens\Evaluation\ListScreen::class, 'delete'])->name('platform.evaluation.delete');

//forum//////////////////////
Route::screen('forum/{forum?}', App\Orchid\Screens\Forum\EditScreen::class)->name('platform.forum.edit')
    ->breadcrumbs(function (Trail $trail, $forum = null) {
        $trail->parent('platform.forum.list');
        if ($forum && $forum->exists) {
            $trail->push('Modifier le forum', route('platform.forum.edit', $forum));
        } else {
            $trail->push('Créer un forum', route('platform.forum.edit'));
        }
    });
Route::screen('forums', App\Orchid\Screens\Forum\ListScreen::class)->name('platform.forum.list')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.index')
        ->push('Forums', route('platform.forum.list')));
Route::screen('forums/{forum}/show', App\Orchid\Screens\Forum\ShowScreen::class)->name('platform.forum.show')
    ->breadcrumbs(function (Trail $trail, $forum) {
        return $trail
            ->parent('platform.forum.list') 
            ->push('Détail du forum');
    });
Route::post('forums/toggleSpotlight', [App\Orchid\Screens\Forum\ListScreen::class, 'toggleSpotlight'])->name('platform.forum.toggleSpotlight');
Route::post('forums/toggleEtat', [App\Orchid\Screens\Forum\ListScreen::class, 'toggleEtat'])->name('platform.forum.toggleEtat');
Route::post('forums/delete', [App\Orchid\Screens\Forum\ListScreen::class, 'delete'])->name('platform.forum.delete');

//sujet//////////////////////
Route::screen('sujet/{sujet?}', App\Orchid\Screens\Sujet\EditScreen::class)->name('platform.sujet.edit')
    ->breadcrumbs(function (Trail $trail, $sujet = null) {
        $trail->parent('platform.sujet.list');
        if ($sujet && $sujet->exists) {
            $trail->push('Modifier le sujet', route('platform.sujet.edit', $sujet));
        } else {
            $trail->push('Créer un sujet', route('platform.sujet.edit'));
        }
    });
Route::screen('sujets', App\Orchid\Screens\Sujet\ListScreen::class)->name('platform.sujet.list')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.index')
        ->push('Sujets', route('platform.sujet.list')));
Route::screen('sujets/{sujet}/show', App\Orchid\Screens\Sujet\ShowScreen::class)->name('platform.sujet.show')
    ->breadcrumbs(function (Trail $trail, $sujet) {
        return $trail
            ->parent('platform.sujet.list') 
            ->push('Détail du sujet');
    });
Route::post('sujets/toggleSpotlight', [App\Orchid\Screens\Sujet\ListScreen::class, 'toggleSpotlight'])->name('platform.sujet.toggleSpotlight');
Route::post('sujets/toggleEtat', [App\Orchid\Screens\Sujet\ListScreen::class, 'toggleEtat'])->name('platform.sujet.toggleEtat');
Route::post('sujets/delete', [App\Orchid\Screens\Sujet\ListScreen::class, 'delete'])->name('platform.sujet.delete');

//messageforum//////////////////////
Route::screen('messageforum/{messageforum?}', App\Orchid\Screens\Messageforum\EditScreen::class)->name('platform.messageforum.edit')
    ->breadcrumbs(function (Trail $trail, $messageforum = null) {
        $trail->parent('platform.messageforum.list');
        if ($messageforum && $messageforum->exists) {
            $trail->push('Modifier le message', route('platform.messageforum.edit', $messageforum));
        } else {
            $trail->push('Créer un message', route('platform.messageforum.edit'));
        }
    });
Route::screen('messageforums', App\Orchid\Screens\Messageforum\ListScreen::class)->name('platform.messageforum.list')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.index')
        ->push('Messages des forums', route('platform.messageforum.list')));
Route::screen('messageforums/{messageforum}/show', App\Orchid\Screens\Messageforum\ShowScreen::class)->name('platform.messageforum.show')
    ->breadcrumbs(function (Trail $trail, $messageforum) {
        return $trail
            ->parent('platform.messageforum.list') 
            ->push('Détail du message');
    });
Route::post('messageforums/toggleSpotlight', [App\Orchid\Screens\Messageforum\ListScreen::class, 'toggleSpotlight'])->name('platform.messageforum.toggleSpotlight');
Route::post('messageforums/toggleEtat', [App\Orchid\Screens\Messageforum\ListScreen::class, 'toggleEtat'])->name('platform.messageforum.toggleEtat');
Route::post('messageforums/delete', [App\Orchid\Screens\Messageforum\ListScreen::class, 'delete'])->name('platform.messageforum.delete');

//conversation//////////////////////
Route::screen('conversation/{conversation?}', App\Orchid\Screens\Conversation\EditScreen::class)->name('platform.conversation.edit')
    ->breadcrumbs(function (Trail $trail, $conversation = null) {
        $trail->parent('platform.conversation.list');
        if ($conversation && $conversation->exists) {
            $trail->push('Modifier la conversation', route('platform.conversation.edit', $conversation));
        } else {
            $trail->push('Créer une conversation', route('platform.conversation.edit'));
        }
    });
Route::screen('conversations', App\Orchid\Screens\Conversation\ListScreen::class)->name('platform.conversation.list')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.index')
        ->push('Conversations', route('platform.conversation.list')));
Route::screen('conversations/{conversation}/show', App\Orchid\Screens\Conversation\ShowScreen::class)->name('platform.conversation.show')
    ->breadcrumbs(function (Trail $trail, $conversation) {
        return $trail
            ->parent('platform.conversation.list') 
            ->push('Détail de la conversation');
    });
Route::post('conversations/toggleSpotlight', [App\Orchid\Screens\Conversation\ListScreen::class, 'toggleSpotlight'])->name('platform.conversation.toggleSpotlight');
Route::post('conversations/toggleEtat', [App\Orchid\Screens\Conversation\ListScreen::class, 'toggleEtat'])->name('platform.conversation.toggleEtat');
Route::post('conversations/delete', [App\Orchid\Screens\Conversation\ListScreen::class, 'delete'])->name('platform.conversation.delete');

//message//////////////////////
Route::screen('message/{message?}', App\Orchid\Screens\Message\EditScreen::class)->name('platform.message.edit')
    ->breadcrumbs(function (Trail $trail, $message = null) {
        $trail->parent('platform.message.list');
        if ($message && $message->exists) {
            $trail->push('Modifier le message', route('platform.message.edit', $message));
        } else {
            $trail->push('Créer un message', route('platform.message.edit'));
        }
    });
Route::screen('messages', App\Orchid\Screens\Message\ListScreen::class)->name('platform.message.list')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.index')
        ->push('Messages', route('platform.message.list')));
Route::screen('messages/{message}/show', App\Orchid\Screens\Message\ShowScreen::class)->name('platform.message.show')
    ->breadcrumbs(function (Trail $trail, $message) {
        return $trail
            ->parent('platform.message.list') 
            ->push('Détail du message');
    });
Route::post('messages/toggleLu', [App\Orchid\Screens\Message\ListScreen::class, 'toggleLu'])->name('platform.message.toggleLu');
Route::post('messages/toggleEtat', [App\Orchid\Screens\Message\ListScreen::class, 'toggleEtat'])->name('platform.message.toggleEtat');
Route::post('messages/delete', [App\Orchid\Screens\Message\ListScreen::class, 'delete'])->name('platform.message.delete');

//espace//////////////////////
Route::screen('espace/{espace?}', App\Orchid\Screens\Espace\EditScreen::class)->name('platform.espace.edit')
    ->breadcrumbs(function (Trail $trail, $espace = null) {
        $trail->parent('platform.espace.list');
        if ($espace && $espace->exists) {
            $trail->push('Modifier l\'espace physique', route('platform.espace.edit', $espace));
        } else {
            $trail->push('Créer un espace physique', route('platform.espace.edit'));
        }
    });
Route::screen('espaces', App\Orchid\Screens\Espace\ListScreen::class)->name('platform.espace.list')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.index')
        ->push('Espaces physiques', route('platform.espace.list')));
Route::screen('espaces/{espace}/show', App\Orchid\Screens\Espace\ShowScreen::class)->name('platform.espace.show')
    ->breadcrumbs(function (Trail $trail, $espace) {
        return $trail
            ->parent('platform.espace.list') 
            ->push('Détail de l\'espace physique');
    });
Route::post('espaces/toggleSpotlight', [App\Orchid\Screens\Espace\ListScreen::class, 'toggleSpotlight'])->name('platform.espace.toggleSpotlight');
Route::post('espaces/toggleEtat', [App\Orchid\Screens\Espace\ListScreen::class, 'toggleEtat'])->name('platform.espace.toggleEtat');
Route::post('espaces/delete', [App\Orchid\Screens\Espace\ListScreen::class, 'delete'])->name('platform.espace.delete');

//reservation//////////////////////
Route::screen('reservation/{reservation?}', App\Orchid\Screens\Reservation\EditScreen::class)->name('platform.reservation.edit')
    ->breadcrumbs(function (Trail $trail, $reservation = null) {
        $trail->parent('platform.reservation.list');
        if ($reservation && $reservation->exists) {
            $trail->push('Modifier le conseiller de l\'accompagnement', route('platform.reservation.edit', $reservation));
        } else {
            $trail->push('Créer un conseiller de l\'accompagnement', route('platform.reservation.edit'));
        }
    });
Route::screen('reservations', App\Orchid\Screens\Reservation\ListScreen::class)->name('platform.reservation.list')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.index')
        ->push('Conseillers des accompagnements', route('platform.reservation.list')));
Route::screen('reservations/{reservation}/show', App\Orchid\Screens\Reservation\ShowScreen::class)->name('platform.reservation.show')
    ->breadcrumbs(function (Trail $trail, $reservation) {
        return $trail
            ->parent('platform.reservation.list') 
            ->push('Détail du conseiller de l\'accompagnement');
    });
Route::post('reservations/toggleSpotlight', [App\Orchid\Screens\Reservation\ListScreen::class, 'toggleSpotlight'])->name('platform.reservation.toggleSpotlight');
Route::post('reservations/toggleEtat', [App\Orchid\Screens\Reservation\ListScreen::class, 'toggleEtat'])->name('platform.reservation.toggleEtat');
Route::post('reservations/delete', [App\Orchid\Screens\Reservation\ListScreen::class, 'delete'])->name('platform.reservation.delete');

//accompagnementconseiller//////////////////////
Route::screen('accompagnementconseiller/{accompagnementconseiller?}', App\Orchid\Screens\Accompagnementconseiller\EditScreen::class)->name('platform.accompagnementconseiller.edit')
    ->breadcrumbs(function (Trail $trail, $accompagnementconseiller = null) {
        $trail->parent('platform.accompagnementconseiller.list');
        if ($accompagnementconseiller && $accompagnementconseiller->exists) {
            $trail->push('Modifier la réservation', route('platform.accompagnementconseiller.edit', $accompagnementconseiller));
        } else {
            $trail->push('Créer une réservation', route('platform.accompagnementconseiller.edit'));
        }
    });
Route::screen('accompagnementconseillers', App\Orchid\Screens\Accompagnementconseiller\ListScreen::class)->name('platform.accompagnementconseiller.list')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.index')
        ->push('Réservations', route('platform.accompagnementconseiller.list')));
Route::screen('accompagnementconseillers/{accompagnementconseiller}/show', App\Orchid\Screens\Accompagnementconseiller\ShowScreen::class)->name('platform.accompagnementconseiller.show')
    ->breadcrumbs(function (Trail $trail, $accompagnementconseiller) {
        return $trail
            ->parent('platform.accompagnementconseiller.list') 
            ->push('Détail de la réservation');
    });
Route::post('accompagnementconseillers/toggleSpotlight', [App\Orchid\Screens\Accompagnementconseiller\ListScreen::class, 'toggleSpotlight'])->name('platform.accompagnementconseiller.toggleSpotlight');
Route::post('accompagnementconseillers/toggleEtat', [App\Orchid\Screens\Accompagnementconseiller\ListScreen::class, 'toggleEtat'])->name('platform.accompagnementconseiller.toggleEtat');
Route::post('accompagnementconseillers/delete', [App\Orchid\Screens\Accompagnementconseiller\ListScreen::class, 'delete'])->name('platform.accompagnementconseiller.delete');

//credit//////////////////////
Route::screen('credit/{credit?}', App\Orchid\Screens\Credit\EditScreen::class)->name('platform.credit.edit')
    ->breadcrumbs(function (Trail $trail, $credit = null) {
        $trail->parent('platform.credit.list');
        if ($credit && $credit->exists) {
            $trail->push('Modifier le crédit', route('platform.credit.edit', $credit));
        } else {
            $trail->push('Créer un crédit', route('platform.credit.edit'));
        }
    });
Route::screen('credits', App\Orchid\Screens\Credit\ListScreen::class)->name('platform.credit.list')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.index')
        ->push('Crédits', route('platform.credit.list')));
Route::screen('credits/{credit}/show', App\Orchid\Screens\Credit\ShowScreen::class)->name('platform.credit.show')
    ->breadcrumbs(function (Trail $trail, $credit) {
        return $trail
            ->parent('platform.credit.list') 
            ->push('Détail du crédit');
    });
Route::post('credits/toggleSpotlight', [App\Orchid\Screens\Credit\ListScreen::class, 'toggleSpotlight'])->name('platform.credit.toggleSpotlight');
Route::post('credits/toggleEtat', [App\Orchid\Screens\Credit\ListScreen::class, 'toggleEtat'])->name('platform.credit.toggleEtat');
Route::post('credits/delete', [App\Orchid\Screens\Credit\ListScreen::class, 'delete'])->name('platform.credit.delete');

//echeancier//////////////////////
Route::screen('echeancier/{echeancier?}', App\Orchid\Screens\Echeancier\EditScreen::class)->name('platform.echeancier.edit')
    ->breadcrumbs(function (Trail $trail, $echeancier = null) {
        $trail->parent('platform.echeancier.list');
        if ($echeancier && $echeancier->exists) {
            $trail->push('Modifier l\'échéancier', route('platform.echeancier.edit', $echeancier));
        } else {
            $trail->push('Créer un échéancier', route('platform.echeancier.edit'));
        }
    });
Route::screen('echeanciers', App\Orchid\Screens\Echeancier\ListScreen::class)->name('platform.echeancier.list')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.index')
        ->push('Echéanciers', route('platform.echeancier.list')));
Route::screen('echeanciers/{echeancier}/show', App\Orchid\Screens\Echeancier\ShowScreen::class)->name('platform.echeancier.show')
    ->breadcrumbs(function (Trail $trail, $echeancier) {
        return $trail
            ->parent('platform.echeancier.list') 
            ->push('Détail de l\'échéancier');
    });
Route::post('echeanciers/toggleSpotlight', [App\Orchid\Screens\Echeancier\ListScreen::class, 'toggleSpotlight'])->name('platform.echeancier.toggleSpotlight');
Route::post('echeanciers/toggleEtat', [App\Orchid\Screens\Echeancier\ListScreen::class, 'toggleEtat'])->name('platform.echeancier.toggleEtat');
Route::post('echeanciers/delete', [App\Orchid\Screens\Echeancier\ListScreen::class, 'delete'])->name('platform.echeancier.delete');

//diagnostic//////////////////////
Route::screen('diagnostic/{diagnostic?}', App\Orchid\Screens\Diagnostic\EditScreen::class)->name('platform.diagnostic.edit')
    ->breadcrumbs(function (Trail $trail, $diagnostic = null) {
        $trail->parent('platform.diagnostic.list');
        if ($diagnostic && $diagnostic->exists) {
            $trail->push('Modifier le diagnostic', route('platform.diagnostic.edit', $diagnostic));
        } else {
            $trail->push('Créer un diagnostic', route('platform.diagnostic.edit'));
        }
    });
Route::screen('diagnostics', App\Orchid\Screens\Diagnostic\ListScreen::class)->name('platform.diagnostic.list')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.index')
        ->push('Diagnostics', route('platform.diagnostic.list')));
Route::screen('diagnostics/{diagnostic}/show', App\Orchid\Screens\Diagnostic\ShowScreen::class)->name('platform.diagnostic.show')
    ->breadcrumbs(function (Trail $trail, $diagnostic) {
        return $trail
            ->parent('platform.diagnostic.list') 
            ->push('Détail du diagnostic');
    });
Route::post('diagnostics/toggleSpotlight', [App\Orchid\Screens\Diagnostic\ListScreen::class, 'toggleSpotlight'])->name('platform.diagnostic.toggleSpotlight');
Route::post('diagnostics/toggleEtat', [App\Orchid\Screens\Diagnostic\ListScreen::class, 'toggleEtat'])->name('platform.diagnostic.toggleEtat');
Route::post('diagnostics/delete', [App\Orchid\Screens\Diagnostic\ListScreen::class, 'delete'])->name('platform.diagnostic.delete');

//diagnosticmodule//////////////////////
Route::screen('diagnosticmodule/{diagnosticmodule?}', App\Orchid\Screens\Diagnosticmodule\EditScreen::class)->name('platform.diagnosticmodule.edit')
    ->breadcrumbs(function (Trail $trail, $diagnosticmodule = null) {
        $trail->parent('platform.diagnosticmodule.list');
        if ($diagnosticmodule && $diagnosticmodule->exists) {
            $trail->push('Modifier le module du diagnostic', route('platform.diagnosticmodule.edit', $diagnosticmodule));
        } else {
            $trail->push('Créer un module du diagnostic', route('platform.diagnosticmodule.edit'));
        }
    });
Route::screen('diagnosticmodules', App\Orchid\Screens\Diagnosticmodule\ListScreen::class)->name('platform.diagnosticmodule.list')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.index')
        ->push('Modules des diagnostics', route('platform.diagnosticmodule.list')));
Route::screen('diagnosticmodules/{diagnosticmodule}/show', App\Orchid\Screens\Diagnosticmodule\ShowScreen::class)->name('platform.diagnosticmodule.show')
    ->breadcrumbs(function (Trail $trail, $diagnosticmodule) {
        return $trail
            ->parent('platform.diagnosticmodule.list') 
            ->push('Détail du module du diagnostic');
    });
Route::post('diagnosticmodules/toggleSpotlight', [App\Orchid\Screens\Diagnosticmodule\ListScreen::class, 'toggleSpotlight'])->name('platform.diagnosticmodule.toggleSpotlight');
Route::post('diagnosticmodules/toggleEtat', [App\Orchid\Screens\Diagnosticmodule\ListScreen::class, 'toggleEtat'])->name('platform.diagnosticmodule.toggleEtat');
Route::post('diagnosticmodules/delete', [App\Orchid\Screens\Diagnosticmodule\ListScreen::class, 'delete'])->name('platform.diagnosticmodule.delete');

//diagnosticquestion//////////////////////
Route::screen('diagnosticquestion/{diagnosticquestion?}', App\Orchid\Screens\Diagnosticquestion\EditScreen::class)->name('platform.diagnosticquestion.edit')
    ->breadcrumbs(function (Trail $trail, $diagnosticquestion = null) {
        $trail->parent('platform.diagnosticquestion.list');
        if ($diagnosticquestion && $diagnosticquestion->exists) {
            $trail->push('Modifier la question du diagnostic', route('platform.diagnosticquestion.edit', $diagnosticquestion));
        } else {
            $trail->push('Créer une question du diagnostic', route('platform.diagnosticquestion.edit'));
        }
    });
Route::screen('diagnosticquestions', App\Orchid\Screens\Diagnosticquestion\ListScreen::class)->name('platform.diagnosticquestion.list')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.index')
        ->push('Questions des diagnostics', route('platform.diagnosticquestion.list')));
Route::screen('diagnosticquestions/{diagnosticquestion}/show', App\Orchid\Screens\Diagnosticquestion\ShowScreen::class)->name('platform.diagnosticquestion.show')
    ->breadcrumbs(function (Trail $trail, $diagnosticquestion) {
        return $trail
            ->parent('platform.diagnosticquestion.list') 
            ->push('Détail de la question du diagnostic');
    });
Route::post('diagnosticquestions/toggleObligatoire', [App\Orchid\Screens\Diagnosticquestion\ListScreen::class, 'toggleObligatoire'])->name('platform.diagnosticquestion.toggleObligatoire');
Route::post('diagnosticquestions/toggleSpotlight', [App\Orchid\Screens\Diagnosticquestion\ListScreen::class, 'toggleSpotlight'])->name('platform.diagnosticquestion.toggleSpotlight');
Route::post('diagnosticquestions/toggleEtat', [App\Orchid\Screens\Diagnosticquestion\ListScreen::class, 'toggleEtat'])->name('platform.diagnosticquestion.toggleEtat');
Route::post('diagnosticquestions/delete', [App\Orchid\Screens\Diagnosticquestion\ListScreen::class, 'delete'])->name('platform.diagnosticquestion.delete');

//diagnosticreponse//////////////////////
Route::screen('diagnosticreponse/{diagnosticreponse?}', App\Orchid\Screens\Diagnosticreponse\EditScreen::class)->name('platform.diagnosticreponse.edit')
    ->breadcrumbs(function (Trail $trail, $diagnosticreponse = null) {
        $trail->parent('platform.diagnosticreponse.list');
        if ($diagnosticreponse && $diagnosticreponse->exists) {
            $trail->push('Modifier la réponse du diagnostic', route('platform.diagnosticreponse.edit', $diagnosticreponse));
        } else {
            $trail->push('Créer une réponse du diagnostic', route('platform.diagnosticreponse.edit'));
        }
    });
Route::screen('diagnosticreponses', App\Orchid\Screens\Diagnosticreponse\ListScreen::class)->name('platform.diagnosticreponse.list')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.index')
        ->push('Réponses des diagnostics', route('platform.diagnosticreponse.list')));
Route::screen('diagnosticreponses/{diagnosticreponse}/show', App\Orchid\Screens\Diagnosticreponse\ShowScreen::class)->name('platform.diagnosticreponse.show')
    ->breadcrumbs(function (Trail $trail, $diagnosticreponse) {
        return $trail
            ->parent('platform.diagnosticreponse.list') 
            ->push('Détail de la réponse du diagnostic');
    });
Route::post('diagnosticreponses/toggleSpotlight', [App\Orchid\Screens\Diagnosticreponse\ListScreen::class, 'toggleSpotlight'])->name('platform.diagnosticreponse.toggleSpotlight');
Route::post('diagnosticreponses/toggleEtat', [App\Orchid\Screens\Diagnosticreponse\ListScreen::class, 'toggleEtat'])->name('platform.diagnosticreponse.toggleEtat');
Route::post('diagnosticreponses/delete', [App\Orchid\Screens\Diagnosticreponse\ListScreen::class, 'delete'])->name('platform.diagnosticreponse.delete');

//diagnosticresultat//////////////////////
Route::screen('diagnosticresultat/{diagnosticresultat?}', App\Orchid\Screens\Diagnosticresultat\EditScreen::class)->name('platform.diagnosticresultat.edit')
    ->breadcrumbs(function (Trail $trail, $diagnosticresultat = null) {
        $trail->parent('platform.diagnosticresultat.list');
        if ($diagnosticresultat && $diagnosticresultat->exists) {
            $trail->push('Modifier le résultat du diagnostic', route('platform.diagnosticresultat.edit', $diagnosticresultat));
        } else {
            $trail->push('Créer un résultat du diagnostic', route('platform.diagnosticresultat.edit'));
        }
    });
Route::screen('diagnosticresultats', App\Orchid\Screens\Diagnosticresultat\ListScreen::class)->name('platform.diagnosticresultat.list')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.index')
        ->push('Résultats des diagnostics', route('platform.diagnosticresultat.list')));
Route::screen('diagnosticresultats/{diagnosticresultat}/show', App\Orchid\Screens\Diagnosticresultat\ShowScreen::class)->name('platform.diagnosticresultat.show')
    ->breadcrumbs(function (Trail $trail, $diagnosticresultat) {
        return $trail
            ->parent('platform.diagnosticresultat.list') 
            ->push('Détail du résultat du diagnostic');
    });
Route::post('diagnosticresultats/toggleSpotlight', [App\Orchid\Screens\Diagnosticresultat\ListScreen::class, 'toggleSpotlight'])->name('platform.diagnosticresultat.toggleSpotlight');
Route::post('diagnosticresultats/toggleEtat', [App\Orchid\Screens\Diagnosticresultat\ListScreen::class, 'toggleEtat'])->name('platform.diagnosticresultat.toggleEtat');
Route::post('diagnosticresultats/delete', [App\Orchid\Screens\Diagnosticresultat\ListScreen::class, 'delete'])->name('platform.diagnosticresultat.delete');

//conseillerentreprise//////////////////////
Route::screen('conseillerentreprise/{conseillerentreprise?}', App\Orchid\Screens\Conseillerentreprise\EditScreen::class)->name('platform.conseillerentreprise.edit')
    ->breadcrumbs(function (Trail $trail, $conseillerentreprise = null) {
        $trail->parent('platform.conseillerentreprise.list');
        if ($conseillerentreprise && $conseillerentreprise->exists) {
            $trail->push('Modifier l\'attribution de conseiller', route('platform.conseillerentreprise.edit', $conseillerentreprise));
        } else {
            $trail->push('Créer une attribution de conseiller', route('platform.conseillerentreprise.edit'));
        }
    });
Route::screen('conseillerentreprises', App\Orchid\Screens\Conseillerentreprise\ListScreen::class)->name('platform.conseillerentreprise.list')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.index')
        ->push('Attribution de conseillers', route('platform.conseillerentreprise.list')));
Route::screen('conseillerentreprises/{conseillerentreprise}/show', App\Orchid\Screens\Conseillerentreprise\ShowScreen::class)->name('platform.conseillerentreprise.show')
    ->breadcrumbs(function (Trail $trail, $conseillerentreprise) {
        return $trail
            ->parent('platform.conseillerentreprise.list') 
            ->push('Détail de l\'attribution de conseiller');
    });
Route::post('conseillerentreprises/toggleSpotlight', [App\Orchid\Screens\Conseillerentreprise\ListScreen::class, 'toggleSpotlight'])->name('platform.conseillerentreprise.toggleSpotlight');
Route::post('conseillerentreprises/toggleEtat', [App\Orchid\Screens\Conseillerentreprise\ListScreen::class, 'toggleEtat'])->name('platform.conseillerentreprise.toggleEtat');
Route::post('conseillerentreprises/delete', [App\Orchid\Screens\Conseillerentreprise\ListScreen::class, 'delete'])->name('platform.conseillerentreprise.delete');

//conseillerprescription//////////////////////
Route::screen('conseillerprescription/{conseillerprescription?}', App\Orchid\Screens\Conseillerprescription\EditScreen::class)->name('platform.conseillerprescription.edit')
    ->breadcrumbs(function (Trail $trail, $conseillerprescription = null) {
        $trail->parent('platform.conseillerprescription.list');
        if ($conseillerprescription && $conseillerprescription->exists) {
            $trail->push('Modifier la prescription du conseiller', route('platform.conseillerprescription.edit', $conseillerprescription));
        } else {
            $trail->push('Créer une prescription du conseiller', route('platform.conseillerprescription.edit'));
        }
    });
Route::screen('conseillerprescriptions', App\Orchid\Screens\Conseillerprescription\ListScreen::class)->name('platform.conseillerprescription.list')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.index')
        ->push('Prescriptions des conseillers', route('platform.conseillerprescription.list')));
Route::screen('conseillerprescriptions/{conseillerprescription}/show', App\Orchid\Screens\Conseillerprescription\ShowScreen::class)->name('platform.conseillerprescription.show')
    ->breadcrumbs(function (Trail $trail, $conseillerprescription) {
        return $trail
            ->parent('platform.conseillerprescription.list') 
            ->push('Détail de la prescription du conseiller');
    });
Route::post('conseillerprescriptions/toggleSpotlight', [App\Orchid\Screens\Conseillerprescription\ListScreen::class, 'toggleSpotlight'])->name('platform.conseillerprescription.toggleSpotlight');
Route::post('conseillerprescriptions/toggleEtat', [App\Orchid\Screens\Conseillerprescription\ListScreen::class, 'toggleEtat'])->name('platform.conseillerprescription.toggleEtat');
Route::post('conseillerprescriptions/delete', [App\Orchid\Screens\Conseillerprescription\ListScreen::class, 'delete'])->name('platform.conseillerprescription.delete');

//ressourcecompte//////////////////////
Route::screen('ressourcecompte/{ressourcecompte?}', App\Orchid\Screens\Ressourcecompte\EditScreen::class)->name('platform.ressourcecompte.edit')
    ->breadcrumbs(function (Trail $trail, $ressourcecompte = null) {
        $trail->parent('platform.ressourcecompte.list');
        if ($ressourcecompte && $ressourcecompte->exists) {
            $trail->push('Modifier la ressource', route('platform.ressourcecompte.edit', $ressourcecompte));
        } else {
            $trail->push('Créer une ressource', route('platform.ressourcecompte.edit'));
        }
    });
Route::screen('ressourcecomptes', App\Orchid\Screens\Ressourcecompte\ListScreen::class)->name('platform.ressourcecompte.list')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.index')
        ->push('Ressources', route('platform.ressourcecompte.list')));
Route::screen('ressourcecomptes/{ressourcecompte}/show', App\Orchid\Screens\Ressourcecompte\ShowScreen::class)->name('platform.ressourcecompte.show')
    ->breadcrumbs(function (Trail $trail, $ressourcecompte) {
        return $trail
            ->parent('platform.ressourcecompte.list') 
            ->push('Détail de la ressource');
    });
Route::post('ressourcecomptes/toggleSpotlight', [App\Orchid\Screens\Ressourcecompte\ListScreen::class, 'toggleSpotlight'])->name('platform.ressourcecompte.toggleSpotlight');
Route::post('ressourcecomptes/toggleEtat', [App\Orchid\Screens\Ressourcecompte\ListScreen::class, 'toggleEtat'])->name('platform.ressourcecompte.toggleEtat');
Route::post('ressourcecomptes/delete', [App\Orchid\Screens\Ressourcecompte\ListScreen::class, 'delete'])->name('platform.ressourcecompte.delete');

//ressourcetransaction//////////////////////
Route::screen('ressourcetransaction/{ressourcetransaction?}', App\Orchid\Screens\Ressourcetransaction\EditScreen::class)->name('platform.ressourcetransaction.edit')
    ->breadcrumbs(function (Trail $trail, $ressourcetransaction = null) {
        $trail->parent('platform.ressourcetransaction.list');
        if ($ressourcetransaction && $ressourcetransaction->exists) {
            $trail->push('Modifier la transaction', route('platform.ressourcetransaction.edit', $ressourcetransaction));
        } else {
            $trail->push('Créer une transaction', route('platform.ressourcetransaction.edit'));
        }
    });
Route::screen('ressourcetransactions', App\Orchid\Screens\Ressourcetransaction\ListScreen::class)->name('platform.ressourcetransaction.list')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.index')
        ->push('Transactions des ressources', route('platform.ressourcetransaction.list')));
Route::screen('ressourcetransactions/{ressourcetransaction}/show', App\Orchid\Screens\Ressourcetransaction\ShowScreen::class)->name('platform.ressourcetransaction.show')
    ->breadcrumbs(function (Trail $trail, $ressourcetransaction) {
        return $trail
            ->parent('platform.ressourcetransaction.list') 
            ->push('Détail de la transaction');
    });
Route::post('ressourcetransactions/toggleSpotlight', [App\Orchid\Screens\Ressourcetransaction\ListScreen::class, 'toggleSpotlight'])->name('platform.ressourcetransaction.toggleSpotlight');
Route::post('ressourcetransactions/toggleEtat', [App\Orchid\Screens\Ressourcetransaction\ListScreen::class, 'toggleEtat'])->name('platform.ressourcetransaction.toggleEtat');
Route::post('ressourcetransactions/delete', [App\Orchid\Screens\Ressourcetransaction\ListScreen::class, 'delete'])->name('platform.ressourcetransaction.delete');

//parrainage//////////////////////
Route::screen('parrainage/{parrainage?}', App\Orchid\Screens\Parrainage\EditScreen::class)->name('platform.parrainage.edit')
    ->breadcrumbs(function (Trail $trail, $parrainage = null) {
        $trail->parent('platform.parrainage.list');
        if ($parrainage && $parrainage->exists) {
            $trail->push('Modifier le parrainage', route('platform.parrainage.edit', $parrainage));
        } else {
            $trail->push('Créer un parrainage', route('platform.parrainage.edit'));
        }
    });
Route::screen('parrainages', App\Orchid\Screens\Parrainage\ListScreen::class)->name('platform.parrainage.list')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.index')
        ->push('Parrainage', route('platform.parrainage.list')));
Route::screen('parrainages/{parrainage}/show', App\Orchid\Screens\Parrainage\ShowScreen::class)->name('platform.parrainage.show')
    ->breadcrumbs(function (Trail $trail, $parrainage) {
        return $trail
            ->parent('platform.parrainage.list') 
            ->push('Détail du parrainage');
    });
Route::post('parrainages/toggleSpotlight', [App\Orchid\Screens\Parrainage\ListScreen::class, 'toggleSpotlight'])->name('platform.parrainage.toggleSpotlight');
Route::post('parrainages/toggleEtat', [App\Orchid\Screens\Parrainage\ListScreen::class, 'toggleEtat'])->name('platform.parrainage.toggleEtat');
Route::post('parrainages/delete', [App\Orchid\Screens\Parrainage\ListScreen::class, 'delete'])->name('platform.parrainage.delete');

//conversion//////////////////////
Route::screen('conversion/{conversion?}', App\Orchid\Screens\Conversion\EditScreen::class)->name('platform.conversion.edit')
    ->breadcrumbs(function (Trail $trail, $conversion = null) {
        $trail->parent('platform.conversion.list');
        if ($conversion && $conversion->exists) {
            $trail->push('Modifier la conversion', route('platform.conversion.edit', $conversion));
        } else {
            $trail->push('Créer une conversion', route('platform.conversion.edit'));
        }
    });
Route::screen('conversions', App\Orchid\Screens\Conversion\ListScreen::class)->name('platform.conversion.list')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.index')
        ->push('Conversion', route('platform.conversion.list')));
Route::screen('conversions/{conversion}/show', App\Orchid\Screens\Conversion\ShowScreen::class)->name('platform.conversion.show')
    ->breadcrumbs(function (Trail $trail, $conversion) {
        return $trail
            ->parent('platform.conversion.list') 
            ->push('Détail de la conversion');
    });
Route::post('conversions/toggleSpotlight', [App\Orchid\Screens\Conversion\ListScreen::class, 'toggleSpotlight'])->name('platform.conversion.toggleSpotlight');
Route::post('conversions/toggleEtat', [App\Orchid\Screens\Conversion\ListScreen::class, 'toggleEtat'])->name('platform.conversion.toggleEtat');
Route::post('conversions/delete', [App\Orchid\Screens\Conversion\ListScreen::class, 'delete'])->name('platform.conversion.delete');

//prestationressource//////////////////////
Route::screen('prestationressource/{prestationressource?}', App\Orchid\Screens\Prestationressource\EditScreen::class)->name('platform.prestationressource.edit')
    ->breadcrumbs(function (Trail $trail, $prestationressource = null) {
        $trail->parent('platform.prestationressource.list');
        if ($prestationressource && $prestationressource->exists) {
            $trail->push('Modifier le paiement de la prestation', route('platform.prestationressource.edit', $prestationressource));
        } else {
            $trail->push('Créer un paiement de la prestation', route('platform.prestationressource.edit'));
        }
    });
Route::screen('prestationressources', App\Orchid\Screens\Prestationressource\ListScreen::class)->name('platform.prestationressource.list')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.index')
        ->push('Paiements des prestations', route('platform.prestationressource.list')));
Route::screen('prestationressources/{prestationressource}/show', App\Orchid\Screens\Prestationressource\ShowScreen::class)->name('platform.prestationressource.show')
    ->breadcrumbs(function (Trail $trail, $prestationressource) {
        return $trail
            ->parent('platform.prestationressource.list') 
            ->push('Détail du paiement de la prestation');
    });
Route::post('prestationressources/toggleSpotlight', [App\Orchid\Screens\Prestationressource\ListScreen::class, 'toggleSpotlight'])->name('platform.prestationressource.toggleSpotlight');
Route::post('prestationressources/toggleEtat', [App\Orchid\Screens\Prestationressource\ListScreen::class, 'toggleEtat'])->name('platform.prestationressource.toggleEtat');
Route::post('prestationressources/delete', [App\Orchid\Screens\Prestationressource\ListScreen::class, 'delete'])->name('platform.prestationressource.delete');

//formationressource//////////////////////
Route::screen('formationressource/{formationressource?}', App\Orchid\Screens\Formationressource\EditScreen::class)->name('platform.formationressource.edit')
    ->breadcrumbs(function (Trail $trail, $formationressource = null) {
        $trail->parent('platform.formationressource.list');
        if ($formationressource && $formationressource->exists) {
            $trail->push('Modifier le paiement de la formation', route('platform.formationressource.edit', $formationressource));
        } else {
            $trail->push('Créer un paiement de la formation', route('platform.formationressource.edit'));
        }
    });
Route::screen('formationressources', App\Orchid\Screens\Formationressource\ListScreen::class)->name('platform.formationressource.list')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.index')
        ->push('Paiements des formations', route('platform.formationressource.list')));
Route::screen('formationressources/{formationressource}/show', App\Orchid\Screens\Formationressource\ShowScreen::class)->name('platform.formationressource.show')
    ->breadcrumbs(function (Trail $trail, $formationressource) {
        return $trail
            ->parent('platform.formationressource.list') 
            ->push('Détail du paiement de la formation');
    });
Route::post('formationressources/toggleSpotlight', [App\Orchid\Screens\Formationressource\ListScreen::class, 'toggleSpotlight'])->name('platform.formationressource.toggleSpotlight');
Route::post('formationressources/toggleEtat', [App\Orchid\Screens\Formationressource\ListScreen::class, 'toggleEtat'])->name('platform.formationressource.toggleEtat');
Route::post('formationressources/delete', [App\Orchid\Screens\Formationressource\ListScreen::class, 'delete'])->name('platform.formationressource.delete');

//espaceressource//////////////////////
Route::screen('espaceressource/{espaceressource?}', App\Orchid\Screens\Espaceressource\EditScreen::class)->name('platform.espaceressource.edit')
    ->breadcrumbs(function (Trail $trail, $espaceressource = null) {
        $trail->parent('platform.espaceressource.list');
        if ($espaceressource && $espaceressource->exists) {
            $trail->push('Modifier le paiement de l\'espace', route('platform.espaceressource.edit', $espaceressource));
        } else {
            $trail->push('Créer un paiement de l\'espace', route('platform.espaceressource.edit'));
        }
    });
Route::screen('espaceressources', App\Orchid\Screens\Espaceressource\ListScreen::class)->name('platform.espaceressource.list')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.index')
        ->push('Paiements des espaces', route('platform.espaceressource.list')));
Route::screen('espaceressources/{espaceressource}/show', App\Orchid\Screens\Espaceressource\ShowScreen::class)->name('platform.espaceressource.show')
    ->breadcrumbs(function (Trail $trail, $espaceressource) {
        return $trail
            ->parent('platform.espaceressource.list') 
            ->push('Détail du paiement de l\'espace');
    });
Route::post('espaceressources/toggleSpotlight', [App\Orchid\Screens\Espaceressource\ListScreen::class, 'toggleSpotlight'])->name('platform.espaceressource.toggleSpotlight');
Route::post('espaceressources/toggleEtat', [App\Orchid\Screens\Espaceressource\ListScreen::class, 'toggleEtat'])->name('platform.espaceressource.toggleEtat');
Route::post('espaceressources/delete', [App\Orchid\Screens\Espaceressource\ListScreen::class, 'delete'])->name('platform.espaceressource.delete');

//evenementressource//////////////////////
Route::screen('evenementressource/{evenementressource?}', App\Orchid\Screens\Evenementressource\EditScreen::class)->name('platform.evenementressource.edit')
    ->breadcrumbs(function (Trail $trail, $evenementressource = null) {
        $trail->parent('platform.evenementressource.list');
        if ($evenementressource && $evenementressource->exists) {
            $trail->push('Modifier le paiement de l\'évènement', route('platform.evenementressource.edit', $evenementressource));
        } else {
            $trail->push('Créer un paiement de l\'évènement', route('platform.evenementressource.edit'));
        }
    });
Route::screen('evenementressources', App\Orchid\Screens\Evenementressource\ListScreen::class)->name('platform.evenementressource.list')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.index')
        ->push('Paiements des évènements', route('platform.evenementressource.list')));
Route::screen('evenementressources/{evenementressource}/show', App\Orchid\Screens\Evenementressource\ShowScreen::class)->name('platform.evenementressource.show')
    ->breadcrumbs(function (Trail $trail, $evenementressource) {
        return $trail
            ->parent('platform.evenementressource.list') 
            ->push('Détail du paiement de l\'évènement');
    });
Route::post('evenementressources/toggleSpotlight', [App\Orchid\Screens\Evenementressource\ListScreen::class, 'toggleSpotlight'])->name('platform.evenementressource.toggleSpotlight');
Route::post('evenementressources/toggleEtat', [App\Orchid\Screens\Evenementressource\ListScreen::class, 'toggleEtat'])->name('platform.evenementressource.toggleEtat');
Route::post('evenementressources/delete', [App\Orchid\Screens\Evenementressource\ListScreen::class, 'delete'])->name('platform.evenementressource.delete');

//newsletter//////////////////////
Route::screen('newsletter/{newsletter?}', App\Orchid\Screens\Newsletter\EditScreen::class)->name('platform.newsletter.edit')
    ->breadcrumbs(function (Trail $trail, $newsletter = null) {
        $trail->parent('platform.newsletter.list');
        if ($newsletter && $newsletter->exists) {
            $trail->push('Modifier la newsletter', route('platform.newsletter.edit', $newsletter));
        } else {
            $trail->push('Créer une newsletter', route('platform.newsletter.edit'));
        }
    });
Route::screen('newsletters', App\Orchid\Screens\Newsletter\ListScreen::class)->name('platform.newsletter.list')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.index')
        ->push('Newsletters', route('platform.newsletter.list')));
Route::screen('newsletters/{newsletter}/show', App\Orchid\Screens\Newsletter\ShowScreen::class)->name('platform.newsletter.show')
    ->breadcrumbs(function (Trail $trail, $newsletter) {
        return $trail
            ->parent('platform.newsletter.list') 
            ->push('Détail de la newsletter');
    });
Route::post('newsletters/toggleSpotlight', [App\Orchid\Screens\Newsletter\ListScreen::class, 'toggleSpotlight'])->name('platform.newsletter.toggleSpotlight');
Route::post('newsletters/toggleEtat', [App\Orchid\Screens\Newsletter\ListScreen::class, 'toggleEtat'])->name('platform.newsletter.toggleEtat');
Route::post('newsletters/delete', [App\Orchid\Screens\Newsletter\ListScreen::class, 'delete'])->name('platform.newsletter.delete');

//quiz//////////////////////
Route::screen('quiz/{quiz?}', App\Orchid\Screens\Quiz\EditScreen::class)->name('platform.quiz.edit')
    ->breadcrumbs(function (Trail $trail, $quiz = null) {
        $trail->parent('platform.quiz.list');
        if ($quiz && $quiz->exists) {
            $trail->push('Modifier le quiz', route('platform.quiz.edit', $quiz));
        } else {
            $trail->push('Créer un quiz', route('platform.quiz.edit'));
        }
    });
Route::screen('quizs', App\Orchid\Screens\Quiz\ListScreen::class)->name('platform.quiz.list')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.index')
        ->push('Quiz', route('platform.quiz.list')));
Route::screen('quizs/{quiz}/show', App\Orchid\Screens\Quiz\ShowScreen::class)->name('platform.quiz.show')
    ->breadcrumbs(function (Trail $trail, $quiz) {
        return $trail
            ->parent('platform.quiz.list') 
            ->push('Détail du quiz');
    });
Route::post('quizs/toggleSpotlight', [App\Orchid\Screens\Quiz\ListScreen::class, 'toggleSpotlight'])->name('platform.quiz.toggleSpotlight');
Route::post('quizs/toggleEtat', [App\Orchid\Screens\Quiz\ListScreen::class, 'toggleEtat'])->name('platform.quiz.toggleEtat');
Route::post('quizs/delete', [App\Orchid\Screens\Quiz\ListScreen::class, 'delete'])->name('platform.quiz.delete');

//quizquestion//////////////////////
Route::screen('quizquestion/{quizquestion?}', App\Orchid\Screens\Quizquestion\EditScreen::class)->name('platform.quizquestion.edit')
    ->breadcrumbs(function (Trail $trail, $quizquestion = null) {
        $trail->parent('platform.quizquestion.list');
        if ($quizquestion && $quizquestion->exists) {
            $trail->push('Modifier la question du quiz', route('platform.quizquestion.edit', $quizquestion));
        } else {
            $trail->push('Créer une question du quiz', route('platform.quizquestion.edit'));
        }
    });
Route::screen('quizquestions', App\Orchid\Screens\Quizquestion\ListScreen::class)->name('platform.quizquestion.list')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.index')
        ->push('Questions du quiz', route('platform.quizquestion.list')));
Route::screen('quizquestions/{quizquestion}/show', App\Orchid\Screens\Quizquestion\ShowScreen::class)->name('platform.quizquestion.show')
    ->breadcrumbs(function (Trail $trail, $quizquestion) {
        return $trail
            ->parent('platform.quizquestion.list') 
            ->push('Détail de la question du quiz');
    });
Route::post('quizquestions/toggleSpotlight', [App\Orchid\Screens\Quizquestion\ListScreen::class, 'toggleSpotlight'])->name('platform.quizquestion.toggleSpotlight');
Route::post('quizquestions/toggleEtat', [App\Orchid\Screens\Quizquestion\ListScreen::class, 'toggleEtat'])->name('platform.quizquestion.toggleEtat');
Route::post('quizquestions/delete', [App\Orchid\Screens\Quizquestion\ListScreen::class, 'delete'])->name('platform.quizquestion.delete');

//quizreponse//////////////////////
Route::screen('quizreponse/{quizreponse?}', App\Orchid\Screens\Quizreponse\EditScreen::class)->name('platform.quizreponse.edit')
    ->breadcrumbs(function (Trail $trail, $quizreponse = null) {
        $trail->parent('platform.quizreponse.list');
        if ($quizreponse && $quizreponse->exists) {
            $trail->push('Modifier la reponse du quiz', route('platform.quizreponse.edit', $quizreponse));
        } else {
            $trail->push('Créer une reponse du quiz', route('platform.quizreponse.edit'));
        }
    });
Route::screen('quizreponses', App\Orchid\Screens\Quizreponse\ListScreen::class)->name('platform.quizreponse.list')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.index')
        ->push('Reponses du quiz', route('platform.quizreponse.list')));
Route::screen('quizreponses/{quizreponse}/show', App\Orchid\Screens\Quizreponse\ShowScreen::class)->name('platform.quizreponse.show')
    ->breadcrumbs(function (Trail $trail, $quizreponse) {
        return $trail
            ->parent('platform.quizreponse.list') 
            ->push('Détail de la reponse du quiz');
    });
Route::post('quizreponses/toggleSpotlight', [App\Orchid\Screens\Quizreponse\ListScreen::class, 'toggleSpotlight'])->name('platform.quizreponse.toggleSpotlight');
Route::post('quizreponses/toggleEtat', [App\Orchid\Screens\Quizreponse\ListScreen::class, 'toggleEtat'])->name('platform.quizreponse.toggleEtat');
Route::post('quizreponses/delete', [App\Orchid\Screens\Quizreponse\ListScreen::class, 'delete'])->name('platform.quizreponse.delete');
Route::post('quizreponses/toggleCorrecte', [App\Orchid\Screens\Quizreponse\ListScreen::class, 'toggleCorrecte'])->name('platform.quizreponse.toggleCorrecte');

//quizmembre//////////////////////
Route::screen('quizmembre/{quizmembre?}', App\Orchid\Screens\Quizmembre\EditScreen::class)->name('platform.quizmembre.edit')
    ->breadcrumbs(function (Trail $trail, $quizmembre = null) {
        $trail->parent('platform.quizmembre.list');
        if ($quizmembre && $quizmembre->exists) {
            $trail->push('Modifier le resultat du membre du quiz', route('platform.quizmembre.edit', $quizmembre));
        } else {
            $trail->push('Créer un resultat du membre du quiz', route('platform.quizmembre.edit'));
        }
    });
Route::screen('quizmembres', App\Orchid\Screens\Quizmembre\ListScreen::class)->name('platform.quizmembre.list')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.index')
        ->push('Membres du quiz', route('platform.quizmembre.list')));
Route::screen('quizmembres/{quizmembre}/show', App\Orchid\Screens\Quizmembre\ShowScreen::class)->name('platform.quizmembre.show')
    ->breadcrumbs(function (Trail $trail, $quizmembre) {
        return $trail
            ->parent('platform.quizmembre.list') 
            ->push('Détail du resultat du membre du quiz');
    });
Route::post('quizmembres/toggleSpotlight', [App\Orchid\Screens\Quizmembre\ListScreen::class, 'toggleSpotlight'])->name('platform.quizmembre.toggleSpotlight');
Route::post('quizmembres/toggleEtat', [App\Orchid\Screens\Quizmembre\ListScreen::class, 'toggleEtat'])->name('platform.quizmembre.toggleEtat');
Route::post('quizmembres/delete', [App\Orchid\Screens\Quizmembre\ListScreen::class, 'delete'])->name('platform.quizmembre.delete');

//quizresultat//////////////////////
Route::screen('quizresultat/{quizresultat?}', App\Orchid\Screens\Quizresultat\EditScreen::class)->name('platform.quizresultat.edit')
    ->breadcrumbs(function (Trail $trail, $quizresultat = null) {
        $trail->parent('platform.quizresultat.list');
        if ($quizresultat && $quizresultat->exists) {
            $trail->push('Modifier le resultat du quiz', route('platform.quizresultat.edit', $quizresultat));
        } else {
            $trail->push('Créer un resultat du quiz', route('platform.quizresultat.edit'));
        }
    });
Route::screen('quizresultats', App\Orchid\Screens\Quizresultat\ListScreen::class)->name('platform.quizresultat.list')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.index')
        ->push('Résultats du quiz', route('platform.quizresultat.list')));
Route::screen('quizresultats/{quizresultat}/show', App\Orchid\Screens\Quizresultat\ShowScreen::class)->name('platform.quizresultat.show')
    ->breadcrumbs(function (Trail $trail, $quizresultat) {
        return $trail
            ->parent('platform.quizresultat.list') 
            ->push('Détail du resultat du quiz');
    });
Route::post('quizresultats/toggleSpotlight', [App\Orchid\Screens\Quizresultat\ListScreen::class, 'toggleSpotlight'])->name('platform.quizresultat.toggleSpotlight');
Route::post('quizresultats/toggleEtat', [App\Orchid\Screens\Quizresultat\ListScreen::class, 'toggleEtat'])->name('platform.quizresultat.toggleEtat');
Route::post('quizresultats/delete', [App\Orchid\Screens\Quizresultat\ListScreen::class, 'delete'])->name('platform.quizresultat.delete');

//action//////////////////////
Route::screen('action/{action?}', App\Orchid\Screens\Action\EditScreen::class)->name('platform.action.edit')
    ->breadcrumbs(function (Trail $trail, $action = null) {
        $trail->parent('platform.action.list');
        if ($action && $action->exists) {
            $trail->push('Modifier l\'action', route('platform.action.edit', $action));
        } else {
            $trail->push('Créer une action', route('platform.action.edit'));
        }
    });
Route::screen('actions', App\Orchid\Screens\Action\ListScreen::class)->name('platform.action.list')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.index')
        ->push('Actions', route('platform.action.list')));
Route::screen('actions/{action}/show', App\Orchid\Screens\Action\ShowScreen::class)->name('platform.action.show')
    ->breadcrumbs(function (Trail $trail, $action) {
        return $trail
            ->parent('platform.action.list') 
            ->push('Détail de l\'action');
    });
Route::post('actions/toggleSpotlight', [App\Orchid\Screens\Action\ListScreen::class, 'toggleSpotlight'])->name('platform.action.toggleSpotlight');
Route::post('actions/toggleEtat', [App\Orchid\Screens\Action\ListScreen::class, 'toggleEtat'])->name('platform.action.toggleEtat');
Route::post('actions/delete', [App\Orchid\Screens\Action\ListScreen::class, 'delete'])->name('platform.action.delete');

//recompense//////////////////////
Route::screen('recompense/{recompense?}', App\Orchid\Screens\Recompense\EditScreen::class)->name('platform.recompense.edit')
    ->breadcrumbs(function (Trail $trail, $recompense = null) {
        $trail->parent('platform.recompense.list');
        if ($recompense && $recompense->exists) {
            $trail->push('Modifier la récompense', route('platform.recompense.edit', $recompense));
        } else {
            $trail->push('Créer une récompense', route('platform.recompense.edit'));
        }
    });
Route::screen('recompenses', App\Orchid\Screens\Recompense\ListScreen::class)->name('platform.recompense.list')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.index')
        ->push('Récompenses', route('platform.recompense.list')));
Route::screen('recompenses/{recompense}/show', App\Orchid\Screens\Recompense\ShowScreen::class)->name('platform.recompense.show')
    ->breadcrumbs(function (Trail $trail, $recompense) {
        return $trail
            ->parent('platform.recompense.list') 
            ->push('Détail de la récompense');
    });
Route::post('recompenses/toggleSpotlight', [App\Orchid\Screens\Recompense\ListScreen::class, 'toggleSpotlight'])->name('platform.recompense.toggleSpotlight');
Route::post('recompenses/toggleEtat', [App\Orchid\Screens\Recompense\ListScreen::class, 'toggleEtat'])->name('platform.recompense.toggleEtat');
Route::post('recompenses/delete', [App\Orchid\Screens\Recompense\ListScreen::class, 'delete'])->name('platform.recompense.delete');







