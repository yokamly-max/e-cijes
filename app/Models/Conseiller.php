<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Orchid\Screen\AsSource;
use Orchid\Attachment\Attachable;

class Conseiller extends Model
{
    use AsSource, Attachable;

    protected $table = 'conseillers';

    /**
     * @var array
     */
    protected $fillable = [
        'fonction',
        'conseillervalide_id',
        'conseillertype_id',
        'membre_id',
        'spotlight',
        'etat',
    ];
    
    public function conseillervalide()
    {
        return $this->belongsTo(Conseillervalide::class);
    }

    public function conseillertype()
    {
        return $this->belongsTo(Conseillertype::class);
    }

    public function membre()
    {
        return $this->belongsTo(Membre::class);
    }

}
