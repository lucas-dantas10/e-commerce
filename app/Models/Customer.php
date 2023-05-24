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

    protected $foreignKey = 'user_id';

    protected $fillables = [
        'first_name', 
        'last_name', 
        'email',
        'phone', 
        'status',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'customer_id', $this->foreignKey);
    }

    private function _getAddresses(): HasOne
    {
        return $this->hasOne(CustomerAddress::class, 'customer_id', $this->foreignKey);
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
