<?php

namespace App\Models;

use App\Models\User;
use App\Models\AccessPin;
use App\Traits\HasWebsiteId;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Payment extends Model
{
    use HasFactory, HasWebsiteId;

    const STATUS_PENDING = 'pending',
        STATUS_SUCCESS = 'successful',
        STATUS_FAILED = 'failed',
        STATUS_CANCELLED = 'cancelled';

    protected $fillable = [
        'user_id',
        'access_pin_id',
        'reference_no',
        'currency',
        'amount',
        'payment_method',
        'transaction_id',
        'status',
        'paid_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }


    public function accessPin()
    {
        return $this->belongsTo(AccessPin::class, 'access_pin_id');
    }
}
