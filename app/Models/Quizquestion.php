<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Orchid\Screen\AsSource;
use Orchid\Attachment\Attachable;

class Quizquestion extends Model
{
    use AsSource, Attachable;

    protected $table = 'quizquestions';

    /**
     * @var array
     */
    protected $fillable = [
        'titre',
        'point',
        'quiz_id',
        'quizquestiontype_id',
        'spotlight',
        'etat',
    ];

    public function quiz()
    {
        return $this->belongsTo(Quiz::class);
    }

    public function quizquestiontype()
    {
        return $this->belongsTo(Quizquestiontype::class);
    }


}
