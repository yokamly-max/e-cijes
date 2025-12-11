<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Screen\AsSource;

class Creditstatut extends Model
{
    use HasFactory, AsSource;

    protected $table = 'creditstatuts'; 

    protected $fillable = [
        'titre',
        'etat',
    ];
}
