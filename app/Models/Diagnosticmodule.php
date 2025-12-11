<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Orchid\Screen\AsSource;
use Orchid\Attachment\Attachable;

class Diagnosticmodule extends Model
{
    use AsSource, Attachable;

    protected $table = 'diagnosticmodules';

    /**
     * @var array
     */
    protected $fillable = [
        'titre',
        'position',
        'description',
        'diagnosticmoduletype_id',
        'parent',
        'langue_id',
        'pays_id',
        'spotlight',
        'etat',
    ];
    

    public function diagnosticmoduletype()
    {
        return $this->belongsTo(Diagnosticmoduletype::class);
    }

    public function langue()
    {
        return $this->belongsTo(Langue::class);
    }

    public function moduleparent()
    {
        return $this->belongsTo(Diagnosticmodule::class, 'parent');
    }

    public function pays()
    {
        return $this->belongsTo(Pays::class);
    }

}
