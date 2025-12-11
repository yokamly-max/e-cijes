<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Screen\AsSource;

class Accompagnementstatut extends Model
{
    use HasFactory, AsSource;

    protected $table = 'accompagnementstatuts'; 

    protected $fillable = [
        'titre',
        'etat',
    ];
}
