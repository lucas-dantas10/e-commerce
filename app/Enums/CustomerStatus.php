<?php 


namespace App\Enums;

enum CustomerStatus: string
{
    case Active = 'ativo';
    case Disabled = 'Inativo';
}