<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Orchid\Screen\AsSource;
use Orchid\Attachment\Attachable;

class Prefecture extends Model
{
    use AsSource, Attachable;

    protected $table = 'prefectures';

    /**
     * @var array
     */
    protected $fillable = [
        'nom',
        'cheflieu',
        'region_id',
        'etat',
    ];

    public function region()
    {
        return $this->belongsTo(Region::class);
    }

    public function communes()
    {
        return $this->hasMany(Commune::class);
    }

}
