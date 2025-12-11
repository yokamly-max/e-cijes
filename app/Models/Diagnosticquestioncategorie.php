<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Screen\AsSource;

class Diagnosticquestioncategorie extends Model
{
    use HasFactory, AsSource;

    protected $table = 'diagnosticquestioncategories'; 

    protected $fillable = [
        'titre',
        'etat',
    ];
}
