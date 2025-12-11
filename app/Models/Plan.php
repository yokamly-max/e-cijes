<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Orchid\Screen\AsSource;
use Orchid\Attachment\Attachable;

class Plan extends Model
{
    use AsSource, Attachable;

    protected $table = 'plans';

    /**
     * @var array
     */
    protected $fillable = [
        'objectif',
        'actionprioritaire',
        'dateplan',
        'accompagnement_id',
        'spotlight',
        'etat',
    ];

    public function accompagnement()
    {
        return $this->belongsTo(Accompagnement::class);
    }

}
