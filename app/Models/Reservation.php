<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Orchid\Screen\AsSource;
use Orchid\Attachment\Attachable;

class Reservation extends Model
{
    use AsSource, Attachable;

    protected $table = 'reservations';

    /**
     * @var array
     */
    protected $fillable = [
        'observation',
        'reservationstatut_id',
        'espace_id',
        'datedebut',
        'datefin',
        'montant',
        'membre_id',
        'spotlight',
        'etat',
    ];
    
    public function reservationstatut()
    {
        return $this->belongsTo(Reservationstatut::class);
    }

    public function espace()
    {
        return $this->belongsTo(Espace::class);
    }

    public function membre()
    {
        return $this->belongsTo(Membre::class);
    }

}
