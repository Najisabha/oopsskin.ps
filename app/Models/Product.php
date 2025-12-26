<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
    protected $fillable = [
        'type_id',
        'main_category_id',
        'section_id',
        'name',
        'name_en',
        'slug',
        'sku',
        'description',
        'short_description',
        'price',
        'compare_price',
        'discount_percentage',
        'stock_quantity',
        'is_active',
        'is_featured',
        'is_new',
        'rating',
        'reviews_count',
        'images',
        'meta_title',
        'meta_description',
        'sort_order'
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'compare_price' => 'decimal:2',
        'discount_percentage' => 'decimal:2',
        'stock_quantity' => 'integer',
        'is_active' => 'boolean',
        'is_featured' => 'boolean',
        'is_new' => 'boolean',
        'rating' => 'decimal:1',
        'reviews_count' => 'integer',
        'images' => 'array',
        'sort_order' => 'integer'
    ];

    /**
     * العلاقة مع النوع
     */
    public function type(): BelongsTo
    {
        return $this->belongsTo(Type::class);
    }

    /**
     * العلاقة مع الصنف الرئيسي
     */
    public function mainCategory(): BelongsTo
    {
        return $this->belongsTo(MainCategory::class);
    }

    /**
     * العلاقة مع القسم
     */
    public function section(): BelongsTo
    {
        return $this->belongsTo(Section::class);
    }

    /**
     * الحصول على الصورة الرئيسية
     */
    public function getImageAttribute(): string
    {
        if ($this->images && is_array($this->images) && count($this->images) > 0) {
            return $this->images[0];
        }
        return 'https://images.unsplash.com/photo-1586495777744-4413f21062fa?w=300&h=300&fit=crop';
    }

    /**
     * الحصول على السعر بعد الخصم
     */
    public function getFinalPriceAttribute(): float
    {
        if ($this->discount_percentage > 0) {
            return $this->price * (1 - ($this->discount_percentage / 100));
        }
        return $this->price;
    }

    /**
     * Scope للمنتجات النشطة
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope للمنتجات المميزة
     */
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    /**
     * Scope للمنتجات الجديدة
     */
    public function scopeNew($query)
    {
        return $query->where('is_new', true);
    }
}

