<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Reservation extends Model
{
    use HasFactory;


    protected $fillable = ['seat_id', 'reserved_at', 'finalization_email','reservation_day'];

    public function seat(): BelongsTo
    {
        return $this->belongsTo(Seat::class);
    }

}
