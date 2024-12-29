<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeaveRequest extends Model
{
    use HasFactory;

    protected $table = 'leave_requests';

    protected $fillable = [
        'user_id',        // يمكن أن يكون طالب أو معلم
        'parent_id',      // إذا كان الطلب من ولي الأمر
        'type',
        'date',
        'time',
        'reason',
        'status',
        'user_type',      // نوع المستخدم (طالب، معلم)
        'created_by'
    ];

    // علاقة مع المستخدم (طالب أو معلم)
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    // علاقة مع ولي الأمر
    public function parent()
    {
        return $this->belongsTo(User::class, 'parent_id', 'id');
    }

    // علاقة مع من أنشأ الطلب
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }
    // دالة لتحويل النوع إلى نص عربي
    public function getTypeTextAttribute()
    {
        return $this->type == 'early' ? 'خروج مبكر' : 'نهاية الدوام';
    }

    // دالة لتحويل الحالة إلى نص عربي
    public function getStatusTextAttribute()
    {
        switch($this->status) {
            case 0:
                return 'قيد الانتظار';
            case 1:
                return 'تمت الموافقة';
            case 2:
                return 'مرفوض';
            default:
                return 'غير معروف';
        }
    }
}