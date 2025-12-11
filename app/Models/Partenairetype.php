<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Screen\AsSource;

class Partenairetype extends Model
{
    use HasFactory, AsSource;

    protected $table = 'partenairetypes'; 

    protected $fillable = [
        'titre',
        'etat',
    ];
}
