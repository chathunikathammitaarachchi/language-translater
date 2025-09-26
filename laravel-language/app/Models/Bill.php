<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Bill extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'bill_number', 
        'bill_date',
        'total_amount',
        'notes'
    ];

    // මෙය එකතු කරන්න - dates automatically Carbon instances බවට convert වේ
    protected $dates = [
        'bill_date',
        'created_at',
        'updated_at'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(BillItem::class);
    }
}