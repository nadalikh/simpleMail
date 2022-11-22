<?php

namespace App\Http\Controllers;
use App\Mail\mySweetMailing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class mailController extends Controller
{
    public function index(){
        $mail = new mySweetMailing();
        Mail::to("nadalikh@gmail.com")->send($mail);
    }
}
