<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MainCategory extends Model
{
    protected $fillable = [
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
     * العلاقة مع الأقسام
     */
    public function sections(): HasMany
    {
        return $this->hasMany(Section::class)->orderBy('sort_order');
    }

    /**
     * الحصول على الأقسام النشطة فقط
     */
    public function activeSections(): HasMany
    {
        return $this->hasMany(Section::class)->where('is_active', true)->orderBy('sort_order');
    }
}

