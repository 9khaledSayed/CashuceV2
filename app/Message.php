<?php

namespace App;

use App\Notifications\NewMessage;
use App\Scopes\ParentScope;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $guarded = [];
    protected $casts = [
        'created_at'  => 'date:D M d Y',
    ];

    public static function booted()
    {
        static::created(static function ($message){
            $conversation = $message->conversation;
            if($message->sender_id == $conversation->hr_id){
                $conversation->employee->notify(new NewMessage($conversation->id));
            }else{
                $conversation->hr->notify(new NewMessage($conversation->id));
            }

        });

    }

    public function receiver()
    {
        return $this->belongsTo(Employee::class, 'receiver_id');
    }
    public function sender()
    {
        return $this->belongsTo(Employee::class, 'sender_id')->withoutGlobalScope(ParentScope::class);
    }

    public function conversation()
    {
        return $this->belongsTo(Conversation::class);
    }
}
