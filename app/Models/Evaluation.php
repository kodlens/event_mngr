<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evaluation extends Model
{
    use HasFactory;

    protected $primaryKey = 'evaluation_id';
    protected $table = 'evaluations';

    protected $fillable = [
        'academic_year_id',
        'user_id',
        'event_id',
       
    ];



    public function academic_year(){
        return $this->hasOne(AcademicYear::class, 'academic_year_id', 'academic_year_id');
    }

    public function user(){
        return $this->hasOne(User::class, 'user_id', 'user_id');
    }

    public function answers(){
        return $this->hasMany(EvaluationAnswer::class, 'evaluation_id', 'evaluation_id');
    }

   

}
