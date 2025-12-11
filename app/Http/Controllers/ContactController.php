<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\Slider;
use App\Services\EmailService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;

class ContactController extends Controller
{
    
    public function formulaire()
    {
        $slider = Slider::where('etat', 1)->where('spotlight', 0)->where('slidertype_id', '=', 1)->inRandomOrder()->first();

        //afficher le formulaire d'ajout
        return view('contact.formulaire', compact('slider'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeformulaire(Request $request)
    {
        //traitement de l'ajout contact
        $request->validate([
            'nom' => 'required',
            'email' => 'required|email',
            'sujet' => 'required',
            'message' => 'required',
            //'confirme' => 'required',
        ]);


        $contact = new Contact();
        $contact->nom = $request->nom;
        $contact->email = $request->email;
        $contact->sujet = $request->sujet;
        $contact->message = $request->message;
        //$contact->date = $request->date;
        $contact->save();


        $emailSend = new EmailService();
        $subject = "Contacts sur ".env('APP_NAME');
        $message = "Bonjour ".$request->nom.", <br /><br />Vous venez de nous envoyer un message. <br />Votre message sera pris en compte. <br /><br />Merci de nous faire confiance.";
        $emailSend->sendEmail($subject, __('emailsite'), __('site_sigle'), $request->email, $request->nom, true, view('contact.mail', compact('subject', 'message')));

        $emailSend2 = new EmailService();
        $subject = "Contacts sur ".env('APP_NAME');
        $message = "Bonjour, <br /><br />".$request->nom." vient de deposer un message dans la rubrique <strong>Contacts</strong>. <br /><br />Message : <br /><strong>".$request->email."</strong><br /><strong>".$request->sujet."</strong><br />".$request->message."<br /><br />Merci de le prendre en compte.";
        $emailSend2->sendEmail($subject, __('emailsite'), __('site_sigle'), __('emailsite'), __('site_sigle'), true, view('contact.mail', compact('subject', 'message')));


        return redirect()->route('contact.formulaire')->with('status', 'Votre message a bien été enregistré.');


    }


}

