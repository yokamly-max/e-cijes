<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Orchid\Screen\AsSource;
use Orchid\Attachment\Attachable;

class Espace extends Model
{
    use AsSource, Attachable;

    protected $table = 'espaces';

    /**
     * @var array
     */
    protected $fillable = [
        'titre',
        'capacite',
        'resume',
        'prix',
        'description',
        'vignette',
        'espacetype_id',
        'pays_id',
        'spotlight',
        'etat',
    ];

    public function espacetype()
    {
        return $this->belongsTo(Espacetype::class);
    }

    public function pays()
    {
        return $this->belongsTo(Pays::class);
    }

}
