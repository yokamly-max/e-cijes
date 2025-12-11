<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Screen\AsSource;

class Experttype extends Model
{
    use HasFactory, AsSource;

    protected $table = 'experttypes'; 

    protected $fillable = [
        'titre',
        'etat',
    ];
}
