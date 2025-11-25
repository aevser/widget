<?php

namespace App\Models\Ticket;

use App\Models\Customer\Customer;
use App\Traits\Ticket\Filter\Filter;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Ticket extends Model implements HasMedia
{
    use InteractsWithMedia, Filter;

    protected $fillable = [
        'customer_id',
        'status_id',
        'subject',
        'message',
        'manager_replied_at'
    ];

    protected $casts = ['manager_replied_at' => 'datetime'];

    protected $appends = ['attachments_urls'];

    protected $hidden = ['media'];

    // Вспомогательные методы

    protected function attachmentsUrls(): Attribute
    {
        return Attribute::make(
            get: function () {
                return $this->getMedia('attachments')->map(function ($media) {
                    return [
                        'id' => $media->id,
                        'url' => $media->getUrl(),
                    ];
                })->toArray();
            }
        );
    }

    // Связи

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function status(): BelongsTo
    {
        return $this->belongsTo(TicketStatus::class);
    }

    public function replies(): HasMany
    {
        return $this->hasMany(TicketReply::class);
    }
}
