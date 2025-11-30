<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RecordatorioEventoMail extends Mailable
{
    use Queueable, SerializesModels;

    public $evento;
    public $user;

    public function __construct($evento, $user)
    {
        $this->evento = $evento;
        $this->user = $user;
    }

    public function build()
    {
        return $this
            ->subject("Recordatorio: {$this->evento->titulo} es mañana")
            ->markdown('emails.recordatorio');
    }
}
