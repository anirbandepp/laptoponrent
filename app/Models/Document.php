<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'adhar_card',
        'pan_card',
        'electricity_bill',
        'property_tax_bill',
        'gst_certificate',
        'corporate_pan_card',
        'office_rental_agreement',
        'incorporation_certificate',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
    
}
