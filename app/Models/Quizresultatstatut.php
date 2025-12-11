<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Screen\AsSource;

class Quizresultatstatut extends Model
{
    use HasFactory, AsSource;

    protected $table = 'quizresultatstatuts'; 

    protected $fillable = [
        'titre',
        'etat',
    ];
}
