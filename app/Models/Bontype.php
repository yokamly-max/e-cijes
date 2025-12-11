<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Screen\AsSource;

class Bontype extends Model
{
    use HasFactory, AsSource;

    protected $table = 'bontypes'; 

    protected $fillable = [
        'titre',
        'etat',
    ];
}
