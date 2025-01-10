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

    public function user()
    {

    return $this->belongsTo(User::class);

    }

    public function categories()
    {

    return $this->belongsToMany(Category::class, 'category_item', 'item_id', 'category_id');

    }

    public function comments()
    {

    return $this->hasMany(Comment::class);

    }

    public function favorites()
    {

    return $this->hasMany(Favorite::class);

    }

    public function condition()
    {

    return $this->belongsTo(Condition::class);

    }

    public function purchases()

    {

    return $this->hasMany(Purchase::class);

    }


}
