<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Orchid\Screen\AsSource;
use Orchid\Attachment\Attachable;

class Commune extends Model
{
    use AsSource, Attachable;

    protected $table = 'communes';

    /**
     * @var array
     */
    protected $fillable = [
        'nom',
        'prefecture_id',
        'etat',
    ];

    public function prefecture()
    {
        return $this->belongsTo(Prefecture::class);
    }

    public function quartiers()
    {
        return $this->hasMany(Quartier::class);
    }

}
