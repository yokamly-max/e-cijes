<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Orchid\Screen\AsSource;
use Orchid\Attachment\Attachable;

class Sujet extends Model
{
    use AsSource, Attachable;

    protected $table = 'sujets';

    /**
     * @var array
     */
    protected $fillable = [
        'titre',
        'resume',
        'description',
        'vignette',
        'forum_id',
        'membre_id',
        'spotlight',
        'etat',
    ];
    
    public function forum()
    {
        return $this->belongsTo(Forum::class);
    }

    public function membre()
    {
        return $this->belongsTo(Membre::class);
    }

}
