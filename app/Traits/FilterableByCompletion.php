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
        return $query->where($this->getCompletedColumn(), true);
    }
    /**
     * نطاق جلب العناصر المعلقة (غير المكتملة) فقط.
     */
    public function scopePending(Builder $query): Builder
    {
        return $query->where($this->getCompletedColumn(), false);
    }
}