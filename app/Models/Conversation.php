<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Orchid\Screen\AsSource;
use Orchid\Attachment\Attachable;

class Conversation extends Model
{
    use AsSource, Attachable;

    protected $table = 'conversations';

    /**
     * @var array
     */
    protected $fillable = [
        'membre_id1',
        'membre_id2',
        'spotlight',
        'etat',
    ];
    
    public function membre1()
    {
        return $this->belongsTo(Membre::class, 'membre_id1');
    }

    public function membre2()
    {
        return $this->belongsTo(Membre::class, 'membre_id2');
    }

}
