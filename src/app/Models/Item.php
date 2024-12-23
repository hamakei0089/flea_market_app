<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'price',
        'description',
        'is_purchased',
    ];

    public function categories()
{
    return $this->belongsToMany(Category::class);
}
    public function condition()
{
    return $this->hasMany(Condition::class);
}
    public function purchase()
{
    return $this->hasMany(Purchase::class);
}


}
