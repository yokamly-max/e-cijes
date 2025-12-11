<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Screen\AsSource;

class Evenementinscriptiontype extends Model
{
    use HasFactory, AsSource;

    protected $table = 'evenementinscriptiontypes'; 

    protected $fillable = [
        'titre',
        'etat',
    ];
}
