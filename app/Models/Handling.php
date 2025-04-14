<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Handling extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function complaint(): BelongsTo
    {
        return $this->belongsTo(Complaint::class);
    }

    public function sale(): BelongsTo
    {
        return $this->belongsTo(Sale::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function rescheduleHistory(): HasMany
    {
        return $this->hasMany(RescheduleHistory::class);
    }

    public function resolvedComplaint(): HasOne
    {
        return $this->hasOne(ResolvedComplaint::class);
    }
}
