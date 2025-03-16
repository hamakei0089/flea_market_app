<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    use HasFactory;
    protected $fillable = [
        'item_id',
        'user_id',
        'payment_method_id',
        'post_code',
        'address',
        'building',
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    public function payment_methods()
    {
        return $this->belongsTo(PaymentMethod::class);
    }

    public function messages()
    {
        return $this->hasMany(Message::class, 'item_id', 'item_id');
    }

}
