<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Screen\AsSource;

class Documenttype extends Model
{
    use HasFactory, AsSource;

    protected $table = 'documenttypes'; 

    protected $fillable = [
        'titre',
        'etat',
    ];
}
