<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Screen\AsSource;

class Accompagnementniveau extends Model
{
    use HasFactory, AsSource;

    protected $table = 'accompagnementniveaus'; 

    protected $fillable = [
        'titre',
        'etat',
    ];
}
