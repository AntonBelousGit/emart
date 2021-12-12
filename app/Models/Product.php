<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'summary', 'slug', 'description', 'stock', 'price', 'offer_price', 'discount', 'size_id', 'condition', 'status', 'photo', 'vendor_id','brand_id', 'cat_id', 'child_cat_id', 'size'];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'cat_id');
    }
    public function childCategory(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'child_cat_id');
    }
    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class, 'brand_id');
    }
    public function size(): BelongsTo
    {
        return $this->belongsTo(Size::class, 'size_id');
    }
    public function vendor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'vendor_id');
    }

    public function rel_products(): HasMany
    {
        return $this->hasMany(__CLASS__,'cat_id','cat_id')->where('status','active')->limit(10);
    }

    public static function getProductByCart($id)
    {
        return self::where('id',$id)->first();
    }

}
