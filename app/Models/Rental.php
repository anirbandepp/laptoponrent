<?php

namespace App\Models;

use App\Models\RentalItem;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Rental extends Model
{
    use HasFactory;

    protected $fillable = [
        'subscription_date', 'subscription_date_end', 'time_period', 'customer_id', 
        'total_amount', 'status', 'deposit_amount', 'unique_rental_id', 'agreement_id', 
        'agreement_sign', 'agreement_doc', 'agreement_status'
    ];

    public function rentals()
    {
        return $this->hasMany(RentalItem::class);
    }
    

    public function delete()
    {
        // delete all associated photos
        $this->rentals()->delete();

        // delete the user
        return parent::delete();
    }
}
