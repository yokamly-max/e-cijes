<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Orchid\Screen\AsSource;
use Orchid\Attachment\Attachable;

class Echeancier extends Model
{
    use AsSource, Attachable;

    protected $table = 'echeanciers';

    /**
     * @var array
     */
    protected $fillable = [
        'montant',
        'echeancierstatut_id',
        'dateecheancier',
        'entreprise_id',
        'spotlight',
        'etat',
    ];
    
    public function echeancierstatut()
    {
        return $this->belongsTo(Echeancierstatut::class);
    }

    public function entreprise()
    {
        return $this->belongsTo(Entreprise::class);
    }

}
