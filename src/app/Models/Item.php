<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'brand_name',
        'thumbnail',
        'price',
        'description',
        'is_purchased',
        'user_id',
        'condition_id',
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

    public function favoritedBy(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'favorites', 'item_id', 'user_id');
    }

    public function isFavoritedBy(User $user)
    {
        return $this->favoritedBy()->where('user_id', $user->id)->exists();
    }

    public function condition()
    {

    return $this->belongsTo(Condition::class);

    }

    public function purchase()

    {

    return $this->hasOne(Purchase::class);

    }


}
