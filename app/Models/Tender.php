<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tender extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'status',
        'start_date',
        'end_date',
        'winner_id',
        'award_status',
        'award_completed_at',
        'total_awarded_amount'
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'award_completed_at' => 'datetime',
        'total_awarded_amount' => 'decimal:2'
    ];
    public function CreatedBy()
    {
        return $this->hasOne(User::class, 'id', 'created_by');
    }
    // ============= العلاقات الأساسية =============

    /**
     * العناصر المرتبطة بالعطاء
     */
    public function tenderItems()
    {
        return $this->hasMany(TenderItem::class);
    }

    /**
     * الشركات المتقدمة للعطاء
     */
    public function applicantTenders()
    {
        return $this->hasMany(ApplicantTender::class);
    }

    /**
     * أسئلة العطاء
     */
    public function tenderQuestions()
    {
        return $this->hasMany(TenderQuestion::class);
    }

    /**
     * لجان العطاء
     */
    public function Committes()
    {
        return $this->belongsToMany(User::class, 'tender_committes', 'tender_id', 'user_id')
            ->withPivot('approval', 'committee_type');
    }


    /**
     * مرفقات العطاء
     */
    public function tenderAttachments()
    {
        return $this->hasMany(TenderAttachment::class);
    }

    /**
     * إرساءات العناصر الفردية (النظام الجديد)
     */
    public function itemAwards()
    {
        return $this->hasMany(TenderItemAward::class);
    }

    /**
     * الفائز بالعطاء (النظام القديم)
     */
    public function winner()
    {
        return $this->belongsTo(User::class, 'winner_id');
    }

    // ============= العلاقات المعقدة =============

    /**
     * المتقدمين للعطاء
     */
    public function applicants()
    {
        return $this->belongsToMany(User::class, 'applicant_tenders', 'tender_id', 'user_id')
            ->withTimestamps();
    }

    /**
     * أسئلة العطاء
     */
    public function questions()
    {
        return $this->belongsToMany(Question::class, 'tender_questions', 'tender_id', 'question_id')
            ->withTimestamps();
    }

    /**
     * عناصر العطاء مع التفاصيل
     */
    public function items()
    {
        return $this->belongsToMany(Item::class, 'tender_items', 'tender_id', 'item_id')
            ->withPivot(['id', 'quantity', 'award_status'])
            ->withTimestamps();
    }

    // ============= الخصائص المحسوبة (Attributes) =============

    /**
     * نسبة تقدم الإرساء
     */
    public function getAwardProgressAttribute()
    {
        $totalItems = $this->tenderItems()->count();
        if ($totalItems == 0) return 0;

        $awardedItems = $this->itemAwards()->count();
        return round(($awardedItems / $totalItems) * 100, 2);
    }

    // ============= الدوال المساعدة =============

    /**
     * التحقق من اكتمال إرساء جميع العناصر
     */
    public function isFullyAwarded()
    {
        $totalItems = $this->tenderItems()->count();
        $awardedItems = $this->itemAwards()->count();

        return $totalItems > 0 && $totalItems == $awardedItems;
    }

    /**
     * التحقق من وجود إرساء جزئي
     */
    public function isPartiallyAwarded()
    {
        return $this->itemAwards()->count() > 0 && !$this->isFullyAwarded();
    }

    /**
     * تحديث حالة العطاء بناءً على الإرساءات
     */
    public function updateAwardStatus()
    {
        $totalAwarded = $this->itemAwards()->sum('awarded_price');

        if ($this->isFullyAwarded()) {
            $this->update([
                'award_status' => 'fully_awarded',
                'award_completed_at' => now(),
                'total_awarded_amount' => $totalAwarded
            ]);
        } elseif ($this->isPartiallyAwarded()) {
            $this->update([
                'award_status' => 'partially_awarded',
                'total_awarded_amount' => $totalAwarded
            ]);
        } else {
            $this->update([
                'award_status' => 'open',
                'total_awarded_amount' => 0
            ]);
        }
    }

    /**
     * الحصول على الشركات الفائزة مع تجميعها
     */
    public function getWinningCompanies()
    {
        return $this->itemAwards()
            ->with('winner.companyInfo')
            ->get()
            ->groupBy('winner_user_id');
    }

    /**
     * إجمالي المبلغ المُرسى
     */
    public function getTotalAwardedAmount()
    {
        return $this->itemAwards()->sum('awarded_price');
    }

    /**
     * عدد العناصر المُرساة
     */
    public function getAwardedItemsCount()
    {
        return $this->itemAwards()->count();
    }

    /**
     * عدد العناصر المتبقية
     */
    public function getPendingItemsCount()
    {
        return $this->tenderItems()->count() - $this->getAwardedItemsCount();
    }

    /**
     * عدد الشركات الفائزة
     */
    public function getWinningCompaniesCount()
    {
        return $this->itemAwards()->distinct('winner_user_id')->count('winner_user_id');
    }
}
