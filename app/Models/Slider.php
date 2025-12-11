<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Orchid\Screen\AsSource;
use Orchid\Attachment\Attachable;

class Slider extends Model
{
    use AsSource, Attachable;

    protected $table = 'sliders';

    /**
     * @var array
     */
    protected $fillable = [
        'titre',
        'resume',
        'description',
        'langue_id',
        'vignette',
        'slidertype_id',
        'lienurl',
        'pays_id',
        'spotlight',
        'etat',
    ];
    
    public function langue()
    {
        return $this->belongsTo(Langue::class);
    }

    public function slidertype()
    {
        return $this->belongsTo(Slidertype::class);
    }

    public function pays()
    {
        return $this->belongsTo(Pays::class);
    }

}
