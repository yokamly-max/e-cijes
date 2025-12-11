<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Screen\AsSource;

class Bonstatut extends Model
{
    use HasFactory, AsSource;

    protected $table = 'bonstatuts'; 

    protected $fillable = [
        'titre',
        'etat',
    ];
}
