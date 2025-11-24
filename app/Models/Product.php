<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Product extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        'name', 'slug', 'description', 'price', 'stock', 'sku', 'image', 'category_id'
    ];


    /**
     * Get the category that owns the product.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Scope a query to only include products of a given category.
     */
    public function scopeOfCategory($query, $categoryId)
    {
        return $query->where('category_id', $categoryId);
    }

    /**
     * Mutator to format the price attribute.
     */
    public function getPriceAttribute($value)
    {
        return number_format($value, 2);
    }

    /**
     * Mutator to set the product name with first letter capitalized.
     */
    public function setNameAttribute($value)
    {
        $this->attributes['name'] = ucfirst($value);
    }
    
    /**
     * boot
     *
     * @return void
     */
    protected static function boot() {
        parent::boot();
        static::creating(function ($product) {
            $product->slug = Str::slug($product->name);
        });
    }

    public function getImageUrlAttribute()
    {
       if($this->image) {
           return Storage::getImageFile($this->image, $this->storage_id);
       }
    }
}
