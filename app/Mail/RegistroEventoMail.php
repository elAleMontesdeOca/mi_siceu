<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RegistroEventoMail extends Mailable
{
    use Queueable, SerializesModels;

    public $evento;
    public $qrBase64;

    public function __construct($evento, $qrBase64)
    {
        $this->evento = $evento;
        $this->qrBase64 = $qrBase64;
    }

    public function build()
    {
        return $this
            ->subject("Registro confirmado: {$this->evento->titulo}")
            ->markdown('emails.registro_qr');
    }
}
