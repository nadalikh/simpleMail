<?php

namespace App\Http\Controllers;
use App\Mail\mySweetMailing;
use App\Models\mySweetMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;


class mailController extends Controller
{
    /**
     * @var string[] is used for email rules validation
     */
    private $emailRules = [
        'email' => 'email|max:30|min:10'
    ];

    /**
     * @var string[] is used for email message validation
     */
    private $emailMessages = [
        'email.email' => "Email has wrong format",
        'email.max' => 'Email should has maximum 30 characters',
        'email.min' => 'Email should has min 10 characters'
    ];

    /**
     * @var string[] is used for verification code rules validation
     */
    private $codeRules = [
        'verification_code' => "digits:5"
    ];

    /**
     * @var string[] is used for verificatin code message validation
     */
    private $codeMessages = [
        'verification_code.digits' => "The verification code should consist of only 5 digits",
    ];

    /**
     * @param Request $req
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Exception
     */
    public function sendVerificationCode(Request $req){
        $validator = Validator::make($req->toArray(), $this->emailRules, $this->emailMessages);
        if($validator->fails())
            return redirect('/')->withErrors($validator->errors());
        Mail::to($req->email)->send(new mySweetMailing($req->email));
        return redirect('/')->with('sent', $req->email);
    }

    /**
     * @param Request $req
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
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
