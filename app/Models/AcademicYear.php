<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AcademicYear extends Model
{
    use HasFactory;

    protected $primaryKey = 'academic_year_id';
    protected $table = 'academic_years';

    protected $fillable = [
        'academic_year_code',
        'academic_year_desc',
        'active'
    ];

}
