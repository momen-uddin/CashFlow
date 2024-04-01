<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustReceive extends Model
{
    use HasFactory;
    protected $table = 'cust_receives';
    protected $fillable = [
        'cust_id',
        'cust_name',
        'amount',
        'transaction_type',
        'transaction_id',
        'transDate',
    ];

    public function user()
    {

        return $this->belongsTo(User::class, 'cust_id');
    }

    public function agent()
    {

        return $this->belongsTo(User::class, 'agent_id');
    }
}
