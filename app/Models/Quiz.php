<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Orchid\Screen\AsSource;
use Orchid\Attachment\Attachable;

class Quiz extends Model
{
    use AsSource, Attachable;

    protected $table = 'quizs';

    /**
     * @var array
     */
    protected $fillable = [
        'titre',
        'seuil_reussite',
        'formation_id',
        'spotlight',
        'etat',
    ];

    public function formation()
    {
        return $this->belongsTo(Formation::class);
    }


}
