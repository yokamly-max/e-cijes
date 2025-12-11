<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Orchid\Screen\AsSource;
use Orchid\Attachment\Attachable;

class Quizreponse extends Model
{
    use AsSource, Attachable;

    protected $table = 'quizreponses';

    /**
     * @var array
     */
    protected $fillable = [
        'text',
        'correcte',
        'quizquestion_id',
        'spotlight',
        'etat',
    ];

    public function quizquestion()
    {
        return $this->belongsTo(Quizquestion::class);
    }


}
