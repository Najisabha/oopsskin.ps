<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Section extends Model
{
    protected $fillable = [
        'main_category_id',
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
     * العلاقة مع الصنف الرئيسي
     */
    public function mainCategory(): BelongsTo
    {
        return $this->belongsTo(MainCategory::class);
    }

    /**
     * العلاقة مع الأنواع
     */
    public function types(): HasMany
    {
        return $this->hasMany(Type::class)->orderBy('sort_order');
    }

    /**
     * الحصول على الأنواع النشطة فقط
     */
    public function activeTypes(): HasMany
    {
        return $this->hasMany(Type::class)->where('is_active', true)->orderBy('sort_order');
    }
}

