<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Orchid\Screen\AsSource;
use Orchid\Attachment\Attachable;

class Diagnosticquestion extends Model
{
    use AsSource, Attachable;

    protected $table = 'diagnosticquestions';

    /**
     * @var array
     */
    protected $fillable = [
        'titre',
        'position',
        'diagnosticmodule_id',
        'diagnosticquestiontype_id',
        'diagnosticquestioncategorie_id',
        'langue_id',
        'obligatoire',
        'parent',
        'spotlight',
        'etat',
    ];
    
    public function diagnosticmodule()
    {
        return $this->belongsTo(Diagnosticmodule::class);
    }

    public function diagnosticquestiontype()
    {
        return $this->belongsTo(Diagnosticquestiontype::class);
    }

    public function diagnosticquestioncategorie()
    {
        return $this->belongsTo(Diagnosticquestioncategorie::class);
    }

    public function langue()
    {
        return $this->belongsTo(Langue::class);
    }

    public function questionparent()
    {
        return $this->belongsTo(Diagnosticquestion::class, 'parent');
    }

}
