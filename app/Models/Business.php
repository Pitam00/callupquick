<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Business extends Model
{
    use HasFactory;

    protected $primaryKey = 'business_id';
    public $incrementing = true;

    protected $fillable = [
        'user_id',
        'business_name',
        'description',
        'establishment_year',
        'employee_count',
        'ownership_type',
        'website_url',
        'logo_url',
        'is_verified',
        'is_claimed'
    ];

    protected $casts = [
        'is_verified' => 'boolean',
        'is_claimed' => 'boolean',
        'establishment_year' => 'integer',
        'employee_count' => 'integer',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function location()
    {
        return $this->hasOne(BusinessLocation::class, 'business_id');
    }

    public function contacts()
    {
        return $this->hasMany(BusinessContact::class, 'business_id');
    }

    public function hours()
    {
        return $this->hasMany(BusinessHour::class, 'business_id');
    }

    public function categories()
    {
        return $this->hasMany(BusinessCategory::class, 'business_id');
    }

    public function amenities()
    {
        return $this->belongsToMany(Amenity::class, 'business_amenity_mappings', 'business_id', 'amenity_id');
    }

    public function photos()
    {
        return $this->hasMany(BusinessPhoto::class, 'business_id');
    }

    public function primaryCategory()
    {
        return $this->hasOne(BusinessCategory::class, 'business_id')->where('is_primary', true);
    }

    public function primaryContact()
    {
        return $this->hasOne(BusinessContact::class, 'business_id')->where('is_primary', true);
    }

    public function primaryLocation()
    {
        return $this->hasOne(BusinessLocation::class, 'business_id')->where('is_primary', true);
    }
}
