<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Orchid\Screen\AsSource;
use Orchid\Attachment\Attachable;

class Messageforum extends Model
{
    use AsSource, Attachable;

    protected $table = 'messageforums';

    /**
     * @var array
     */
    protected $fillable = [
        'contenu',
        'sujet_id',
        'membre_id',
        'spotlight',
        'etat',
    ];
    
    public function sujet()
    {
        return $this->belongsTo(Sujet::class);
    }

    public function membre()
    {
        return $this->belongsTo(Membre::class);
    }

}
