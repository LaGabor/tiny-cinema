<?php

namespace App\Models\QueryRepositories;

use App\Models\Seat;
use Illuminate\Database\Eloquent\Collection;

class SeatRepository
{

    public static function getAllSeats(): Collection
    {
        return Seat::all();
    }

}
