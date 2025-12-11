<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Screen\AsSource;

class Diagnosticmoduletype extends Model
{
    use HasFactory, AsSource;

    protected $table = 'diagnosticmoduletypes'; 

    protected $fillable = [
        'titre',
        'etat',
    ];
}
