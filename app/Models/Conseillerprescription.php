<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Orchid\Screen\AsSource;
use Orchid\Attachment\Attachable;

class Conseillerprescription extends Model
{
    use AsSource, Attachable;

    protected $table = 'conseillerprescriptions';

    /**
     * @var array
     */
    protected $fillable = [
        'conseiller_id',
        'membre_id',
        'entreprise_id',
        'prestation_id',
        'formation_id',
        'spotlight',
        'etat',
    ];
    
    public function conseiller()
    {
        return $this->belongsTo(Conseiller::class);
    }

    public function membre()
    {
        return $this->belongsTo(Membre::class);
    }

    public function entreprise()
    {
        return $this->belongsTo(Entreprise::class);
    }

    public function formation()
    {
        return $this->belongsTo(Formation::class, 'formation_id');
    }

    public function prestation()
    {
        return $this->belongsTo(Prestation::class, 'prestation_id');
    }

}
