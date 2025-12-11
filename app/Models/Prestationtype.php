<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Screen\AsSource;

class Prestationtype extends Model
{
    use HasFactory, AsSource;

    protected $table = 'prestationtypes'; 

    protected $fillable = [
        'titre',
        'etat',
    ];
}
