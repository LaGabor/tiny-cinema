<?php
namespace App\Http\Controllers;

use App\Mail\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Exception;

class MailController extends Controller
{
    public function sendMail(string $date,array $seatsId,string $email):bool{

        try {
            Mail::to($email)->send(new Reservation($date,$seatsId));
            return true;
        }catch (Exception $e){
            return false;
        }

    }
}
