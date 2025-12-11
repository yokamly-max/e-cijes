<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Orchid\Screen\AsSource;
use Orchid\Attachment\Attachable;

class Quartier extends Model
{
    use AsSource, Attachable;

    protected $table = 'quartiers';

    /**
     * @var array
     */
    protected $fillable = [
        'nom',
        'commune_id',
        'etat',
    ];

    public function commune()
    {
        return $this->belongsTo(Commune::class);
    }

}
