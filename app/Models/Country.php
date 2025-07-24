<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $fillable = ['shortname', 'name', 'phonecode'];

    public function states()
    {
        return $this->hasMany(State::class);
    }
}
