<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventVenue extends Model
{
    use HasFactory;


    protected $primaryKey = 'event_venue_id';
    protected $table = 'event_venues';

    protected $fillable = [
        'event_venue',
        'active',
       
    ];


}
