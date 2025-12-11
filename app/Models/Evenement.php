<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Orchid\Screen\AsSource;
use Orchid\Attachment\Attachable;

class Evenement extends Model
{
    use AsSource, Attachable;

    protected $table = 'evenements';

    /**
     * @var array
     */
    protected $fillable = [
        'titre',
        'resume',
        'description',
        'prix',
        'langue_id',
        'vignette',
        'evenementtype_id',
        'dateevenement',
        'pays_id',
        'spotlight',
        'etat',
    ];
    
    public function langue()
    {
        return $this->belongsTo(Langue::class);
    }

    public function evenementtype()
    {
        return $this->belongsTo(Evenementtype::class);
    }

    public function pays()
    {
        return $this->belongsTo(Pays::class);
    }

}
