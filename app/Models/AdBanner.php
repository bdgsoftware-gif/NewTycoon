<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdBanner extends Model
{
    protected $fillable = ['title', 'images', 'link', 'is_active', 'order'];
    protected $casts = [
        'images' => 'array', // Automatically converts JSON to PHP Array
    ];

    public function setImagesAttribute($value)
    {
        $images = is_array($value) ? $value : json_decode($value, true);
        $this->attributes['images'] = json_encode(array_slice($images ?? [], 0, 3));
    }

    public function sections()
    {
        return $this->belongsToMany(Section::class, 'section_banners')
            ->withPivot('order', 'position')
            ->withTimestamps();
    }
}
