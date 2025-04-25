<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = ['user_id', 'total_price', 'paid_amount', 'change', 'transaction_time'];

    public function items() {
        return $this->hasMany(TransactionItem::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

}
