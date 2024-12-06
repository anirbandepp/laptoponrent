<?php

namespace App\Models;

use App\Models\Invoice;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'rental_for', 'companyname', 'mobile', 'email', 'email_verified', 'rand_id', 'password', 'address', 'city', 'postcode', 'state', 'country', 'adhar',
    ];

    protected function documents()
    {
       return $this->hasOne(Document::class);
    }
    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }
}
