<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    /** @use HasFactory<\Database\Factories\CourseFactory> */
    use HasFactory;
    protected $fillable = ['institution_id', 'study_level_id', 'name', 'duration_months', 'estimated_fee'];

    public function institution()
    {
        return $this->belongsTo(Institution::class);
    }

    public function studyLevel()
    {
        return $this->belongsTo(StudyLevel::class);
    }
}
