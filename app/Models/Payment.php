<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

//    Status = succeeded pending canceled
//   refund_status = succeeded canceled
    protected $fillable = ['description', 'amount', 'project_id', 'user_id',
        'cancellation_reason', 'status', 'yoo_payment_id', 'payment_created',
        'refund_status', 'refund_id', 'refund_amount'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id');
    }

    public function awards()
    {
        return $this->belongsToMany(Award::class, 'payment_awards');
    }
}
