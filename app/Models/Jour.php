<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Screen\AsSource;

class Jour extends Model
{
    use HasFactory, AsSource;

    protected $table = 'jours'; 

    protected $fillable = [
        'titre',
        'etat',
    ];
}
