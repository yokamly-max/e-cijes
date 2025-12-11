<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Orchid\Screen\AsSource;
use Orchid\Attachment\Attachable;

class Actualite extends Model
{
    use AsSource, Attachable;

    protected $table = 'actualites';

    /**
     * @var array
     */
    protected $fillable = [
        'titre',
        'resume',
        'description',
        'langue_id',
        'vignette',
        'actualitetype_id',
        'dateactualite',
        'pays_id',
        'spotlight',
        'etat',
    ];
    
    public function langue()
    {
        return $this->belongsTo(Langue::class);
    }

    public function actualitetype()
    {
        return $this->belongsTo(Actualitetype::class);
    }

    public function pays()
    {
        return $this->belongsTo(Pays::class);
    }

}
