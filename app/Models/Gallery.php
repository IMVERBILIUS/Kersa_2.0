<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Gallery extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'author', 'title', 'location', 'function', 'land_area',
        'building_area', 'thumbnail', 'status', 'views', 'description'
    ];

    public function subtitles()
    {
        return $this->hasMany(GallerySubtitle::class);
    }

    public function images()
    {
        return $this->hasMany(GalleryImage::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
