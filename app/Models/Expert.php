<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Orchid\Screen\AsSource;
use Orchid\Attachment\Attachable;

class Expert extends Model
{
    use AsSource, Attachable;

    protected $table = 'experts';

    /**
     * @var array
     */
    protected $fillable = [
        'domaine',
        'expertvalide_id',
        'fichier',
        'experttype_id',
        'membre_id',
        'spotlight',
        'etat',
    ];
    
    public function expertvalide()
    {
        return $this->belongsTo(Expertvalide::class);
    }

    public function experttype()
    {
        return $this->belongsTo(Experttype::class);
    }

    public function membre()
    {
        return $this->belongsTo(Membre::class);
    }

}
