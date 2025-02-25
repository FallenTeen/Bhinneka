<?php

namespace App\Mail;

use App\Models\Registration;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RegistrationRejected extends Mailable
{
    use Queueable, SerializesModels;

    public $registration;
    public $rejectionMessage;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Registration $registration, $message)
    {
        $this->registration = $registration;
        $this->rejectionMessage = $message;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from(config('mail.from.address'), config('mail.from.name'))
            ->subject('Pendaftaran Ditangguhkan')
            ->markdown('emails.registration.rejected');
    }
}