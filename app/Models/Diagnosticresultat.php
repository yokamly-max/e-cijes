<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Orchid\Screen\AsSource;
use Orchid\Attachment\Attachable;

class Diagnosticresultat extends Model
{
    use AsSource, Attachable;

    protected $table = 'diagnosticresultats';

    /**
     * @var array
     */
    protected $fillable = [
        'reponsetexte',
        'diagnosticreponseids',
        'diagnosticquestion_id',
        'diagnosticreponse_id',
        'diagnostic_id',
        'spotlight',
        'etat',
    ];
    
    public function diagnosticquestion()
    {
        return $this->belongsTo(Diagnosticquestion::class);
    }

    public function diagnosticreponse()
    {
        return $this->belongsTo(Diagnosticreponse::class);
    }

    public function diagnostic()
    {
        return $this->belongsTo(Diagnostic::class);
    }

}
