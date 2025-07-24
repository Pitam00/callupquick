<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BusinessAmenityMapping extends Model
{
    use HasFactory;

    protected $table = 'business_amenity_mappings';

    protected $fillable = [
        'business_id',
        'amenity_id'
    ];

    public function business()
    {
        return $this->belongsTo(Business::class, 'business_id');
    }

    public function amenity()
    {
        return $this->belongsTo(Amenity::class, 'amenity_id');
    }
}
