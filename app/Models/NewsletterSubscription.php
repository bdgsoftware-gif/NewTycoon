<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NewsletterSubscription extends Model
{
    use HasFactory;

    protected $fillable = [
        'email',
        'user_id',
        'name',
        'is_active'
    ];

    protected $casts = [
        'subscribed_at' => 'datetime',
        'is_active' => 'boolean',
    ];

    /**
     * Get the user associated with the subscription
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope to get active subscriptions
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Check if email is already subscribed
     */
    public static function isSubscribed($email)
    {
        return self::where('email', $email)->active()->exists();
    }
}
