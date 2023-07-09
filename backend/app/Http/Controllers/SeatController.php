<?php

namespace App\Http\Controllers;

use App\Models\QueryRepositories\SeatRepository;
use Illuminate\Database\Eloquent\Collection;

class SeatController extends Controller
{

    function getAllSeats(): Collection
    {
        return SeatRepository::getAllSeats();
    }

}
