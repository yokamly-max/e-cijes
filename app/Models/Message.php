<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Orchid\Screen\AsSource;
use Orchid\Attachment\Attachable;

class Message extends Model
{
    use AsSource, Attachable;

    protected $table = 'messages';

    /**
     * @var array
     */
    protected $fillable = [
        'contenu',
        'conversation_id',
        'membre_id',
        'lu',
        'etat',
    ];
    
    public function conversation()
    {
        return $this->belongsTo(Conversation::class);
    }

    public function membre()
    {
        return $this->belongsTo(Membre::class);
    }

}
