<?php

namespace App\Http\Controllers;

use App\Models\QueryRepositories\ReservationRepository;
use DateTime;
use DateTimeZone;
use Illuminate\Http\Request;

class ReservationController extends Controller
{

    function getSeatsByDate(Request $request):array{

        $seats = ReservationRepository::getReservationsByDate($request->date);
        return $this->seatsStatusByDateResult($seats);

    }

    function reserveSeat(Request $request){
        $seat = ReservationRepository::getReservationByDateAndId($request->date,$request->seatId);
        return $this->seatStatusByDateAndId($seat,$request->date,$request->seatId);

    }

    function buySeats(Request $request,MailController $mailController): bool
    {
        $reservations = ReservationRepository::getOngoingReservations($request->date,$request->seatsId);
        if($this->bookSeats($reservations)){
            if($mailController->sendMail($request->date,$request->seatsId,$request->email)){
                ReservationRepository::finalizeReservation($reservations,$request->email);
                return true;
            }
            return false;
        };
        return false;
    }


    private function seatsStatusByDateResult($reservations){
        $seatsStatus = ['free','free'];
        if($reservations === null) return $seatsStatus;
        foreach($reservations as $reservation){
            if($reservation->finalization_email != null){
                $seatsStatus[$reservation->seat_id-1] = 'sold';
            }elseif ($this->secondsChecker($reservation->reserved_at)){
                $seatsStatus[$reservation->seat_id-1] = 'reserved';
            }
        }
        return $seatsStatus;
    }
    private function secondsChecker($reservationTime): bool
    {
        $reservationDateTime = new DateTime($reservationTime);
        $now = new DateTime();

        $reservationTimestamp = $reservationDateTime->getTimestamp();
        $currentTimestamp = $now->getTimestamp();

        $secondsDifference = $currentTimestamp - $reservationTimestamp;
        if ($secondsDifference < 120) {
            return true;
        }

        return false;
    }
    private function seatStatusByDateAndId($reservation, $reservationDate, $seatId): string
    {
        if($reservation === null){
            $this->makeNewReservation($reservationDate,$seatId);
            return 'success';
        }
        if($reservation->finalization_email != null) return 'sold';
        if($this->secondsChecker($reservation->reserved_at)){
            return 'reserved';
        }
        $this->updateFreeReservation($reservation);
        return 'success';
    }


    private function makeNewReservation($reservationDate,$seatId){
            ReservationRepository::makeNewReservation($reservationDate,$seatId);
    }

    private function updateFreeReservation($reservation){
        ReservationRepository::updateReservation($reservation);

    }

    private function bookSeats($reservations)
    {
        if($reservations === null){
            return false;
        }else{
            foreach ($reservations as $reservation){
                if ($reservation->finalization_email != null){
                    return false;
                }
                if(!($this->secondsChecker($reservation->reserved_at))){
                    return false;
                }
            }
        }
                return true;
    }


}
