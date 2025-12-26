<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Type extends Model
{
    protected $fillable = [
        'section_id',
        'name',
        'name_en',
        'slug',
        'description',
        'image',
        'icon',
        'is_active',
        'sort_order'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer'
    ];

    /**
     * العلاقة مع القسم
     */
    public function section(): BelongsTo
    {
        return $this->belongsTo(Section::class);
    }

    /**
     * العلاقة مع المنتجات
     */
    public function products(): HasMany
    {
        return $this->hasMany(Product::class)->orderBy('created_at', 'desc');
    }

    /**
     * الحصول على المنتجات النشطة فقط
     */
    public function activeProducts(): HasMany
    {
        return $this->hasMany(Product::class)->where('is_active', true)->orderBy('created_at', 'desc');
    }

    /**
     * الحصول على عدد المنتجات
     */
    public function getProductsCountAttribute(): int
    {
        return $this->activeProducts()->count();
    }
}

