<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Orchid\Screen\AsSource;
use Orchid\Attachment\Attachable;

class Contact extends Model
{
    use AsSource, Attachable;

    protected $table = 'contacts';

    /**
     * @var array
     */
    protected $fillable = [
        'nom',
        'email',
        'message',
        'contacttype_id',
        'pays_id',
        'etat',
    ];
    
    public function contacttype()
    {
        return $this->belongsTo(Contacttype::class);
    }

    public function pays()
    {
        return $this->belongsTo(Pays::class);
    }

}
