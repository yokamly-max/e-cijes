<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Orchid\Screen\AsSource;
use Orchid\Attachment\Attachable;

class Bonutilise extends Model
{
    use AsSource, Attachable;

    protected $table = 'bonutilises';

    /**
     * @var array
     */
    protected $fillable = [
        'montant',
        'noteservice',
        'bon_id',
        'prestationrealisee_id',
        'spotlight',
        'etat',
    ];

    public function bon()
    {
        return $this->belongsTo(Bon::class);
    }

    public function prestationrealisee()
    {
        return $this->belongsTo(Prestationrealisee::class);
    }

}
