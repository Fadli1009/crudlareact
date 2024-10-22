<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feature extends Model
{
    use HasFactory;
    protected $fillable = ['feature_name', 'id_house'];

    public function house()
    {
        return $this->belongsTo(House::class, 'id_house', 'id');
    }
}
