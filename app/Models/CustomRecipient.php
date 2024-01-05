<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomRecipient extends Model
{
    use HasFactory;

    protected $primaryKey = 'custom_recipient_id';
    protected $table = 'custom_recipients';

    protected $fillable = [
        'event_id',
        'email'
    ];

}
