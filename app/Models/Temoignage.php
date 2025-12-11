<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Orchid\Screen\AsSource;
use Orchid\Attachment\Attachable;

class Temoignage extends Model
{
    use AsSource, Attachable;

    protected $table = 'temoignages';

    /**
     * @var array
     */
    protected $fillable = [
        'nom',
        'profil',
        'commentaire',
        'langue_id',
        'vignette',
        'pays_id',
        'spotlight',
        'etat',
    ];
    
    public function langue()
    {
        return $this->belongsTo(Langue::class);
    }

    public function pays()
    {
        return $this->belongsTo(Pays::class);
    }

}
