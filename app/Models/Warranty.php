<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Warranty extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function saleDetail()
    {
        return $this->belongsTo(SaleDetail::class);
    }
}
