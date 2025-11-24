<?php

namespace App\Models\Ticket;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TicketStatus extends Model
{
    protected $table = 'ticket_statuses';

    protected $fillable = ['name', 'type'];

    // Связи

    public function tickets(): HasMany
    {
        return $this->hasMany(Ticket::class);
    }
}
