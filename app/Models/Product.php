<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'summary', 'slug', 'description', 'stock', 'price', 'offer_price', 'discount', 'size', 'condition', 'status', 'photo', 'vendor_id','brand_id', 'cat_id', 'child_cat_id', 'size'];

    public function category()
    {
        return $this->belongsTo(Category::class, 'cat_id');
    }
    public function childCategory()
    {
        return $this->belongsTo(Category::class, 'child_cat_id');
    }
    public function brand()
    {
        return $this->belongsTo(Brand::class, 'brand_id');
    }
    public function vendor()
    {
        return $this->belongsTo(User::class, 'vendor_id');
    }


}
