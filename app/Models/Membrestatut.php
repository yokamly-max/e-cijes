<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Screen\AsSource;

class Membrestatut extends Model
{
    use HasFactory, AsSource;

    protected $table = 'membrestatuts'; 

    protected $fillable = [
        'titre',
        'etat',
    ];
}
