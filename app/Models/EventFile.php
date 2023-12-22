<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventFile extends Model
{
    
    use HasFactory;

    
    protected $primaryKey = 'event_files';
    protected $table = 'event_file_id';

    protected $fillable = [
        'event_filename',
        'event_file_path',
       
    ];

}
