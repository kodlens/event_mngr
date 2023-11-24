<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EvaluationAnswer extends Model
{
    use HasFactory;

    protected $primaryKey = 'evaluation_answer_id';
    protected $table = 'evaluation_answers';

    protected $fillable = [
        'evaluation_id',
        'question_id',
        'rating',
       
    ];



    public function event(){
        return $this->belongsTo(Evaluation::class, 'evaluation_id', 'evaluation_id');
    }


    

}
