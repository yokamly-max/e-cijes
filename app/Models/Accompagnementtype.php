<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Screen\AsSource;

class Accompagnementtype extends Model
{
    use HasFactory, AsSource;

    protected $table = 'accompagnementtypes'; 

    protected $fillable = [
        'titre',
        'etat',
    ];
}
