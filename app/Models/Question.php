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
        'academic_year_id',
        'event_id',
        'order_no',
        'question',
        'input_type',
    ];


    public function event(){
        return $this->hasOne(Event::class, 'event_id', 'event_id');
    }
    public function academic_year(){
        return $this->hasOne(AcademicYear::class, 'academic_year_id', 'academic_year_id');
    }


}
