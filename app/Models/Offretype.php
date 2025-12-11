<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Screen\AsSource;

class Offretype extends Model
{
    use HasFactory, AsSource;

    protected $table = 'offretypes'; 

    protected $fillable = [
        'titre',
        'etat',
    ];
}
