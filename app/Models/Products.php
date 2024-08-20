<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class Products extends Model
{
    protected $fillable = [
        'category_id',
        'sub_category_id',
        'brand_id',
        'title',
        'slug',
        'sku',
        'featured',
        'description',
        'specification',
        'condition',
        'images',
        'sale_price',
        'regular_price',
        'quantity',
        'tags',
        'meta_title',
        'meta_description',
        'publish_date'
    ];

    public $timestamps = false;

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($product) {
            $product->publish_date = Carbon::now('Asia/Dhaka');
            $slug = Str::lower(Str::slug($product->title . '-' . $product->sale_price . '-' . time()));
            $product->slug = $slug;
        });
    }

    protected $casts = [
        'featured' => 'array',
        'specification' => 'array',
        'images' => 'array',
        'tags' => 'array',
        'publish_date' => 'datetime'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function subcategory()
    {
        return $this->belongsTo(SubCategory::class, 'sub_category_id');
    }

    public function brand()
    {
        return $this->belongsTo(Brands::class, 'brand_id');
    }
}