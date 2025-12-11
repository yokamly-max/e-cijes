<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Screen\AsSource;

class Piecetype extends Model
{
    use HasFactory, AsSource;

    protected $table = 'piecetypes'; 

    protected $fillable = [
        'titre',
        'etat',
    ];
}
