<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;


    public function scopeFilter($query)
    {
        $transaction_type = request('transaction_type') ?? 'all';


        if ($transaction_type =='Deposit') {
            $query->where('transaction_type', 'Deposit');
        }
        if ($transaction_type =='Withdraw') {
            $query->where('transaction_type', 'Withdraw');
        }

        return $query;
    }
}
