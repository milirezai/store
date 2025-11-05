<?php
namespace App\Http\Services\Message\Mail;

use App\Http\Services\Message\Contract\Contract;
use App\Http\Services\Message\Mail\Support\MailService;

class Mail extends MailService
{
    public function send()
    {
        return $this->fire();
    }
}
