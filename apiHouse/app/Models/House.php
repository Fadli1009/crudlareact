<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class House extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'title', 'descriptions', 'price', 'location', 'status', 'bedrooms', 'bathroom', 'area', 'image'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function feature()
    {
        return $this->hasMany(Feature::class);
    }
}
