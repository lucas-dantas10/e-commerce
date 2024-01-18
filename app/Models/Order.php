<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'total_price',
        'status',
        'created_by',
        'updated_by',
    ];

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }

    public function user() 
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
