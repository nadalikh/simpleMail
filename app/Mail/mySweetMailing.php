<?php

namespace App\Mail;

use App\Models\mySweetMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use function PHPUnit\Framework\isNull;

class mySweetMailing extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var code is used to store the verification code
     */
    public int $code;


    /**
     * Create a new message instance.
     *
     * @return void
     * @throws \Exception
     */
    public function __construct($email)
    {
        //I just generate the code in constructor
        //This might throw an exception by using random_int that should not be handled.
        $this->code = random_int(10000, 99999);

        $mySweetMain = mySweetMail::whereEmail($email)->first();
        //check for the existed email
        if(is_null($mySweetMain)){
            //create new one
            $mySweetMain = new mySweetMail();
            $mySweetMain->email = $email;
            $mySweetMain->verification_code = $this->code;
            $mySweetMain->save();
        }else{
            //update the code
            $mySweetMain->verification_code = $this->code;
            $mySweetMain->update();
        }



    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {
        return new Envelope(
//            from: new Address("idealist619@gmail.com", "Nadali Khalili"),
            subject: 'Verification code'
        );
    }

    /**
     * Get the message content definition.
     *
     * @return \Illuminate\Mail\Mailables\Content
     */
    public function content()
    {

        return new Content(
            view: 'mails.mailTemplate',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array
     */
    public function attachments()
    {
        return [];
    }
}
