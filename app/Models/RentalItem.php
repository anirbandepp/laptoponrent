<?php

namespace App\Models;

use App\Models\Rental;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RentalItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'category', 'quantity', 'rent_quantity', 'amount', 'subscription_date', 'rental_id', 'description', 'customer_id', 'status'
    ];

    public function rental()
    {
        return $this->belongsTo(Rental::class);
    }

    public function invoice()
    {
        return $this->belongsTo(Invoice::class, 'rental_id', 'id');
    }
}
