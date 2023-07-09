<?php

namespace App\Models\QueryRepositories;
use App\Models\Reservation;
use Illuminate\Http\Request;
class ReservationRepository
{

    public static function getReservationsByDate(string $date)
    {
        return Reservation::where('reservation_day', $date)->get();
    }

    public static function getReservationByDateAndId(string $date, int $id)
    {
        return Reservation::where('reservation_day', $date)
            ->where('seat_id',$id)
            ->first();
    }

    public static function makeNewReservation(string $date, int $id): void
    {
         Reservation::create([
            'seat_id'=>$id,
            'reservation_day'=>$date,
            'reserved_at'=> now()
        ]);

    }


    public static function updateReservation($reservation): void
    {
        $reservation->update([
            'reserved_at' => now()
        ]);

    }

    public static function getOngoingReservations(string $date,array $seatsId){
        return Reservation::where('reservation_day', $date)
            ->whereIn('seat_id', $seatsId)
            ->get();
    }

    public static function finalizeReservation($reservations,$email)
    {
        $reservations->each(function ($reservation) use ($email) {
            $reservation->finalization_email = $email;
            $reservation->save();
        });
    }


}
