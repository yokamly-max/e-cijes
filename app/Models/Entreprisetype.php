<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Screen\AsSource;

class Entreprisetype extends Model
{
    use HasFactory, AsSource;

    protected $table = 'entreprisetypes'; 

    protected $fillable = [
        'titre',
        'etat',
    ];
}
