<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Conversation extends Model
{
    protected $guarded = [];

    public function users(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function supportStaff(): BelongsTo
    {
        return $this->belongsTo(SupportStaff::class, 'support_staff_id');
    }

    public function messages(): HasMany
    {
        return $this->hasMany(Message::class);
    }

    public function scopeUnassignedWithMessages($query)
    {
        return $query->whereNull('support_staff_id')
            ->whereHas('messages')
            ->latest();
    }

    public function scopeAssignedTo($query, $supportStaffId)
    {
        return $query->where('support_staff_id', $supportStaffId)
            ->latest();
    }
}
