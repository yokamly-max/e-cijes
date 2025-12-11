<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Orchid\Screen\AsSource;
use Orchid\Attachment\Attachable;

class Chiffre extends Model
{
    use AsSource, Attachable;

    protected $table = 'chiffres';

    /**
     * @var array
     */
    protected $fillable = [
        'titre',
        'chiffre',
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
