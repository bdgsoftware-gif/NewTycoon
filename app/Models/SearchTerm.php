<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SearchTerm extends Model
{
    protected $table = 'search_terms';
    protected $fillable = ['term', 'search_count', 'last_searched_at'];
    protected $casts = [
        'last_searched_at' => 'datetime',
    ];
}
