<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function CompanyInfo()
    {
        return $this->hasOne(CompanyInfo::class);
    }

    public function Tender()
    {
        return $this->belongsToMany(Tender::class);
    }

    public function TenderCommittes()
    {
        return $this->belongsToMany(User::class, 'tender_committes', 'tender_id', 'user_id')->withPivot('approval');;
    }

    public function TenderApplicants()
    {
        return $this->belongsToMany(User::class, 'applicant_tenders', 'tender_id', 'user_id')->withPivot('approval');
    }

    public function applicantAnswers()
    {
        return $this->hasMany(ApplicantAnswer::class, 'user_id');
    }

    public function applicantTenders()
    {
        return $this->hasMany(ApplicantTender::class, 'user_id');
    }

    public function applicantTenderItems()
    {
        return $this->hasManyThrough(
            ApplicantTenderItem::class,   // الجدول النهائي
            ApplicantTender::class,       // الجدول الوسيط
            'user_id',                    // foreign key في الجدول الوسيط (applicant_tenders)
            'applicant_tender_id',        // foreign key في الجدول النهائي (applicant_tender_items)
            'id',                         // local key في User
            'id'                          // local key في ApplicantTender
        );
    }

    public function wonItemAwards()
    {
        return $this->hasMany(TenderItemAward::class, 'winner_user_id');
    }

    public function wonTenders()
    {
        return $this->hasMany(Tender::class, 'winner_id');
    }

    // دوال مساعدة
    public function isCompany()
    {
        return $this->type == 2;
    }

    public function isAdmin()
    {
        return $this->type == 1;
    }

    public function getWonTendersCount()
    {
        return $this->wonItemAwards()->distinct('tender_id')->count();
    }

    public function getTotalWonAmount()
    {
        return $this->wonItemAwards()->sum('awarded_price');
    }
}
