<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Welcome extends Mailable
{
    use Queueable, SerializesModels;

    public string $name;

    /**
     * Create a new message instance.
     *
     * @param string $name
     */
    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function build()
    {
        return $this->markdown('emails.welcome')
                    ->subject('Bem-Vindo ao ' . config('app.name'));
    }
}
