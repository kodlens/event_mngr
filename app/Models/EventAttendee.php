<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventAttendee extends Model
{
    use HasFactory;


    
    protected $primaryKey = 'event_attendee_id';
    protected $table = 'event_attendees';

    protected $fillable = [
        'event_id',
        'user_id',
        'date_request',
        'status',
        'date_mark'
    ];


    public function event(){
        return $this->hasOne(Event::class, 'event_id', 'event_id');
    }

    public function user(){
        return $this->hasOne(User::class, 'user_id', 'user_id');
    }
}
