<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Screen\AsSource;

class Quizquestiontype extends Model
{
    use HasFactory, AsSource;

    protected $table = 'quizquestiontypes'; 

    protected $fillable = [
        'titre',
        'etat',
    ];
}
