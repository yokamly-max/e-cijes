<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Orchid\Screen\AsSource;
use Orchid\Attachment\Attachable;

class Pagelibre extends Model
{
    use AsSource, Attachable;

    protected $table = 'pagelibres';

    /**
     * @var array
     */
    protected $fillable = [
        'titre',
        'resume',
        'description',
        'langue_id',
        'vignette',
        'parent',
        'spotlight',
        'etat',
    ];
    
    public function langue()
    {
        return $this->belongsTo(Langue::class);
    }

    public function pageparent()
    {
        return $this->belongsTo(Pagelibre::class, 'parent');
    }

}
