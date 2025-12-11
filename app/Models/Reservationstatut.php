<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Screen\AsSource;

class Reservationstatut extends Model
{
    use HasFactory, AsSource;

    protected $table = 'reservationstatuts'; 

    protected $fillable = [
        'titre',
        'etat',
    ];
}
