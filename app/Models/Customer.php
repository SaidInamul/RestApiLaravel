<?php

namespace App\Models;

use App\Models\Invoice;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Customer extends Model
{
    /** @use HasFactory<\Database\Factories\CustomerFactory> */
    use HasFactory, HasApiTokens;

    protected $fillable = [
        'name',
        'email',
        'type',
        'address',
        'city',
        'state',
        'postal_code',
    ];
    
    public function invoices () {
        return $this->hasMany(Invoice::class);
    }
}
