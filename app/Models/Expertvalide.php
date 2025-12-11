<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Screen\AsSource;

class Expertvalide extends Model
{
    use HasFactory, AsSource;

    protected $table = 'expertvalides'; 

    protected $fillable = [
        'titre',
        'etat',
    ];
}
