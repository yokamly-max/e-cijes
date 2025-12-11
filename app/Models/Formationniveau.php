<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Screen\AsSource;

class Formationniveau extends Model
{
    use HasFactory, AsSource;

    protected $table = 'formationniveaus'; 

    protected $fillable = [
        'titre',
        'etat',
    ];
}
