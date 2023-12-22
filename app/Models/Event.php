<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $primaryKey = 'event_id';
    protected $table = 'events';

    protected $fillable = [
        'academic_year_id',
        'user_id',
        'event_type_id',
        'event_venue_id',
        'event',
        'event_content',
        'if_others',
  
        'event_date_from',
        'event_date_to',

        'event_time_from',
        'event_time_to',

        'img_path',
        'file_path',

        'approval_status',
        'is_open',
        'is_need_approval',

        'approve_by',
        'approve_by_id',

        'is_archive',
        'archive_date',
        'ao_user_id',
        'remarks_decline'
    ];



    public function academic_year(){
        return $this->hasOne(AcademicYear::class, 'academic_year_id', 'academic_year_id');
    }

    public function event_type(){
        return $this->hasOne(EventType::class, 'event_type_id', 'event_type_id');
    }

    public function user(){
        return $this->hasOne(User::class, 'user_id', 'user_id');
    }

    public function venue(){
        return $this->hasOne(EventVenue::class, 'event_venue_id', 'event_venue_id');
    }


    public function event_files(){
        return $this->hasMany(EventFile::class, 'event_id', 'event_id');
    }


    public function approving_officer(){
        return $this->hasOne(User::class, 'user_id', 'ao_user_id');
    }

    

}
