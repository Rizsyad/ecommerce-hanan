<?php

namespace App\Models;

use App\Models\Category;
use App\Models\ProductImage;
use App\Models\ProductReviews;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    public function reviews()
    {
        return $this->hasMany(ProductReviews::class);
    }

    public function comments()
    {
        return $this->hasMany(CommentProduct::class);
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
