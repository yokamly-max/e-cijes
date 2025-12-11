<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Screen\AsSource;

class Conseillertype extends Model
{
    use HasFactory, AsSource;

    protected $table = 'conseillertypes'; 

    protected $fillable = [
        'titre',
        'etat',
    ];
}
