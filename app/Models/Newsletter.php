<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Orchid\Screen\AsSource;
use Orchid\Attachment\Attachable;

class Newsletter extends Model
{
    use AsSource, Attachable;

    protected $table = 'newsletters';

    /**
     * @var array
     */
    protected $fillable = [
        'nom',
        'email',
        'newslettertype_id',
        'pays_id',
        'spotlight',
        'etat',
    ];

    public function newslettertype()
    {
        return $this->belongsTo(Newslettertype::class);
    }

    public function pays()
    {
        return $this->belongsTo(Pays::class);
    }

}
