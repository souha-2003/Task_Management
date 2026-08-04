<?php
namespace App\Traits;
use Illuminate\Database\Eloquent\Builder;
trait FilterableByCompletion
{
    /**
     * الحصول على اسم الحقل المخصص لحالة الإنجاز.
     */
    protected function getCompletedColumn(): string
    {
        return property_exists($this, 'completedColumn') ? $this->completedColumn : 'completed';
    }
    /**
     * نطاق جلب العناصر المكتملة فقط.
     */
    public function scopeCompleted(Builder $query): Builder
    {
        return $query->where('status', 'completed');
    }
    /**
     * نطاق جلب العناصر المعلقة (غير المكتملة) فقط.
     */
    public function scopePending(Builder $query): Builder
    {
        return $query->where('status', 'pending');
    }
    /**
     * نطاق جلب العناصر التي هي قيد العمل.
     */
    public function scopeInProgress(Builder $query): Builder
    {
        return $query->where('status', 'in_progress');
    }
    /**
     * نطاق جلب العناصر التي هي قيد المراجعة.
     */
    public function scopeReview(Builder $query): Builder
    {
        return $query->where('status', 'review');
    }
}