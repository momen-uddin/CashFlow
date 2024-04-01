<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class netMoney extends Model
{
    use HasFactory;
    protected $table = 'netMoneys';
    protected $primaryKey = 'id';

    protected $fillable = [
        'agent_id',
        'agent_name',
        'amount',
        'transaction_type',
        'transaction_id',
        'tansDate',
        'rate',
    ];

    public function user()
    {
        // return $this->hasMany(User::class, 'id', 'agent_id');
        return $this->belongsTo(User::class, 'agent_id');
    }

}
