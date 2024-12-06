<?php

namespace App\Models;

use App\Models\Customer;
use App\Models\DepositAmount;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'rental_id', 'payment', 'payment_status', 'payment_link', 'payment_link_id', 'description', 'payment_paid_date', 'customer_id', 'reference_id',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function rentals()
    {
        return $this->hasMany(RentalItem::class);
    }


    // public function depositAmounts()
    // {
    //     return $this->hasMany(DepositAmount::class);
    // }

    // public function delete()
    // {
    //     // delete all associated photos
    //     $this->rentals()->delete();

    //     // delete the user
    //     return parent::delete();
    // }

    public function rentalItems()
    {
        return $this->belongsTo(RentalItem::class, 'rental_id', 'rental_id');
    }
}
