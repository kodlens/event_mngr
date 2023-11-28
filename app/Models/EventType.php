<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventType extends Model
{
    use HasFactory;

    protected $primaryKey = 'event_type_id';
    protected $table = 'event_types';

    protected $fillable = [
        'event_type',
        'active',
       
    ];


   


}
