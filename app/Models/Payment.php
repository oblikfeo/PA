<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;

class Payment extends Model
{
    use AsSource, Filterable, HasFactory;

    protected $allowedFilters = [];
    protected $allowedSorts = ['id', 'payment_date', 'amount', 'created_at'];

    protected $fillable = [
        'client_id',
        'subscription_id',
        'amount',
        'payment_date',
        'payment_method',
        'notes',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'payment_date' => 'date',
    ];

    /**
     * Платёж без subscription_id = пополнение баланса клиента.
     * Платёж с subscription_id = фиксация оплаты абонемента (создаётся автоматически при покупке).
     */
    public function isTopUp(): bool
    {
        return empty($this->subscription_id);
    }

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function subscription(): BelongsTo
    {
        return $this->belongsTo(Subscription::class);
    }
}
