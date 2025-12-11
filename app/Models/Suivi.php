<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Orchid\Screen\AsSource;
use Orchid\Attachment\Attachable;

class Suivi extends Model
{
    use AsSource, Attachable;

    protected $table = 'suivis';

    /**
     * @var array
     */
    protected $fillable = [
        'observation',
        'suivistatut_id',
        'suivitype_id',
        'datesuivi',
        'accompagnement_id',
        'spotlight',
        'etat',
    ];
    
    public function suivistatut()
    {
        return $this->belongsTo(Suivistatut::class);
    }

    public function suivitype()
    {
        return $this->belongsTo(Suivitype::class);
    }

    public function accompagnement()
    {
        return $this->belongsTo(Accompagnement::class);
    }

}
