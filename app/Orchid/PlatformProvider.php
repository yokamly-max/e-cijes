<?php

declare(strict_types=1);

namespace App\Orchid;

use Orchid\Platform\Dashboard;
use Orchid\Platform\ItemPermission;
use Orchid\Platform\OrchidServiceProvider;
use Orchid\Screen\Actions\Menu;
use Orchid\Support\Color;

class PlatformProvider extends OrchidServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @param Dashboard $dashboard
     *
     * @return void
     */
    public function boot(Dashboard $dashboard): void
    {
        parent::boot($dashboard);

        // ...
    }

    /**
     * Register the application menu.
     *
     * @return Menu[]
     */
    public function menu(): array
    {
        return [
            /*Menu::make('Get Started')
                ->icon('bs.book')
                ->title('Navigation')
                ->route(config('platform.index')),

            Menu::make('Sample Screen')
                ->icon('bs.collection')
                ->route('platform.example')
                ->badge(fn () => 6),

            Menu::make('Form Elements')
                ->icon('bs.card-list')
                ->route('platform.example.fields')
                ->active('examples/form'),

            Menu::make('Layouts Overview')
                ->icon('bs.window-sidebar')
                ->route('platform.example.layouts'),

            Menu::make('Grid System')
                ->icon('bs.columns-gap')
                ->route('platform.example.grid'),

            Menu::make('Charts')
                ->icon('bs.bar-chart')
                ->route('platform.example.charts'),

            Menu::make('Cards')
                ->icon('bs.card-text')
                ->route('platform.example.cards')
                ->divider(),*/

            Menu::make(__('Users'))
                ->icon('bs.people')
                ->route('platform.systems.users')
                ->permission('platform.systems.users')
                ->title(__('Access Controls')),

            Menu::make(__('Roles'))
                ->icon('bs.shield')
                ->route('platform.systems.roles')
                ->permission('platform.systems.roles')
                ->divider(),

            /*Menu::make('Documentation')
                ->title('Docs')
                ->icon('bs.box-arrow-up-right')
                ->url('https://orchid.software/en/docs')
                ->target('_blank'),

            Menu::make('Changelog')
                ->icon('bs.box-arrow-up-right')
                ->url('https://github.com/orchidsoftware/platform/blob/master/CHANGELOG.md')
                ->target('_blank')
                ->badge(fn () => Dashboard::version(), Color::DARK),*/


            Menu::make('Décentralisation')
                ->icon('bs.bag')
                ->list([
        Menu::make('Pays')->route('platform.pays.list'),
        Menu::make('Régions')->route('platform.region.list'),
        Menu::make('Préfectures')->route('platform.prefecture.list'),
        Menu::make('Communes')->route('platform.commune.list'),
        Menu::make('Quartiers')->route('platform.quartier.list'),
                ]),

            Menu::make('Modules du site')
                ->icon('bs.bag')
                ->list([
        Menu::make('Pages de présentation')->route('platform.pagelibre.list'),
        Menu::make('Actualités')->route('platform.actualite.list'),
        Menu::make('Évènements')->route('platform.evenement.list'),
        Menu::make('Paiements des évènements')->route('platform.evenementressource.list'),
        Menu::make('Inscription à l\'évènement')->route('platform.evenementinscription.list'),
        Menu::make('Partenaires')->route('platform.partenaire.list'),
        Menu::make('Sliders')->route('platform.slider.list'),
        Menu::make('Services')->route('platform.service.list'),
        Menu::make('Chiffres clés')->route('platform.chiffre.list'),
        Menu::make('Témoignages')->route('platform.temoignage.list'),
        Menu::make('Contacts')->route('platform.contact.list'),
        Menu::make('Commentaires')->route('platform.commentaire.list'),
        Menu::make('FAQs')->route('platform.faq.list'),
                ]),

            Menu::make('Membres & entreprises')
                ->icon('bs.bag')
                ->list([
        Menu::make('Membres')->route('platform.membre.list'),
        Menu::make('Documents')->route('platform.document.list'),
        Menu::make('Entreprises')->route('platform.entreprise.list'),
        Menu::make('Membres de l\'entreprise')->route('platform.entreprisemembre.list'),
        Menu::make('Pièces')->route('platform.piece.list'),
                ]),

            Menu::make('Diagnostics')
                ->icon('bs.bag')
                ->list([
        Menu::make('Diagnostics')->route('platform.diagnostic.list'),
        Menu::make('Modules des diagnostics')->route('platform.diagnosticmodule.list'),
        Menu::make('Questions des diagnostics')->route('platform.diagnosticquestion.list'),
        Menu::make('Réponses des diagnostics')->route('platform.diagnosticreponse.list'),
        Menu::make('Résultats des diagnostics')->route('platform.diagnosticresultat.list'),
                ]),

            Menu::make('Accompagnements')
                ->icon('bs.bag')
                ->list([
        Menu::make('Accompagnements')->route('platform.accompagnement.list'),
        Menu::make('Plans d\'accompagnements')->route('platform.plan.list'),
        Menu::make('Documents d\'accompagnement')->route('platform.accompagnementdocument.list'),
        Menu::make('Suivis')->route('platform.suivi.list'),
                ]),

            Menu::make('Prestations & formations')
                ->icon('bs.bag')
                ->list([
        Menu::make('Prestations')->route('platform.prestation.list'),
        Menu::make('Paiements des prestations')->route('platform.prestationressource.list'),
        Menu::make('Prestations realisées')->route('platform.prestationrealisee.list'),
        Menu::make('Formations')->route('platform.formation.list'),
        Menu::make('Participants')->route('platform.participant.list'),
        Menu::make('Paiements des formations')->route('platform.formationressource.list'),
                ]),

            Menu::make('Ressources')
                ->icon('bs.bag')
                ->list([
        Menu::make('Ressources')->route('platform.ressourcecompte.list'),
        Menu::make('Transactions des ressources')->route('platform.ressourcetransaction.list'),
        Menu::make('Conversions')->route('platform.conversion.list'),
        Menu::make('Parrainages')->route('platform.parrainage.list'),
        Menu::make('Bons')->route('platform.bon.list'),
        Menu::make('Bons utilisés')->route('platform.bonutilise.list'),
        Menu::make('Crédits')->route('platform.credit.list'),
        Menu::make('Echéanciers des crédits')->route('platform.echeancier.list'),
                ]),

            Menu::make('Messagerie')
                ->icon('bs.bag')
                ->list([
        Menu::make('Forums')->route('platform.forum.list'),
        Menu::make('Sujets')->route('platform.sujet.list'),
        Menu::make('Messages des forums')->route('platform.messageforum.list'),
        Menu::make('Conversations')->route('platform.conversation.list'),
        Menu::make('Messages')->route('platform.message.list'),
                ]),

            Menu::make('Experts & conseillers')
                ->icon('bs.bag')
                ->list([
        Menu::make('Experts')->route('platform.expert.list'),
        Menu::make('Disponibilités des experts')->route('platform.disponibilite.list'),
        Menu::make('Evaluations')->route('platform.evaluation.list'),
        Menu::make('Conseillers')->route('platform.conseiller.list'),
        Menu::make('Attribution de conseillers')->route('platform.conseillerentreprise.list'),
        Menu::make('Prescriptions des conseillers')->route('platform.conseillerprescription.list'),
        Menu::make('Conseillers des accompagnements')->route('platform.accompagnementconseiller.list'),
                ]),

            Menu::make('Espaces physiques')
                ->icon('bs.bag')
                ->list([
        Menu::make('Espaces physiques')->route('platform.espace.list'),
        Menu::make('Réservations')->route('platform.reservation.list'),
        Menu::make('Paiements des espaces')->route('platform.espaceressource.list'),
                ]),

            Menu::make('Autres modules')
                ->icon('bs.bag')
                ->list([
        Menu::make('Alertes')/*->icon('bag')*/->route('platform.alerte.list'),
                ]),

            Menu::make('Quiz')
                ->icon('bs.bag')
                ->list([
        Menu::make('Quiz')->route('platform.quiz.list'),
        Menu::make('Question du quiz')->route('platform.quizquestion.list'),
        Menu::make('Reponse du quiz')->route('platform.quizreponse.list'),
        Menu::make('Resultats du membre du quiz')->route('platform.quizmembre.list'),
        Menu::make('Resultats du quiz')->route('platform.quizresultat.list'),
        Menu::make('Actions')->route('platform.action.list'),
        Menu::make('Récompenses')->route('platform.recompense.list'),
                ]),

            Menu::make('Paramètres')
                ->icon('bs.gear')
                ->list([
                    Menu::make('Newsletters')->route('platform.newsletter.list'),
                    Menu::make('Types de paiement')->route('platform.ressourcetypeoffretype.list'),
                    Menu::make('Statuts de membres')->route('platform.membrestatut'),
                    Menu::make('Statuts d\'accompagnements')->route('platform.accompagnementstatut'),
                    Menu::make('Statuts de la prestation realisée')->route('platform.prestationrealiseestatut'),
                    Menu::make('Statuts du paiement')->route('platform.paiementstatut'),
                    Menu::make('Statuts de suivis')->route('platform.suivistatut'),
                    Menu::make('Statuts de crédit')->route('platform.creditstatut'),
                    Menu::make('Statuts de bons')->route('platform.bonstatut'),
                    Menu::make('Statuts de la réservation')->route('platform.reservationstatut'),
                    Menu::make('Statuts des participants')->route('platform.participantstatut'),
                    Menu::make('Statuts des dossiers')->route('platform.dossierstatut'),
                    Menu::make('Statuts d\'échéanciers')->route('platform.echeancierstatut'),
                    Menu::make('Statuts des diagnostics')->route('platform.diagnosticstatut'),

                    Menu::make('Types d\'entreprises')->route('platform.entreprisetype'),
                    Menu::make('Types de prestations')->route('platform.prestationtype'),
                    Menu::make('Types de pieces')->route('platform.piecetype'),
                    Menu::make('Types de suivis')->route('platform.suivitype'),
                    Menu::make('Types de veilles')->route('platform.veilletype'),
                    Menu::make('Types de bons')->route('platform.bontype'),
                    Menu::make('Types de forums')->route('platform.forumtype'),
                    Menu::make('Types de documents')->route('platform.documenttype'),
                    Menu::make('Types d\'espaces')->route('platform.espacetype'),
                    Menu::make('Types de recommandations')->route('platform.recommandationtype'),
                    Menu::make('Types de partenaires')->route('platform.partenairetype'),
                    Menu::make('Types d\'activités des partenaires')->route('platform.partenaireactivitetype'),
                    Menu::make('Types d\'alertes')->route('platform.alertetype'),
                    Menu::make('Types d\'actualités')->route('platform.actualitetype'),
                    Menu::make('Types d\'inscription à un évènement')->route('platform.evenementinscriptiontype'),
                    Menu::make('Types de sliders')->route('platform.slidertype'),
                    Menu::make('Types de contacts')->route('platform.contacttype'),
                    Menu::make('Types de membres')->route('platform.membretype'),
                    Menu::make('Types de credits')->route('platform.credittype'),
                    Menu::make('Profil émotionnel')->route('platform.diagnostictype'),
                    Menu::make('Types des modules du diagnostic')->route('platform.diagnosticmoduletype'),
                    Menu::make('Types des questions du diagnostic')->route('platform.diagnosticquestiontype'),
                    Menu::make('Categories des questions du diagnostic')->route('platform.diagnosticquestioncategorie'),
                    Menu::make('Types d\'évènements')->route('platform.evenementtype'),
                    Menu::make('Types de ressources')->route('platform.ressourcetype'),
                    Menu::make('Types de operations')->route('platform.operationtype'),
                    Menu::make('Types de offres')->route('platform.offretype'),
                    Menu::make('Types des questions du quiz')->route('platform.quizquestiontype'),

                    Menu::make('Secteurs')->route('platform.secteur'),
                    Menu::make('Niveaux d\'accompagnements')->route('platform.accompagnementniveau'),
                    Menu::make('Validation d\'experts')->route('platform.expertvalide'),
                    Menu::make('Types d\'experts')->route('platform.experttype'),
                    Menu::make('Origines des recommandations')->route('platform.recommandationorigine'),
                    Menu::make('Niveaux des formations')->route('platform.formationniveau'),
                    Menu::make('Types des formations')->route('platform.formationtype'),
                    Menu::make('Langues')->route('platform.langue.list'),   
                    Menu::make('Jours')->route('platform.jour'),
                    Menu::make('Validation de conseillers')->route('platform.conseillervalide'),
                    Menu::make('Types de conseillers')->route('platform.conseillertype'),
                    Menu::make('Types des newsletters')->route('platform.newslettertype'),

                    Menu::make('Types d\'accompagnements')->route('platform.accompagnementtype'),
                    Menu::make('Types des questions du quiz')->route('platform.quizquestiontype'),
                    Menu::make('Statuts des resultats du quiz')->route('platform.quizresultatstatut'),

                    //->title('Tools'),
                    // Tu peux ajouter d’autres sous-menus ici :
                    // Menu::make('Sexes')->route(...),
                    // Menu::make('Types de client')->route(...),
                ]),

        ];
        
    }

    /**
     * Register permissions for the application.
     *
     * @return ItemPermission[]
     */
    public function permissions(): array
    {
        return [
            ItemPermission::group(__('System'))
                ->addPermission('platform.systems.roles', __('Roles'))
                ->addPermission('platform.systems.users', __('Users')),
        ];
    }
}
