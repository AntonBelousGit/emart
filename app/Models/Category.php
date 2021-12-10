<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'slug', 'summary', 'is_parent', 'parent_id', 'status', 'photo'];

    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public static function shiftChild($cat_id)
    {
        return Category::whereIn('id', $cat_id)->update(['is_parent' => 1]);
    }

    public static function getChildByParentID($id)
    {
        return Category::where('parent_id', $id)->pluck('title', 'id');
    }

    public function products(){
        return $this->hasMany(Product::class,'cat_id','id')->where('status','active');
    }
}
