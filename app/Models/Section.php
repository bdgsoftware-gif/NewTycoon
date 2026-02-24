<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    protected $fillable = ['name', 'title', 'type', 'order', 'is_active', 'settings'];

    protected $casts = [
        'settings' => 'array',
        'is_active' => 'boolean',
    ];

    public function banners()
    {
        return $this->belongsToMany(AdBanner::class, 'section_banners')
            ->withPivot('order', 'position')
            ->withTimestamps()
            ->orderBy('section_banners.order'); // default order for pure banner sections
    }
}
