<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    public function TenderQuestions()
    {
        return $this->belongsToMany(User::class, 'tender_questions', 'tender_id', 'question_id');
    }

    public function applicantAnswers()
    {
        return $this->hasMany(ApplicantAnswer::class, 'user_id');
    }

    public function Answer()
    {
        return $this->hasOne(AnswerType::class, 'id', 'answer_type_id');
    }
    public function tenders()
    {
        return $this->belongsToMany(
            Tender::class,
            'tender_questions',
            'question_id',
            'tender_id'
        );
    }
}
