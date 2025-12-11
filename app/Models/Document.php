<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Orchid\Screen\AsSource;
use Orchid\Attachment\Attachable;

class Document extends Model
{
    use AsSource, Attachable;

    protected $table = 'documents';

    /**
     * @var array
     */
    protected $fillable = [
        'titre',
        'fichier',
        'documenttype_id',
        'datedocument',
        'membre_id',
        'spotlight',
        'etat',
    ];

    public function documenttype()
    {
        return $this->belongsTo(Documenttype::class);
    }

    public function membre()
    {
        return $this->belongsTo(Membre::class);
    }

}
