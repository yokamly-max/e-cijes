<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Screen\AsSource;

class Credittype extends Model
{
    use HasFactory, AsSource;

    protected $table = 'credittypes'; 

    protected $fillable = [
        'titre',
        'etat',
    ];
}
