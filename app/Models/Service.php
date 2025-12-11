<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Orchid\Screen\AsSource;
use Orchid\Attachment\Attachable;

class Service extends Model
{
    use AsSource, Attachable;

    protected $table = 'services';

    /**
     * @var array
     */
    protected $fillable = [
        'titre',
        'resume',
        'description',
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
