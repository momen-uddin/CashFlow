<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustSents extends Model
{
    use HasFactory;
    protected $table = 'cust_sents';
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
        // return $this->hasMany(User::class, 'id', 'agent_id');
        return $this->belongsTo(User::class, 'cust_id');
    }
}
