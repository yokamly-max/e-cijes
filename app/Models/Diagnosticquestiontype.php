<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Screen\AsSource;

class Diagnosticquestiontype extends Model
{
    use HasFactory, AsSource;

    protected $table = 'diagnosticquestiontypes'; 

    protected $fillable = [
        'titre',
        'etat',
    ];
}
