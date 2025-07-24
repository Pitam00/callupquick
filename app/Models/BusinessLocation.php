<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BusinessLocation extends Model
{
    use HasFactory;

    protected $primaryKey = 'location_id';
    public $incrementing = true;

    protected $fillable = [
        'business_id',
        'address_line1',
        'address_line2',
        'landmark',
        'city',
        'state',
        'country',
        'postal_code',
        'latitude',
        'longitude',
        'is_primary'
    ];

    protected $casts = [
        'is_primary' => 'boolean',
        'latitude' => 'float',
        'longitude' => 'float',
    ];

    public function business()
    {
        return $this->belongsTo(Business::class, 'business_id');
    }
}
