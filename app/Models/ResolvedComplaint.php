<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ResolvedComplaint extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function handling(): BelongsTo
    {
        return $this->belongsTo(Handling::class);
    }
}
