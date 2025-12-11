<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Screen\AsSource;

class Operationtype extends Model
{
    use HasFactory, AsSource;

    protected $table = 'operationtypes'; 

    protected $fillable = [
        'titre',
        'etat',
    ];
}
