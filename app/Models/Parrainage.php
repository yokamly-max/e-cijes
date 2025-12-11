<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Orchid\Screen\AsSource;
use Orchid\Attachment\Attachable;

class Parrainage extends Model
{
    use AsSource, Attachable;

    protected $table = 'parrainages';

    /**
     * @var array
     */
    protected $fillable = [
        'lien',
        'membre_parrain_id',
        'membre_filleul_id',
        'spotlight',
        'etat',
    ];
    
    public function membreparrain()
    {
        return $this->belongsTo(Membre::class, 'membre_parrain_id');
    }
    
    public function membrefilleul()
    {
        return $this->belongsTo(Membre::class, 'membre_filleul_id');
    }


}
