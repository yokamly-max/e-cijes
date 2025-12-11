<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Orchid\Screen\AsSource;
use Orchid\Attachment\Attachable;

class Diagnosticreponse extends Model
{
    use AsSource, Attachable;

    protected $table = 'diagnosticreponses';

    /**
     * @var array
     */
    protected $fillable = [
        'titre',
        'position',
        'score',
        'langue_id',
        'diagnosticquestion_id',
        'spotlight',
        'etat',
    ];
    

    public function diagnosticquestion()
    {
        return $this->belongsTo(Diagnosticquestion::class);
    }

}
