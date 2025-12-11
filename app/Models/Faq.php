<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Orchid\Screen\AsSource;
use Orchid\Attachment\Attachable;

class Faq extends Model
{
    use AsSource, Attachable;

    protected $table = 'faqs';

    /**
     * @var array
     */
    protected $fillable = [
        'question',
        'reponse',
        'langue_id',
        'pays_id',
        'spotlight',
        'etat',
    ];
    
    public function langue()
    {
        return $this->belongsTo(Langue::class);
    }

    public function pays()
    {
        return $this->belongsTo(Pays::class);
    }

}
