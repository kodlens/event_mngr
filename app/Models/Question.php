<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;


    protected $primaryKey = 'question_id';
    protected $table = 'questions';

    protected $fillable = [
        'question',
        'input_type',
    ];


}
