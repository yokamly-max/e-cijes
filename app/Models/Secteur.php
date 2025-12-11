<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Screen\AsSource;

class Secteur extends Model
{
    use HasFactory, AsSource;

    protected $table = 'secteurs'; 

    protected $fillable = [
        'titre',
        'etat',
    ];
}
