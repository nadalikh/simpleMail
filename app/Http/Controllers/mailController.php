<?php

namespace App\Http\Controllers;
use App\Mail\mySweetMailing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class mailController extends Controller
{
    public function sendVerificationCode(Request $req){
        $req->validate([
            'email' => 'email|max:30|min:10'
        ]);
        Mail::to($req->email)->send(new mySweetMailing());
    }

//    public function checkVerificaitonCode(){
//
//    }

}
