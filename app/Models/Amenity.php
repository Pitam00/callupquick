<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Amenity extends Model
{
    use HasFactory;

    protected $primaryKey = 'amenity_id';
    protected $table = 'business_amenities';
    public $incrementing = true;

    protected $fillable = [
        'amenity_name',
        'icon_url',
        'category_id'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function businesses()
    {
        return $this->belongsToMany(Business::class, 'business_amenity_mappings', 'amenity_id', 'business_id');
    }
}
