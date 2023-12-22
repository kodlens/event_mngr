<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventFile extends Model
{
    
    use HasFactory;

    
    protected $primaryKey = 'event_file_id';
    protected $table = 'event_files';

    protected $fillable = [
        'event_id',
        'event_filename',
        'event_file_path',
       
    ];

}
