<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventAttendance extends Model
{
    use HasFactory;


    protected $primaryKey = 'event_attendance_id';
    protected $table = 'event_attendances';

    protected $fillable = [
        'event_id',
        'user_id',
        'in_am',
        'out_am',
        'in_pm',
        'out_pm'
    ];


    public function event(){
        return $this->hasOne(Event::class, 'event_id', 'event_id');
    }

    public function user(){
        return $this->hasOne(User::class, 'user_id', 'user_id');
    }

}
