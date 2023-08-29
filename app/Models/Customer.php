<?php

namespace App\Models;

use App\Enums\AddressType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Customer extends Model
{
    use HasFactory;

    protected $primaryKey = 'user_id';

    protected $fillable = [
        'first_name', 
        'last_name',
        'phone', 
        'status',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    private function _getAddresses(): HasOne
    {
        return $this->hasOne(CustomerAddress::class, 'customer_id', 'user_id');
    }

    public function shippingAddresses(): HasOne
    {
        return $this->_getAddresses()->where('type', '=', AddressType::ShippingAddresses->value);
    }

    public function billingAddresses(): HasOne
    {
        return $this->_getAddresses()->where('type', '=', AddressType::BillingAddresses->value);
    }
}
