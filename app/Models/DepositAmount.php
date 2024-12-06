<?php

namespace App\Models;

use App\Models\Invoice;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DepositAmount extends Model
{
    use HasFactory;

    protected $fillable = [
        'deposit_amount', 'customer_id', 'invoice_id'
    ];

    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }
}
