<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Screen\AsSource;

class Actualitetype extends Model
{
    use HasFactory, AsSource;

    protected $table = 'actualitetypes'; 

    protected $fillable = [
        'titre',
        'etat',
    ];
}
