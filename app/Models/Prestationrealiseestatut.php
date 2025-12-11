<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Screen\AsSource;

class Prestationrealiseestatut extends Model
{
    use HasFactory, AsSource;

    protected $table = 'prestationrealiseestatuts'; 

    protected $fillable = [
        'titre',
        'etat',
    ];
}
