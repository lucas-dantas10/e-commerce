<?php

namespace App\Enums;

enum AddressType: string
{
    case ShippingAddresses = 'shipping';
    case BillingAddresses = 'billing';
}
