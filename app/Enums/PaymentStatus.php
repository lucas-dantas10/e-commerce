<?php 

namespace App\Enums;

enum PaymentStatus: string 
{
    case Pending = 'pendente';
    case Paid = 'pago';
    case Failed = 'falha';
}
