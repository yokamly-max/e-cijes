<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Orchid\Screen\AsSource;
use Orchid\Attachment\Attachable;

class Commentaire extends Model
{
    use AsSource, Attachable;

    protected $table = 'commentaires';

    /**
     * @var array
     */
    protected $fillable = [
        'nom',
        'email',
        'message',
        'actualite_id',
        'pays_id',
        'etat',
    ];
    
    public function actualite()
    {
        return $this->belongsTo(Actualite::class);
    }

    public function pays()
    {
        return $this->belongsTo(Pays::class);
    }

}
