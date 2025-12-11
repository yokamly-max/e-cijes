<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Orchid\Screen\AsSource;
use Orchid\Attachment\Attachable;

class Region extends Model
{
    use AsSource, Attachable;

    protected $table = 'regions';

    /**
     * @var array
     */
    protected $fillable = [
        'nom',
        'code',
        'pays_id',
        'etat',
    ];

    public function pays()
    {
        return $this->belongsTo(Pays::class);
    }

    public function prefectures()
    {
        return $this->hasMany(Prefecture::class);
    }

}
