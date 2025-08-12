<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tender extends Model
{
    use HasFactory;

    public function CreatedBy()
    {
        return $this->hasOne(User::class, 'id', 'created_by');
    }

    public function Committes()
    {
        return $this->belongsToMany(User::class, 'tender_committes', 'tender_id', 'user_id')
            ->withPivot('approval', 'committee_type');
    }


    public function Questions()
    {
        return $this->belongsToMany(Question::class, 'tender_questions', 'tender_id', 'question_id');
    }


    public function TenderApplicants()
    {
        return $this->belongsToMany(User::class, 'applicant_tenders', 'tender_id', 'user_id');
    }

    public function items()
    {
        return $this->hasMany(TenderItem::class, 'tender_id');
    }

    public function applicantTenderItems()
    {
        return $this->hasMany(ApplicantTenderItem::class);
    }
}