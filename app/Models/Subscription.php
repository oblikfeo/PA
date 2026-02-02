<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;

class Subscription extends Model
{
    use AsSource, Filterable, HasFactory;

    protected $allowedFilters = [];
    protected $allowedSorts = ['id', 'purchase_date', 'expires_at', 'created_at'];

    protected $fillable = [
        'client_id',
        'subscription_type_id',
        'purchase_date',
        'expires_at',
        'lessons_remaining',
        'is_active',
    ];

    protected $casts = [
        'purchase_date' => 'date',
        'expires_at' => 'date',
        'lessons_remaining' => 'integer',
        'is_active' => 'boolean',
    ];

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function subscriptionType(): BelongsTo
    {
        return $this->belongsTo(SubscriptionType::class);
    }

    public function visits(): HasMany
    {
        return $this->hasMany(Visit::class);
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    public function paymentReminders(): HasMany
    {
        return $this->hasMany(PaymentReminder::class);
    }

    protected static function booted(): void
    {
        static::saving(function (Subscription $subscription): void {
            $type = $subscription->subscriptionType ?? ($subscription->subscription_type_id ? SubscriptionType::find($subscription->subscription_type_id) : null);
            if (!$subscription->exists && $type) {
                if ($subscription->lessons_remaining === null || $subscription->lessons_remaining === '') {
                    $subscription->lessons_remaining = $type->lessons_count ?? 0;
                }
                if (!$subscription->expires_at && $subscription->purchase_date && $type->validity_days) {
                    $subscription->expires_at = $subscription->purchase_date->copy()->addDays($type->validity_days);
                }
            }
        });
    }
}
