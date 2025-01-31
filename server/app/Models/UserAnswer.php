<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAnswer extends Model
{
    use HasFactory;

    protected $fillable = ['quiz_id', 'question_id', 'answer_id', 'user_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function question()
    {
        return $this->belongsTo(QuizQuestion::class, 'question_id');
    }

    public function options()
    {
        return $this->belongsTo(QuestionOption::class, 'answer_id');
    }

    public function quiz()
    {
        return $this->belongsTo(Quiz::class);
    }
}
