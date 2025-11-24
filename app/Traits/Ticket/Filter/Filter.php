<?php

namespace App\Traits\Ticket\Filter;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;

trait Filter
{
    public function scopeApplyFilters(Builder $query, array $filters): Builder
    {
        return $query
            ->when(
                !empty($filters['status_id']),
                fn ($q) => $q->filterByStatusId(
                    is_array($filters['status_id']) ? $filters['status_id'] : [$filters['status_id']]
                )
            )
            ->when(
                !empty($filters['email']),
                fn ($q) => $q->filterByEmail($filters['email'])
            )
            ->when(
                !empty($filters['phone']),
                fn ($q) => $q->filterByPhone($filters['phone'])
            )
            ->when(
                !empty($filters['date_from']) || !empty($filters['date_to']),
                fn ($q) => $q->filterByCreatedAt(
                    $filters['date_from'] ?? null,
                    $filters['date_to'] ?? null
                )
            );
    }

    public function scopeFilterByStatusId(Builder $query, array $statusIds): Builder
    {
        return $query->whereIn('status_id', $statusIds);
    }

    public function scopeFilterByEmail(Builder $query, string $email): Builder
    {
        return $query->whereHas('customer', function ($q) use ($email) {
            $q->where('email', 'like', '%' . $email . '%');
        });
    }

    public function scopeFilterByPhone(Builder $query, string $phone): Builder
    {
        return $query->whereHas('customer', function ($q) use ($phone) {
            $q->where('phone', 'like', '%' . $phone . '%');
        });
    }

    public function scopeFilterByCreatedAt(Builder $query, ?string $dateFrom, ?string $dateTo): Builder
    {
        $dateFrom = $dateFrom ? Carbon::parse($dateFrom)->startOfDay() : Carbon::now()->subMonth()->startOfDay();
        $dateTo = $dateTo ? Carbon::parse($dateTo)->endOfDay() : Carbon::now()->endOfDay();

        return $query->whereBetween('created_at', [$dateFrom, $dateTo]);
    }
}
