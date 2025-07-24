<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
// use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    protected $primaryKey = 'category_id';
    protected $table = 'categories';

    protected $fillable = [
        'parent_category_id',
        'category_name',
        'description',
        'icon_url',
        'is_active'
    ];

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'parent_category_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(Category::class, 'parent_category_id');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeParentCategories($query)
    {
        return $query->whereNull('parent_category_id');
    }

    // FOR BUSINESS LETER I ADD
    public function businesses()
    {
        return $this->belongsToMany(Business::class, 'business_categories', 'category_id', 'business_id');
    }

    // use HasFactory, SoftDeletes;
    // use HasFactory;

    // protected $primaryKey = 'category_id';
    // protected $table = 'categories';
    // public $incrementing = true;

    // protected $fillable = [
    //     'parent_category_id',
    //     'category_name',
    //     'description',
    //     'icon_url',
    //     'is_active'
    // ];

    // protected $casts = [
    //     'is_active' => 'boolean',
    //     'created_at' => 'datetime',
    //     'updated_at' => 'datetime'
    // ];

    // // Relationship to parent category
    // public function parent()
    // {
    //     return $this->belongsTo(Category::class, 'parent_category_id', 'category_id');
    // }

    // // Relationship to child categories
    // public function children()
    // {
    //     return $this->hasMany(Category::class, 'parent_category_id', 'category_id');
    // }

    // // Scope for active categories
    // public function scopeActive($query)
    // {
    //     return $query->where('is_active', true);
    // }

    // // Scope for parent categories (top-level)
    // public function scopeParentCategories($query)
    // {
    //     return $query->whereNull('parent_category_id');
    // }
}
