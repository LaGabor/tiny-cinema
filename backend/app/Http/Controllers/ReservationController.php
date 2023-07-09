<?php

namespace App\Http\Controllers;

use App\Models\QueryRepositories\ReservationRepository;
use DateTime;
use DateTimeZone;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ReservationController extends Controller
{

    function getReservationsByDate(Request $request, SeatController $seatController): Response
    {
        $reservations = ReservationRepository::getReservationsByDate($request->date);
        $reservationsStatus = $this->seatsStatusByDateResult($reservations);
        $seats = $seatController->getAllSeats();
        return response(['reservationsStatus'=>$reservationsStatus,'seats'=>$seats], 200);
    }

    function reserveSeat(Request $request): Response
    {
        if(!$this->checkWithinWeek($request->date)){
            return response(['message' => ["Date error!"]],Response::HTTP_CONFLICT);
        }
        $reservations = ReservationRepository::getReservationByDateAndId($request->date,$request->seatId);
        $reservationStatuses = $this->seatStatusByDateAndId($reservations,$request->date,$request->seatId);
        return response($reservationStatuses, 200);
    }

    function buySeats(Request $request,MailController $mailController): Response
    {
        $reservations = ReservationRepository::getOngoingReservations($request->date,$request->seatsId);
        if($reservations === null){
            response(['message' => ["Invalid booking attempt!"]], Response::HTTP_CONFLICT);
        }
        if($this->bookSeats($reservations)){
            if($mailController->sendMail($request->date,$request->seatsId,$request->email)){
                ReservationRepository::finalizeReservation($reservations,$request->email);
                return response(['booked'=>true], 200);
            }
            return response(['message' => ["Email error!"]], Response::HTTP_CONFLICT);
        };
        $reservationsByDate = ReservationRepository::getReservationsByDate($request->date);
        $reservationsStatus = $this->seatsStatusByDateResult($reservationsByDate);
        return response(['booked'=>false,'reservationsStatus'=>$reservationsStatus], 200);
    }


    private function seatsStatusByDateResult($reservations): array
    {
        $seatsStatus = ['free','free'];
        if($reservations === null) return $seatsStatus;
        foreach($reservations as $reservation){
            if($reservation->finalization_email != null){
                $seatsStatus[$reservation->seat_id-1] = 'sold';
            }elseif ($this->lessThanTwoMinutes($reservation->reserved_at)){
                $seatsStatus[$reservation->seat_id-1] = 'reserved';
            }
        }
        return $seatsStatus;
    }
    private function lessThanTwoMinutes($reservationTime): bool
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
        if($this->lessThanTwoMinutes($reservation->reserved_at)){
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
        foreach ($reservations as $reservation){
            if ($reservation->finalization_email != null){
                return false;
            }
            if(!($this->lessThanTwoMinutes($reservation->reserved_at))){
                return false;
            }
        }
        return true;
    }

    function checkWithinWeek($date):bool{
        $inputDate = strtotime($date);
        $currentDate = strtotime('today');
        $weekLater = strtotime("+1 week", $currentDate);
        return ($inputDate >= $currentDate && $inputDate <= $weekLater);
    }


}
