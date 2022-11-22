<?php

namespace App\Http\Controllers;
use App\Mail\mySweetMailing;
use App\Models\mySweetMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;


class mailController extends Controller
{
    private $emailRules = [
        'email' => 'email|max:30|min:10'
    ];
    private $emailMessages = [
        'email.email' => "Email has wrong format",
        'email.max' => 'Email should has maximum 30 characters',
        'email.min' => 'Email should has min 10 characters'
    ];
    private $codeRules = [
        'verification_code' => "digits:5"
    ];
    private $codeMessages = [
        'verification_code.digits' => "The verification code should consist of only 5 digits",
    ];
    public function sendVerificationCode(Request $req){
        $validator = Validator::make($req->toArray(), $this->emailRules, $this->emailMessages);
        if($validator->fails())
            return redirect('/')->withErrors($validator->errors());
        Mail::to($req->email)->send(new mySweetMailing($req->email));
        return redirect('/')->with('sent', $req->email);
    }

    public function checkVerificaitonCode(Request $req){
        $validator = Validator::make($req->toArray(), $this->codeRules, $this->codeMessages);
        if($validator->fails())
            return redirect('/')->with('sent' , $req->email)->withErrors($validator->errors());
        $mySweetMail = mySweetMail::whereEmail($req->email)->first();
        if($mySweetMail->verification_code == $req->verification_code)
            return redirect('/')->with("success", "verification code is true");
        else
            return redirect('/')->withErrors(['The verification code is wrong']);
    }
}
