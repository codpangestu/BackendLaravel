<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'rating',
        'release_year',
        'category_id',
        'thumbnail'
    ];

    // Relasi: Movie belongsTo MovieCategory
    public function category()
    {
        return $this->belongsTo(MovieCategory::class, 'category_id');
    }
}
