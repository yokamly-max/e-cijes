<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Screen\AsSource;

class Membretype extends Model
{
    use HasFactory, AsSource;

    protected $table = 'membretypes'; 

    protected $fillable = [
        'titre',
        'etat',
    ];
}
