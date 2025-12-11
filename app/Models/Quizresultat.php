<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Orchid\Screen\AsSource;
use Orchid\Attachment\Attachable;

class Quizresultat extends Model
{
    use AsSource, Attachable;

    protected $table = 'quizresultats';

    /**
     * @var array
     */
    protected $fillable = [
        'score',
        'membre_id',
        'quiz_id',
        'quizresultatstatut_id',
        'spotlight',
        'etat',
    ];

    public function membre()
    {
        return $this->belongsTo(Membre::class);
    }

    public function quiz()
    {
        return $this->belongsTo(Quiz::class);
    }

    public function quizresultatstatut()
    {
        return $this->belongsTo(Quizresultatstatut::class);
    }


}
