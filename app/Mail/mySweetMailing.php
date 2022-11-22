<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

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
    public function __construct()
    {
        //I just generate the code in constructor
        //This might throw an exception by using random_int that should not be handled.
        $this->code = random_int(10000, 99999);
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {
        return new Envelope(
            from: new Address("idealist619@gmail.com", "Nadali Khalili"),
            subject: 'Veryficatino code'
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
