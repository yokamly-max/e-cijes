<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Screen\AsSource;

class Evenementtype extends Model
{
    use HasFactory, AsSource;

    protected $table = 'evenementtypes'; 

    protected $fillable = [
        'titre',
        'etat',
    ];
}
